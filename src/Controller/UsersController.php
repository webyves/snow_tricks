<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserAccountType;
use App\Service\FileUploader;

class UsersController extends AbstractController
{

    /**
     * @Route("/user/account", name="account")
     */
    public function userAccount(Request $request, EntityManagerInterface $manager, FileUploader $uploader)
    {
        $user = $this->getUser(); 
        $avatar = $user->getAvatar();
        $formUserAccount = $this->createForm(UserAccountType::class, $user);
        $formUserAccount->handleRequest($request);
        if ($formUserAccount->isSubmitted() && $formUserAccount->isValid()) {
            $file = $request->files->get("avatarFile");
            if ($file) {
                if ($avatar) {
                    $uploader->removeFile($avatar, "userAvatar"); 
                }
                $avatar = $uploader->upload($file, "userAvatar");
            }
            $user->setAvatar($avatar);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Vos modifiations ont bien été pises en compte,<br><strong>Merci</strong>.');
            return $this->redirectToRoute("account");
        }
        return $this->render('users/account.twig', ['formUserAccount' => $formUserAccount->createView()]);
    }
}
