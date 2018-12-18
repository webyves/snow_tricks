<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserAccountType;

class UsersController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @IsGranted("ROLE_USER")
     */
    public function account(Request $request, ObjectManager $manager)
    {
    	$user = $this->getUser();
        $accountForm = $this->createForm(UserAccountType::class, $user);

		$accountForm->handleRequest($request);
        if ($accountForm->isSubmitted() && $accountForm->isValid()) {
dump($user);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("account");
        }
        return $this->render('users/account.twig', [
            'accountForm' => $accountForm->createView()
        ]);
    }
}
