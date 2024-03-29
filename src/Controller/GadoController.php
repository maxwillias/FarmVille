<?php

namespace App\Controller;

use App\Entity\Gado;
use App\Form\GadoType;
use App\Repository\GadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GadoController extends AbstractController {

    #[Route('/gado', name:'index_gado')]
    public function index(GadoRepository $gadoRepository) : Response {

        $data['gados'] = $gadoRepository->findAll();
        $data['titulo'] = 'Gerenciar Gados';

        return $this->render('gado/index.html.twig', $data);
    }

    #[Route('/gado/adicionar', name:'adicionar_gado')]
    public function adicionar(Request $request, EntityManagerInterface $em) : Response {
        
        $gado = new Gado();
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($gado);
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Salvo com sucesso!'
            );
            return $this->redirectToRoute('index_gado');
        }

        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->render('gado/form.html.twig', $data);
    }

    #[Route('/gado/editar/{id}' , name:'editar_gado')]
    public function editar($id, GadoRepository $gadoRepository, Request $request, EntityManagerInterface $em) : Response {
        
        $gado = $gadoRepository->find($id);
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Alterações salvas com sucesso!'
            );
            return $this->redirectToRoute('index_gado');
        }

        $data['titulo'] = 'Editar gado';
        $data['form'] = $form;

        return $this->render('gado/form.html.twig', $data);
    }

    #[Route('/gado/excluir/{id}' , name:'excluir_gado')]
    public function excluir($id, GadoRepository $gadoRepository, EntityManagerInterface $em) : Response {
        
        $gado = $gadoRepository->find($id);

        $em->remove($gado);
        $em->flush();
        $this->addFlash(
            'Sucesso',
            'Exclusão feita com sucesso!'
        );

        return $this->redirectToRoute('index_gado');
    }
}
