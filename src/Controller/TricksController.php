<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Tricks;
use App\Entity\TrickComment;

use App\Form\TrickType;
use App\Form\TrickCommentType;

use App\Repository\TricksRepository;
use App\Repository\TrickCommentRepository;

class TricksController extends AbstractController
{

    /**
     * @Route("/{slug}", name="show_trick")
     */
    public function showTrick(Tricks $trick, Request $request, EntityManagerInterface $manager, TrickCommentRepository $TrickCommentRepo)
    {
        $trickComments = $TrickCommentRepo->findBy(["trick"=>$trick->getId()], ["dateCreate"=>"DESC"], $this->getParameter('perpage.comments'), 0);

        $trickComment = new TrickComment();
        $form = $this->createForm(TrickCommentType::class, $trickComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trickComment->setDateCreate(new \DateTime())
                         ->setTrick($trick)
                         ->setUserCreate($this->getUser())
                         ->setText(strip_tags($trickComment->getText()));

            $manager->persist($trickComment);
            $manager->flush();
            $this->addFlash('success', 'Votre commentaire à bien été ajouté,<br><strong>Merci</strong>.');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
        }
        return $this->render('snow/trick.twig', [
                "trick" => $trick,
                "trickComments" => $trickComments,
                "trickCommentForm" => $form->createView(),
                "maxComments" =>$this->getParameter('perpage.comments'),
                "maxImages" => $this->getParameter('perpage.images'),
                "maxVideos" => $this->getParameter('perpage.videos')
            ]);
    }

    /**
     * @Route("/trick/add", name="add_trick")
     */
    public function addFormTricks(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Tricks();
        $formTrick = $this->createForm(TrickType::class, $trick);
        $formTrick->handleRequest($request);
        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $trick->setDateCreate(new \DateTime())
                  ->setUserCreate($this->getUser())
                  ->setDateUpdate(new \DateTime())
                  ->setUserUpdate($this->getUser())
                  ->setSlug($trick->getName());

            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Votre Figure à bien été ajoutée,<br><strong>Merci</strong>.');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render('snow/formTrick.twig', [
            'formTrick' => $formTrick->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/trick/edit/{id}", name="edit_trick")
     */
    public function editFormTricks(Tricks $trick, Request $request, EntityManagerInterface $manager)
    {
        $formTrick = $this->createForm(TrickType::class, $trick);
        $formTrick->handleRequest($request);
        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $trick->setDateUpdate(new \DateTime())
                  ->setUserUpdate($this->getUser());

            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Votre Figure à bien été modifiée,<br><strong>Merci</strong>.');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
        }

        return $this->render('snow/formTrick.twig', [
            'formTrick' => $formTrick->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/trick/delete/{id}", name="delete_trick")
     */
    public function deleteTrick(Tricks $trick, EntityManagerInterface $manager)
    {
        $manager->remove($trick);
        $manager->flush();
        $this->addFlash('success', 'Votre figure à bien été supprimée,<br><strong>Merci</strong>.');
        return $this->redirectToRoute('home');
    }
    
}
