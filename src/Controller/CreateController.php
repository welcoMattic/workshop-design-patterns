<?php

namespace App\Controller;

use App\Form\BillType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateController extends AbstractController
{
    private const REGEX = '/^IN-%s-\d{3}$/';

    #[Route(path: '/create', name: 'create')]
    public function __invoke(Request $request, Connection $conn): Response
    {
        $form = $this->createForm(BillType::class);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $date = date('Ymd');
            $regex = sprintf(self::REGEX, $date);

            // Verify bill ID
            if (!preg_match($regex, $data['id'])) {
                $error = sprintf(
                    'Invoice number is "%s". Expected to be "IN-%s-XXX" (X = number).',
                    $data['id'],
                    $date
                );
            }

            if ($error === null) {
                $lines = $data['lines'];
                $total = array_sum(array_map(fn ($row) => $row['unit_price_in_cents'] * $row['quantity'], $lines));
                $currency = $lines[0]['currency'];
                $row = [
                    'id' => $data['id'],
                    'price' => sprintf('%.2f %s', $total/100, $currency),
                    'lines' => json_encode($lines, JSON_THROW_ON_ERROR),
                ];

                try {
                    $conn->insert('bills', $row);
                } catch (TableNotFoundException $e) {
                    $conn->executeStatement('CREATE TABLE bills (
                        id VARCHAR(30) PRIMARY KEY,
                        price VARCHAR(64) NOT NULL,
                        lines TEXT NOT NULL
                    )');
                    $conn->insert('bills', $row);
                }

                return $this->redirectToRoute('list');
            }
        }

        return $this->render('create.html.twig', [
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }
}
