<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use App\Entity\Users;
use App\Entity\UserTokens;
use App\Form\UserType;
use App\Form\UserResetPwdType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\SnowTricksEmails;

class SecurityController extends AbstractController
{
	/**
	* @Route("/inscription", name="security_registration")
	*/
	public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, SnowTricksEmails $emailService)
	{
		$user = new Users();
        $form = $this->createForm(UserType::class, $user);

		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        	$hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);

            $token = new UserTokens($user, "registration");
            $manager->persist($token);

            $manager->flush();

            $emailService->sendToken($user, $token, $this->getParameter('admin.email'));
            $this->addFlash('success', 'Votre incription a bien été prise en compte,<br>
                                        Vous allez recevoir un email pour valider votre inscription,<br>
                                        Pensez à verfiez vos courriers indésirable,<br>
                                        <strong>Merci</strong>.');
            return $this->redirectToRoute("security_login");

        }


        return $this->render('security/inscription.twig', ['formRegister' => $form->createView()]);
	}

    /**
    * @Route("/ask_reset_pwd", name="ask_reset_pwd")
    */
    public function askResetPwd(Request $request, EntityManagerInterface $manager, UsersRepository $usersRepo, SnowTricksEmails $emailService)
    {
        if ($request->request->count() > 0) {
            $user = $usersRepo->findOneBy(['email' => strip_tags($request->request->get('email'))]);

            $token = new UserTokens($user, "reset_pwd");
            $manager->persist($token);

            $manager->flush();
            $emailService->sendToken($user, $token, $this->getParameter('admin.email'));
            $this->addFlash('success', 'Votre demande de reinitialisation de mot de passe a bien été prise en compte,<br>
                                        Vous allez recevoir un email avec un lien unique valable 2h,<br>
                                        Pensez à verfiez vos courriers indésirable,<br>
                                        <strong>Merci</strong>.');
            return $this->redirectToRoute("home");

        }


        return $this->render('security/ask_reset_pwd.twig');
    }

    /**
    * @Route("/token_register/{value}", name="security_token_register")
    */
    public function checkRegister(UserTokens $token, Request $request, EntityManagerInterface $manager)
    {
        if ($token->getdateToken() > new \DateTime()) {
            if ($token->getType() === "registration") {

                $token->setDateToken(new \DateTime());
                $manager->persist($token);

                $user = $token->getUser();
                $user->setValid(true);
                $manager->persist($user);

                $manager->flush();

                $this->addFlash('success', 'Votre incription a bien été validé,<br><strong>Merci</strong>.');
                return $this->redirectToRoute('security_login');
            }            
            $this->addFlash('danger', 'Erreur sur le type de token invoqué,<br><strong>Merci de recommencé la procédure</strong>.');
            return $this->redirectToRoute('home');
        }
        $this->addFlash('danger', 'Vous avez depassé le delai le delai de votre inscription qui etait de 14 jours,<br><strong>Merci de recommencé la procédure ou de contacter un administrateur</strong>.');
        return $this->redirectToRoute('home');
    }

    /**
    * @Route("/token_reset/{value}", name="security_token_reset_pwd")
    */
    public function checkResetPwd(UserTokens $token, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if ($token->getdateToken() > new \DateTime()) {
            if ($token->getType() === "reset_pwd") {
                $user = $token->getUser();
                $form = $this->createForm(UserResetPwdType::class, $user);

                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $hash = $encoder->encodePassword($user, $user->getPassword());
                    $user->setPassword($hash);
                    $manager->persist($user);

                    $token->setDateToken(new \DateTime());
                    $manager->persist($token);

                    $manager->flush();
                    $this->addFlash('success', 'Votre à bien été reinitialisé.');
                    return $this->redirectToRoute('security_login');
                }
                return $this->render('security/token_reset_pwd.twig', ['formResetPwd' => $form->createView()]);
            }            
            $this->addFlash('danger', 'Erreur sur le type de token invoqué,<br><strong>Merci de recommencé la procédure</strong>.');
            return $this->redirectToRoute('home');
        }
        $this->addFlash('danger', 'Vous avez depassé le delai pour votre reinitilaisation de mot de passe qui etait de 2h,<br><strong>Merci de recommencé la procédure</strong>.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        return $this->render('security/connect.twig', array('error' => $error));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
