<?php

namespace App\Controller;

use App\Form\VeterinarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeterinarioController extends AbstractController {

    #[Route('/veterinario')]
    public function index(EntityManagerInterface $em) : Response {
        
        $form = $this->createForm(VeterinarioType::class);
        $data['titulo'] = 'Adicionar novo Veterinário';
        $data['form'] = $form;

        return $this->render('veterinario/form.html.twig', $data);
    }
}
