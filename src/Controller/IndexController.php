<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index") methods={"GET"}
     */
    public function index()
    {
       
        return $this->render('index.html.twig');
    }
}