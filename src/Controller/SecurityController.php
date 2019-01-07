<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\Entity\UserTokens;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
        	
            $user->setDateInscription(new \DateTime())
            	->setPassword($hash);

            $this->sendRegistrationMail($user->getUsername());
            $manager->persist($user);
            $manager->flush();


            $this->addFlash('success', 'Votre incription a bien été prise en compte,<br>
                                        Vous allez recevoir un email pour valider votre inscription,<br>
                                        Si il n\'est pas arrivé d\'ici à 5 min verfiez vos courriers indésirable,<br>
                                        <strong>Merci</strong>.');
            return $this->redirectToRoute("security_login");

        }


        return $this->render('security/inscription.twig', ['formRegister' => $form->createView()]);
	}

    private function sendRegistrationMail($name)
    {
        $verif = false;
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('contact@ybernier.fr')
            ->setTo('webyves@hotmail.com')
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    array('name' => $name)
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

    /**
    * @Route("/token/{value}", name="security_token")
    */
    public function checkToken(UserTokens $token, Request $request, ObjectManager $manager)
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

                return $this->render('security/token_reset_pwd.twig', ['token' => $token]);
            }            
        }
        $this->addFlash('danger', 'Vous avez depassé le delai pour cette demande,<br><strong>Merci de recommencé la procédure</strong>.');
        return $this->redirectToRoute('home');
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
