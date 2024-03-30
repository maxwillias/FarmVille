<?php

namespace App\Controller;

use App\Entity\Veterinario;
use App\Form\VeterinarioType;
use App\Repository\VeterinarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function PHPUnit\Framework\isNull;

class VeterinarioController extends AbstractController
{

    #[Route('/veterinario', name: 'index_veterinario')]
    public function index(Request $request, VeterinarioRepository $veterinarioRepository, PaginatorInterface $paginator): Response
    {
        

        $pagination = $paginator->paginate(
            $veterinarioRepository->findTodos(), 
            $request->query->getInt('page', 1), 
            2
        );
        
        $data['veterinarios'] = $pagination;
        $data['titulo'] = 'Gerenciar Veterinários';

        return $this->render('veterinario/index.html.twig', $data);
    }

    #[Route('/veterinario/adicionar', name: 'adicionar_veterinario')]
    public function adicionar(Request $request, EntityManagerInterface $em, VeterinarioRepository $veterinarioRepository): Response
    {

        $veterinario = new Veterinario();
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);
        $existeCRMV = $veterinarioRepository->findOneByCRMV($form->getData()->getCrmv());

        if ($form->isSubmitted() && $form->isValid() && $existeCRMV == null) {
            $em->persist($veterinario);
            $em->flush();
            $this->addFlash(
                'Sucesso',
                'Salvo com sucesso!'
            );
            return $this->redirectToRoute('index_veterinario');
        } elseif ($existeCRMV != null) {
            $this->addFlash(
                'Aviso',
                'Esse CRMV já existe!'
            );
        }

        $data['titulo'] = 'Adicionar novo Veterinário';
        $data['form'] = $form;

        return $this->render('veterinario/form.html.twig', $data);
    }

    #[Route('/veterinario/editar/{id}', name: 'editar_veterinario')]
    public function editar($id, VeterinarioRepository $veterinarioRepository, Request $request, EntityManagerInterface $em): Response
    {

        $veterinario = $veterinarioRepository->find($id);
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $vet = $veterinarioRepository->findOneByCRMV($form->getData()->getCrmv());

            if($vet != null && $veterinario->getId() != $vet->getId()){
                $this->addFlash(
                    'Aviso',
                    'Esse CRMV já existe!'
                );
            } else {
                $em->flush();
                $this->addFlash(
                    'Sucesso',
                    'Alterações salvas com sucesso!'
                );
                return $this->redirectToRoute('index_veterinario');
            }
        }

        $data['titulo'] = 'Editar Veterinário';
        $data['form'] = $form;

        return $this->render('veterinario/form.html.twig', $data);
    }

    #[Route('/veterinario/excluir/{id}', name: 'excluir_veterinario')]
    public function excluir($id, VeterinarioRepository $veterinarioRepository, EntityManagerInterface $em): Response
    {

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
