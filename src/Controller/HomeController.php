<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function indexAction(): Response
    {
        return $this->render('home/index.html.twig');

    }

    /**
     * @Route("/test")
     */
    public function index2Action(): Response
    {
        return $this->render('home/index2.html.twig');

    }

}