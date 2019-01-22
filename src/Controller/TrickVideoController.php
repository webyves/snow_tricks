<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Tricks;
use App\Entity\TrickVideo;
use App\Form\TrickVideoType;


class TrickVideoController extends AbstractController
{
    /**
     * @Route("/trick/edit_video/{id}", name="edit_video_trick")
     */
    public function formTrickVideo(Tricks $trick, Request $request, EntityManagerInterface $manager)
    {
        $trickVideos = $trick->getTrickVideos();

        $trickVideo = new TrickVideo();
        $formTrickVideo = $this->createForm(TrickVideoType::class, $trickVideo);

        $formTrickVideo->handleRequest($request);
        if ($formTrickVideo->isSubmitted() && $formTrickVideo->isValid()) {

            $subject = $trickVideo->getLink();
            $trickVideoUrl = null;
            $patternSrc = '#(https?://(www\.)?(youtube|dailymotion){1}\.com/embed/(video/)?\w*)#';
            if (preg_match($patternSrc, $subject, $matches)) {
                $trickVideoUrl = $matches[1];
            }
            if(!$trickVideoUrl) {
                $this->addFlash('danger', 'videos.err.link');
                return $this->redirectToRoute('edit_video_trick', ['id' => $trick->getId()]);
            }

            $trickVideo->setTrick($trick)
                       ->setLink($trickVideoUrl);
            $manager->persist($trickVideo);
            $manager->flush();
            $this->addFlash('success', 'videos.ok.add');
            return $this->redirectToRoute('edit_video_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('trick_video/formTrickVideo.twig', [
            'trick' => $trick,
            'trickVideos' => $trickVideos,
            'formTrickVideo' => $formTrickVideo->createView()
        ]);
    }

    /**
     * @Route("/trick/delete_video/{id}", name="delete_trick_video")
     */
    public function deleteTrickVideo(TrickVideo $trickVideo, EntityManagerInterface $manager)
    {
        $idTrick = $trickVideo->getTrick()->getId();
        $manager->remove($trickVideo);
        $manager->flush();
        $this->addFlash('success', 'videos.ok.delete');
        return $this->redirectToRoute('edit_video_trick', ['id' => $idTrick]);
    }
    

}
