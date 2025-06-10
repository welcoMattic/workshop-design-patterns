<?php

namespace App\Controller;

use App\Repository\BillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    #[Route(path: '/', name: 'list')]
    public function __invoke(BillRepository $billRepository): Response
    {
        return $this->render('list.html.twig', [
            'bills' => $billRepository->getBills(),
        ]);
    }
}
