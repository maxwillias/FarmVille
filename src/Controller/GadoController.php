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

class GadoController extends AbstractController
{

    #[Route('/gado', name: 'index_gado')]
    public function index(GadoRepository $gadoRepository): Response
    {

        $data['gados'] = $gadoRepository->findAll();
        $data['titulo'] = 'Gerenciar Gados';

        return $this->render('gado/index.html.twig', $data);
    }

    #[Route('/gado/adicionar', name: 'adicionar_gado')]
    public function adicionar(Request $request, EntityManagerInterface $em, GadoRepository $gadoRepository): Response
    {

        $gado = new Gado();
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);
        $existeCodigo = $gadoRepository->findOneByCode($form->getData()->getCodigo());

        if ($form->isSubmitted() && $form->isValid()) {

            $fazenda = $form->getData()->getFazenda();
            $quantidadeGado = $gadoRepository->findAllAnimaisFazenda($fazenda->getId());
            if (($fazenda->getTamanho() * 18) > $quantidadeGado) {
                $isLivre = true;
            } else {
                $isLivre = false;
            }

            if ($existeCodigo == null || $existeCodigo->isAbate()) {
                if ($isLivre) {
                    $em->persist($gado);
                    $em->flush();
                    $this->addFlash(
                        'Sucesso',
                        'Salvo com sucesso!'
                    );
                    return $this->redirectToRoute('index_gado');
                } else {
                    $this->addFlash(
                        'Aviso',
                        'A fazenda já tem o máximo de gados por hectar!'
                    );
                }
            } elseif ($existeCodigo != null && $existeCodigo->isAbate() == false) {
                $this->addFlash(
                    'Aviso',
                    'Existe um gado vivo com esse código!'
                );
            }
        }

        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->render('gado/form.html.twig', $data);
    }

    #[Route('/gado/editar/{id}', name: 'editar_gado')]
    public function editar($id, GadoRepository $gadoRepository, Request $request, EntityManagerInterface $em): Response
    {

        $gado = $gadoRepository->find($id);
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gad = $gadoRepository->findOneByCode($form->getData()->getCodigo());

            if ($gad != null && $gad->getId() != $gado->getId()) {
                $this->addFlash(
                    'Aviso',
                    'Existe um gado vivo com esse código!'
                );
            } else {
                $em->flush();
                $this->addFlash(
                    'Sucesso',
                    'Alterações salvas com sucesso!'
                );
                return $this->redirectToRoute('index_gado');
            }
        }

        $data['titulo'] = 'Editar gado';
        $data['form'] = $form;

        return $this->render('gado/form.html.twig', $data);
    }

    #[Route('/gado/excluir/{id}', name: 'excluir_gado')]
    public function excluir($id, GadoRepository $gadoRepository, EntityManagerInterface $em): Response
    {

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
