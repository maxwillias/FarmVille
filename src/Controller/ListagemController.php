<?php

namespace App\Controller;

use App\Repository\GadoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListagemController extends AbstractController {

    #[Route('/listagem', name: 'index_listagem')]
    public function index(Request $request,PaginatorInterface $paginator, GadoRepository $gadoRepository): Response {
        
        $ano = new DateTime('-5 years');

        $pagination = $paginator->paginate(
            $gadoRepository->findAllAnimaisAbate($ano), 
            $request->query->getInt('page', 1), 
            2
        );

        $data['gados'] = $pagination;
        
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