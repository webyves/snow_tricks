<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Users;
use App\Entity\Tricks;
use App\Entity\TrickGroup;
use App\Entity\TrickComment;
use App\Entity\TrickVideo;
use App\Entity\TrickImage;

use App\Form\TrickType;
use App\Form\TrickCommentType;
use App\Form\TrickVideoType;
use App\Form\TrickImageType;

use App\Repository\TricksRepository;

class SnowController extends AbstractController
{
    const NUMBER_OF_TRICKS_PER_PAGE = 4;
    const NUMBER_OF_IMAGES_PER_PAGE = 10;
    const NUMBER_OF_VIDEOS_PER_PAGE = 10;

    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / self::NUMBER_OF_TRICKS_PER_PAGE;
        $tricks = $trickRepo->findBy([], null, self::NUMBER_OF_TRICKS_PER_PAGE, 0);

        return $this->render('snow/home.twig', [
                "tricks" => $tricks,
                "pageNb" => 1,
                "nbPages" => $nbPages
            ]);
    }

    /**
     * @Route("/ajax_page/{pageNb}", name="ajax_tricks_list", requirements={"pageNb"="\d+"})
     */
    public function tricksPages($pageNb, TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / self::NUMBER_OF_TRICKS_PER_PAGE;
        $offset = ($pageNb * self::NUMBER_OF_TRICKS_PER_PAGE);
        $tricks = $trickRepo->findBy([], null, self::NUMBER_OF_TRICKS_PER_PAGE, $offset);
        $nbPages -= $pageNb;
        $pageNb++;

        return $this->render('snow/ajaxTricksList.twig', [
                "tricks" => $tricks,
                "pageNb" => $pageNb,
                "nbPages" => $nbPages
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
    public function formTrickVideo(Tricks $trick, Request $request, ObjectManager $manager)
    {
        $trickVideos = $trick->getTrickVideos();

        $trickVideo = new TrickVideo();
        $formTrickVideo = $this->createForm(TrickVideoType::class, $trickVideo);

        $formTrickVideo->handleRequest($request);
        if ($formTrickVideo->isSubmitted() && $formTrickVideo->isValid()) {

            $subject = $trickVideo->getLink();
            $pattern = array('#width="[0-9]*"#', '#height="[0-9]*"#');
            $replacement = array('', '');
            $trickVideoUrl = preg_replace($pattern, $replacement, $subject);

            $trickVideo->setTrick($trick)
                       ->setLink($trickVideoUrl);
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
     * @Route("/edit_image/{id}", name="edit_image_trick")
     */
    public function formTrickImage(Tricks $trick, Request $request, ObjectManager $manager)
    {
        $trickImages = $trick->getTrickImages();

        $trickImage = new TrickImage();
        $formTrickImage = $this->createForm(TrickImageType::class, $trickImage);

        $formTrickImage->handleRequest($request);
        if ($formTrickImage->isSubmitted() && $formTrickImage->isValid()) {
            $trickImage->setTrick($trick);

            $manager->persist($trickImage);
            $manager->flush();
            return $this->redirectToRoute('edit_image_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('snow/formTrickImage.twig', [
            'trick' => $trick,
            'trickImages' => $trickImages,
            'formTrickImage' => $formTrickImage->createView()
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
        $trick = $trickVideo->getTrick();
        $manager->remove($trickVideo);
        $manager->flush();

        return $this->redirectToRoute('edit_video_trick', ['id' => $trick->getId()]);
    }
    
    /**
     * @Route("/delete_image/{id}", name="delete_trick_image")
     * @IsGranted("ROLE_USER")
     */
    public function deleteTrickImage(TrickImage $trickImage, ObjectManager $manager)
    {
        $trick = $trickImage->getTrick();
        $manager->remove($trickImage);
        $manager->flush();

        return $this->redirectToRoute('edit_image_trick', ['id' => $trick->getId()]);
        // return;
    }
    
}
