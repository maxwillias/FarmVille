<?php

namespace App\Controller;

use App\Repository\GadoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListagemController extends AbstractController {

    #[Route('/listagem', name: 'index_listagem')]
    public function index(GadoRepository $gadoRepository): Response {
        
        $ano = new DateTime('-5 years');

        $data['gados'] = $gadoRepository->findAllAnimaisAbate($ano);
        
        $data['titulo'] = 'Lista de Gados para o Abate';
        
        return $this->render('listagem/index.html.twig', $data);
    }

    #[Route('/listagem/{id}', name: 'abate_listagem')]
    public function abate($id, GadoRepository $gadoRepository, EntityManagerInterface $em): Response {
        
        $ano = new DateTime('-5 years');
        
        $gado = $gadoRepository->find($id);
        $gado->setAbate(true);
        $em->persist($gado);
        $em->flush();
        $this->addFlash(
            'Sucesso',
             'O gado foi abatido com sucesso!'
        );
        
        return $this->redirectToRoute('index_listagem');
    }
}