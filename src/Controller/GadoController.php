<?php

namespace App\Controller;

use App\Form\GadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GadoController extends AbstractController {

    #[Route('/gado')]
    public function index(EntityManagerInterface $em) : Response {
        
        $form = $this->createForm(GadoType::class);
        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->render('gado/form.html.twig', $data);
    }
}
