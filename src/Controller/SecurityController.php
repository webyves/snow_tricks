<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
	/**
	* @Route("/inscription", name="security_registration")
	*/
	public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
	{
		$user = new Users();
        $form = $this->createForm(UserType::class, $user);

		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        	$hash = $encoder->encodePassword($user, $user->getPassword());
        	
            $user->setDateInscription(new \DateTime())
            	->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("security_login");

        }


        return $this->render('security/inscription.twig', ['formRegister' => $form->createView()]);
	}

    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('security/connect.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
