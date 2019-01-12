<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Tricks;
use App\Entity\TrickImage;
use App\Form\TrickImageType;

class TrickImageController extends AbstractController
{
    /**
     * @Route("/trick/edit_image/{id}", name="edit_image_trick")
     */
    public function formTrickImage(Tricks $trick, Request $request, EntityManagerInterface $manager)
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
     * @Route("/trick/delete_image/{id}", name="delete_trick_image")
     */
    public function deleteTrickImage(TrickImage $trickImage, EntityManagerInterface $manager)
    {
        $trick = $trickImage->getTrick();
        $manager->remove($trickImage);
        $manager->flush();
        $this->addFlash('success', 'L\'image à bien été supprimé,<br><strong>Merci</strong>.');
        return $this->redirectToRoute('edit_image_trick', ['id' => $trick->getId()]);
    }
    

}
