<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController {

    #[Route('/hello/{name}')]
    public function hello($name) : Response {
        return new Response('Hello '.$name.'!');
    }

    #[Route('/hello')]
    public function index() : Response {

        $data['titulo'] = 'Bem vindo!';
        $data['mensagem'] = 'Seja bem vindo ao site do FarmVille.';
        return $this->render('hello/index.html.twig', $data);
    }
}