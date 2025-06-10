<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowController extends AbstractController
{
    #[Route(path: '/show/{id}', name: 'show')]
    public function __invoke(string $id, Connection $conn): Response
    {
        $bill = false;

        try {
            $stmt = $conn->executeQuery('SELECT * FROM bills WHERE id = :id', ['id' => $id]);
            $bill = $stmt->fetchAssociative();
        } catch (TableNotFoundException) {
            // Ignore
        }

        if ($bill === false) {
            throw $this->createNotFoundException(sprintf(
                'No bill found with ID "%s".', $id
            ));
        }

        $bill['lines'] = json_decode($bill['lines'], true, 512, JSON_THROW_ON_ERROR);

        return $this->render('show.html.twig', [
            'bill' => $bill,
        ]);
    }
}
