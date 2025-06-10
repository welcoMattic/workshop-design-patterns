<?php

namespace App\Controller;

use App\Form\BillType;
use App\Repository\BillRepository;
use App\Validator\BillValidator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateController extends AbstractController
{
    #[Route(path: '/create', name: 'create')]
    public function __invoke(Request $request, Connection $conn, BillValidator $billValidator, BillRepository $billRepository): Response
    {
        $form = $this->createForm(BillType::class);
        $form->handleRequest($request);

        $errors = [];
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $errors = $billValidator->validate($data);
            $hasErrors = !empty($errors);
            if (!$hasErrors) {
                $billRepository->createBill($data);
                return $this->redirectToRoute('list');
            }
        }

        return $this->render('create.html.twig', [
            'errors' => $errors ?? [],
            'form' => $form->createView(),
        ]);
    }
}
