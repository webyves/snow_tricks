<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Tricks;
use App\Repository\TricksRepository;

class SnowController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / Tricks::TRICKS_PER_PAGE;
        $tricks = $trickRepo->findBy([], null, Tricks::TRICKS_PER_PAGE, 0);
        // findBy([], ["dateCreate"=>"DESC"],
        // attention il faudra revoir toute la pagination

        return $this->render('snow/home.twig', [
                "tricks" => $tricks,
                "pageNb" => 1,
                "nbPages" => $nbPages
            ]);
    }
    
}
