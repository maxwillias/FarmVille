<?php

namespace App\Controller;

use App\Repository\GadoRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route('/', name:'index_home')]
    public function index(GadoRepository $gadoRepository) : Response {
        $data['abatidos'] = $gadoRepository->findAllAbate();
        $data['leite'] = $gadoRepository->findAllLeite();
        $data['racao'] = $gadoRepository->findAllRacao();

        $dataMenos1Ano = new DateTime('-1 year');
        $data['animaisRacao'] = $gadoRepository->findAllAnimaisRacao($dataMenos1Ano);
        
        $data['titulo'] = 'Bem vindo!';
        $data['mensagem'] = 'Seja bem vindo ao site do FarmVille seu sistema de gerenciamento de fazendas.';
        return $this->render('home/index.html.twig', $data);
    }
}