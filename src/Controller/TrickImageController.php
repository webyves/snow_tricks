<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Tricks;
use App\Entity\TrickImage;
use App\Form\TrickImageType;

class TrickImageController extends SnowController
{
    /**
     * @Route("/edit_image/{id}", name="edit_image_trick")
     * @IsGranted("ROLE_USER")
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
            $this->addFlash('success', 'L\'image à bien été Ajoutée,<br><strong>Merci</strong>.');
            return $this->redirectToRoute('edit_image_trick', ['id' => $trick->getId()]);
        }
                    

        return $this->render('trick_image/formTrickImage.twig', [
            'trick' => $trick,
            'trickImages' => $trickImages,
            'formTrickImage' => $formTrickImage->createView()
        ]);
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
        $this->addFlash('success', 'L\'image à bien été supprimé,<br><strong>Merci</strong>.');
        return $this->redirectToRoute('edit_image_trick', ['id' => $trick->getId()]);
    }
    

}
