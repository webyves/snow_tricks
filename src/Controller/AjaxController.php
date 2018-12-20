<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TricksRepository;
use App\Repository\TrickCommentRepository;


class AjaxController extends SnowController
{

    /**
     * @Route("/ajax_tricks_list/{pageNb}", name="ajax_tricks_list", requirements={"pageNb"="\d+"})
     */
    public function tricksPages($pageNb, TricksRepository $trickRepo, Request $req)
    {
        if ($req->isXMLHttpRequest() ) {
	        $offset = ($pageNb * self::NUMBER_OF_TRICKS_PER_PAGE);
	        $tricks = $trickRepo->findBy([], null, self::NUMBER_OF_TRICKS_PER_PAGE, $offset);
	        $nbPages = ($trickRepo->count([]) / self::NUMBER_OF_TRICKS_PER_PAGE) - $pageNb;
	        $pageNb++;
	        return $this->render('ajax/ajaxTricksList.twig', [
	                "tricks" => $tricks,
	                "pageNb" => $pageNb,
	                "nbPages" => $nbPages
	            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/ajax_comments_list/{pageNb}", name="ajax_comments_list", requirements={"pageNb"="\d+"})
     */
    public function commentsPages($pageNb, TrickCommentRepository $TrickCommentRepo, Request $req)
    {
        if ($req->isXMLHttpRequest() ) {
        	$trickid = $req->request->get("trickid");
	        $offset = ($pageNb * self::NUMBER_OF_COMMENTS_PER_PAGE);
	        $trickComments = $TrickCommentRepo->findBy(["trick"=>$trickid], null, self::NUMBER_OF_COMMENTS_PER_PAGE, $offset);
	        $nbPages = ($TrickCommentRepo->count(["trick"=>$trickid]) / self::NUMBER_OF_COMMENTS_PER_PAGE) - $pageNb;
	        $pageNb++;
	        return $this->render('ajax/ajaxCommentsList.twig', [
	                "trickComments" => $trickComments,
	                "pageNb" => $pageNb,
	                "nbPages" => $nbPages,
	                "trickid" => $trickid
	            ]);
        }
        return $this->redirectToRoute('home');
    }
}
