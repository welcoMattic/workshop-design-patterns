<?php

namespace App\Controller;

use App\Repository\BillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowController extends AbstractController
{
    #[Route(path: '/show/{id}', name: 'show')]
    public function __invoke(string $id, BillRepository $billRepository): Response
    {
        try {
            return $this->render('show.html.twig', [
                'bill' => $billRepository->getBill($id),
            ]);
        } catch (\InvalidArgumentException) {
            throw $this->createNotFoundException('No bill found with ID "'.$id.'".');
        }
    }
}
