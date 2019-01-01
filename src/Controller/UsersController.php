<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;
// use App\Form\UserAccountType;
use App\Service\FileUploader;

class UsersController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @IsGranted("ROLE_USER")
     */
    public function account(Request $request, ObjectManager $manager, FileUploader $uploader)
    {
    	$user = $this->getUser();
    	$firstName = $user->getFirstName();
    	$lastName = $user->getLastName();
    	$avatar = $user->getAvatar();

    	if($request->request->count() > 0) {
        	$firstName = $request->request->get("firstName");
        	$lastName = $request->request->get("lastName");
        	$file = $request->files->get("avatarFile");
            if ($file) {
                if ($avatar) {
                    $uploader->removeFile($avatar, "userAvatar"); 
                }
                $avatar = $uploader->upload($file, "userAvatar");
            }
        	$user->setAvatar($avatar)
        		 ->setFirstName($firstName)
        		 ->setLastName($lastName);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Vos modifiations ont bien été pises en compte,<br><strong>Merci</strong>.');
            return $this->redirectToRoute("account");
        }
        return $this->render('users/account.twig', [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "avatar" => $avatar
        ]);
    }
}
