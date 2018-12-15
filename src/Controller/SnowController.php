<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Entity\Tricks;
use App\Entity\TrickGroup;
use App\Entity\TrickComment;
use App\Entity\TrickVideo;
use App\Form\TrickType;
use App\Form\TrickCommentType;
use App\Form\TrickVideoType;
use App\Repository\TricksRepository;
use App\Repository\TrickVideoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SnowController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $tricks = $trickRepo->findAll();

        return $this->render('snow/home.twig', [
                "tricks" => $tricks
            ]);
    }
    
    /**
     * @Route("/add", name="add_trick")
     * @Route("/edit/{id}", name="edit_trick")
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

            if(!$trick->getId()){
                $trick->setDateCreate(new \DateTime())
                      ->setUserCreate($user);
            }
            $trick->setDateUpdate(new \DateTime())
                  ->setUserUpdate($user);

            $manager->persist($trick);
            $manager->flush();
            return $this->redirectToRoute('show_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('snow/formTrick.twig', [
            'formTrick' => $formTrick->createView(),
            'trick' => $trick,
            'editMode' => $trick->getId() !== null
        ]);
    }

    /**
     * @Route("/edit_video/{id}", name="edit_video_trick")
     */
    public function formTrickVideo(Tricks $trick, Request $request, ObjectManager $manager, TrickVideoRepository $trickVideoRepo)
    {
        $trickVideos = $trickVideoRepo->findBy(['trick' => $trick]);

        $trickVideo = new TrickVideo();
        $formTrickVideo = $this->createForm(TrickVideoType::class, $trickVideo);

        $formTrickVideo->handleRequest($request);
        if ($formTrickVideo->isSubmitted() && $formTrickVideo->isValid()) {
            $trickVideo->setTrick($trick);
            $manager->persist($trickVideo);
            $manager->flush();
            return $this->redirectToRoute('edit_video_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('snow/formTrickVideo.twig', [
            'trick' => $trick,
            'trickVideos' => $trickVideos,
            'formTrickVideo' => $formTrickVideo->createView()
        ]);
    }

    /**
     * @Route("/tricks/{id}", name="show_trick")
     */
    public function showTrick(Tricks $trick, Request $request, ObjectManager $manager)
    {
        $trickComment = new TrickComment();

        $form = $this->createForm(TrickCommentType::class, $trickComment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $trickComment->setDateCreate(new \DateTime())
                         ->setTrick($trick)
                         ->setUserCreate($user);

            $manager->persist($trickComment);
            $manager->flush();

            return $this->redirectToRoute('show_trick', ['id' => $trick->getId()]);
        }
        return $this->render('snow/trick.twig', [
                "trick" => $trick,
                "trickCommentForm" => $form->createView()
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

        return $this->redirectToRoute('home');
    }
    
    /**
     * @Route("/delete_video/{id}", name="delete_trick_video")
     * @IsGranted("ROLE_USER")
     */
    public function deleteTrickVideo(TrickVideo $trickVideo, ObjectManager $manager)
    {
        $manager->remove($trickVideo);
        $manager->flush();

        return $this->redirectToRoute('home');
    }
    
}
