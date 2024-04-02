<?php

// src/Controller/ErrorController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'forbidden_page')]
    public function accessDenied(): Response
    {
        return $this->render('error/index.html.twig');
    }
   
   
}
