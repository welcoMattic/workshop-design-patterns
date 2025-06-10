<?php

namespace App\Controller;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    #[Route(path: '/', name: 'list')]
    public function __invoke(): Response
    {
        $conn = DriverManager::getConnection([
            'url' => 'sqlite:///'.dirname(__DIR__, 2).'/var/data.sqlite',
        ]);

        try {
            $stmt = $conn->executeQuery('SELECT * FROM bills');
            $bills = $stmt->fetchAllAssociative();
        } catch (TableNotFoundException) {
            $bills = [];
        }

        return $this->render('list.html.twig', [
            'bills' => $bills,
        ]);
    }
}
