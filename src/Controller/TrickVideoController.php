<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Tricks;
use App\Entity\TrickVideo;
use App\Form\TrickVideoType;


class TrickVideoController extends SnowController
{
    /**
     * @Route("/edit_video/{id}", name="edit_video_trick")
     * @IsGranted("ROLE_USER")
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
                    

        return $this->render('trick_video/formTrickVideo.twig', [
            'trick' => $trick,
            'trickVideos' => $trickVideos,
            'formTrickVideo' => $formTrickVideo->createView()
        ]);
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
    

}
