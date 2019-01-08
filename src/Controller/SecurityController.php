<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use App\Entity\Users;
use App\Entity\UserTokens;
use App\Form\UserType;
use App\Form\UserResetPwdType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
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
            $user->setPassword($hash);
            $manager->persist($user);

            $token = new UserTokens($user, "registration");
            $manager->persist($token);

            $manager->flush();

            $this->sendTokenMail($user, $token);
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
    public function askResetPwd(Request $request, ObjectManager $manager, UsersRepository $usersRepo)
    {
        if ($request->request->count() > 0) {
            $user = $usersRepo->findOneBy(['email' => strip_tags($request->request->get('email'))]);

            $token = new UserTokens($user, "reset_pwd");
            $manager->persist($token);

            $manager->flush();

            $this->sendTokenMail($user, $token);
            $this->addFlash('success', 'Votre demande de reinitialisation de mot de passe a bien été prise en compte,<br>
                                        Vous allez recevoir un email avec un lien unique valable 2h,<br>
                                        Pensez à verfiez vos courriers indésirable,<br>
                                        <strong>Merci</strong>.');
            return $this->redirectToRoute("home");

        }


        return $this->render('security/ask_reset_pwd.twig');
    }

    /**
    * @Route("/token/{value}", name="security_token")
    */
    public function checkToken(UserTokens $token, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
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

            } elseif ($token->getType() === "reset_pwd") {
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
        }
        $this->addFlash('danger', 'Vous avez depassé le delai pour cette demande,<br><strong>Merci de recommencé la procédure</strong>.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
    // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        return $this->render('security/connect.twig', array('error' => $error));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }

    private function sendTokenMail(Users $user, UserTokens $token)
    {
        $verif = false;
        if ($token->getType() === "registration") {
            $subject = 'SnowTricks - Votre Inscription';
            $view = 'emails/registration.html.twig';
        } elseif ($token->getType() === "reset_pwd") {
            $subject = 'SnowTricks - Reinitialisation de votre mot de passe';
            $view = 'emails/reset_pwd.html.twig';
        }
        $message = (new \Swift_Message($subject))
            ->setFrom('contact@ybernier.fr')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    $view,
                    array('user' => $user, 'token' => $token)
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $this->get('mailer')->send($message);
        $verif = true;
        return $verif;
    }
}
