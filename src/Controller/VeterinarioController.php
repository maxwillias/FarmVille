<?php

namespace App\Controller;

use App\Entity\Veterinario;
use App\Form\VeterinarioType;
use App\Repository\VeterinarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeterinarioController extends AbstractController {

    #[Route('/veterinario', name:'index_veterinario')]
    public function index(VeterinarioRepository $veterinarioRepository) : Response {

        $data['veterinarios'] = $veterinarioRepository->findAll();
        $data['titulo'] = 'Gerenciar Veterinários';
    
        return $this->render('veterinario/index.html.twig', $data);
    }

    #[Route('/veterinario/adicionar', name:'adicionar_veterinario')]
    public function adicionar(Request $request, EntityManagerInterface $em) : Response {
        
        $veterinario = new Veterinario();
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($veterinario);
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Salvo com sucesso!'
            );
            return $this->redirectToRoute('index_veterinario');
        }
        
        $data['titulo'] = 'Adicionar novo Veterinário';
        $data['form'] = $form;

        return $this->render('veterinario/form.html.twig', $data);
    }

    #[Route('/veterinario/editar/{id}', name:'editar_veterinario')]
    public function editar($id, VeterinarioRepository $veterinarioRepository, Request $request, EntityManagerInterface $em) : Response {
        
        $veterinario = $veterinarioRepository->find($id);
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Alterações salvas com sucesso!'
            );
            return $this->redirectToRoute('index_veterinario');
        }
        
        $data['titulo'] = 'Editar Veterinário';
        $data['form'] = $form;

        return $this->render('veterinario/form.html.twig', $data);
    }

    #[Route('/veterinario/excluir/{id}', name:'excluir_veterinario')]
    public function excluir($id, VeterinarioRepository $veterinarioRepository, EntityManagerInterface $em) : Response {
        
        $veterinario = $veterinarioRepository->find($id);

        $em->remove($veterinario);
        $em->flush();
        $this->addFlash(
            'Sucesso',
            'Exclusão feita com sucesso!'
        );

        return $this->redirectToRoute('index_veterinario');
    }
}
