<?php

namespace App\Controller;

use App\Entity\Fazenda;
use App\Form\FazendaType;
use App\Repository\FazendaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FazendaController extends AbstractController {

    #[Route('/fazenda', name:'index_fazenda')]
    public function index(FazendaRepository $fazendaRepository) : Response {

        $data['fazendas'] = $fazendaRepository->findAll();
        $data['titulo'] = 'Gerenciar Fazendas';
    
        return $this->render('fazenda/index.html.twig', $data);
    }

    #[Route('/fazenda/adicionar', name:'adicionar_fazenda')]
    public function adicionar(Request $request, EntityManagerInterface $em) : Response {
        
        $fazenda = new Fazenda();
        $form = $this->createForm(FazendaType::class, $fazenda);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fazenda);
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Salvo com sucesso!'
            );
            return $this->redirectToRoute('index_fazenda');
        }
        
        $data['titulo'] = 'Adicionar nova Fazenda';
        $data['form'] = $form;

        return $this->render('fazenda/form.html.twig', $data);
    }

    #[Route('/fazenda/editar/{id}', name:'editar_fazenda')]
    public function editar($id, FazendaRepository $fazendaRepository, Request $request, EntityManagerInterface $em) : Response {
        
        $fazenda = $fazendaRepository->find($id);
        $form = $this->createForm(FazendaType::class, $fazenda);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Alterações salvas com sucesso!'
            );
            return $this->redirectToRoute('index_fazenda');
        }
        
        $data['titulo'] = 'Editar Fazenda';
        $data['form'] = $form;

        return $this->render('fazenda/form.html.twig', $data);
    }

    #[Route('/fazenda/excluir/{id}', name:'excluir_fazenda')]
    public function excluir($id, FazendaRepository $fazendaRepository, EntityManagerInterface $em) : Response {
        
        $fazenda = $fazendaRepository->find($id);

        try {
            $em->remove($fazenda);
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Exclusão feita com sucesso!'
            );
        }catch(Exception $e) {
            $this->addFlash(
                'Aviso',
                'Não é possível excluir uma fazendo que tem gados!'
            );
        }

        return $this->redirectToRoute('index_fazenda');
    }
}
