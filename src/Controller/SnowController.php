<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Users;
use App\Entity\Tricks;
use App\Entity\TrickGroup;
use App\Entity\TrickComment;

use App\Form\TrickType;
use App\Form\TrickCommentType;

use App\Repository\TricksRepository;

class SnowController extends AbstractController
{
    const NUMBER_OF_TRICKS_PER_PAGE = 4;
    const NUMBER_OF_IMAGES_PER_PAGE = 3;
    const NUMBER_OF_VIDEOS_PER_PAGE = 3;
    const NUMBER_OF_COMMENTS_PER_PAGE = 5;

    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / self::NUMBER_OF_TRICKS_PER_PAGE;
        // $nbPages = $nbTricks / Tricks::NUMBER_OF_TRICKS_PER_PAGE;
        $tricks = $trickRepo->findBy([], null, self::NUMBER_OF_TRICKS_PER_PAGE, 0);
        // findBy([], ["dateCreate"=>"DESC"],
        // attention il faudra revoir toute la pagination

        return $this->render('snow/home.twig', [
                "tricks" => $tricks,
                "pageNb" => 1,
                "nbPages" => $nbPages
            ]);
    }

    /**
     * @Route("/tricks/{id}", name="show_trick")
     */
    public function showTrick(Tricks $trick, Request $request, ObjectManager $manager)
    {
        $trickComment = new TrickComment();

        // $trickComment = TrickComment::create();
        
        $form = $this->createForm(TrickCommentType::class, $trickComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $trickComment->setDateCreate(new \DateTime())
                         ->setTrick($trick)
                         ->setUserCreate($user)
                         ->setText(strip_tags($trickComment->getText()));

            $manager->persist($trickComment);
            $manager->flush();
            $this->addFlash('success', 'Votre commentaire à bien été ajouté,<br><strong>Merci</strong>.');
            return $this->redirectToRoute('show_trick', ['id' => $trick->getId()]);
        }
        return $this->render('snow/trick.twig', [
                "trick" => $trick,
                "trickCommentForm" => $form->createView(),
                "maxComments" => self::NUMBER_OF_COMMENTS_PER_PAGE,
                "maxImages" => self::NUMBER_OF_IMAGES_PER_PAGE,
                "maxVideos" => self::NUMBER_OF_VIDEOS_PER_PAGE
            ]);
    }

    /**
     * @Route("/add", name="add_trick")
     * @Route("/edit/{id}", name="edit_trick")
     * @IsGranted("ROLE_USER")
     */
    public function formTricks(Tricks $trick = null, Request $request, ObjectManager $manager)
    {
        if (!$trick) {
            $trick = new Tricks();
        }

        $formTrick = $this->createForm(TrickType::class, $trick);

        $formTrick->handleRequest($request);
        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $user = $this->getUser();
            $msg = "modifiée";
            if(!$trick->getId()){
                $msg = "ajoutée";
                $trick->setDateCreate(new \DateTime())
                      ->setUserCreate($user);
            }
            $trick->setDateUpdate(new \DateTime())
                  ->setUserUpdate($user);

            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Votre Figure à bien été '.$msg.',<br><strong>Merci</strong>.');
            return $this->redirectToRoute('show_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('snow/formTrick.twig', [
            'formTrick' => $formTrick->createView(),
            'trick' => $trick,
            'editMode' => $trick->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_trick")
     * @IsGranted("ROLE_USER")
     */
    public function deleteTrick(Tricks $trick, ObjectManager $manager)
    {
        $manager->remove($trick);
        $manager->flush();
        $this->addFlash('success', 'Votre figure à bien été supprimée,<br><strong>Merci</strong>.');
        return $this->redirectToRoute('home');
    }
    
}
