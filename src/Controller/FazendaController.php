<?php

namespace App\Controller;

use App\Form\FazendaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FazendaController extends AbstractController {

    #[Route('/fazenda')]
    public function index(EntityManagerInterface $em) : Response {
        
        $form = $this->createForm(FazendaType::class);
        $data['titulo'] = 'Adicionar nova fazenda';
        $data['form'] = $form;

        return $this->render('fazenda/form.html.twig', $data);
    }
}
