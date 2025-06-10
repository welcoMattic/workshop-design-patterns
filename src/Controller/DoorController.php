<?php

namespace App\Controller;

use App\Door\Door;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DoorController extends AbstractController
{
    #[Route(path: '/door', name: 'door')]
    public function __invoke(Request $request): Response
    {
        $state = $request->query->get('s', 'open');
        $door = new Door($state);
        $action = $request->query->get('a');

        $error = null;
        if ($action !== null) {
            try {
                $door->$action();
            } catch (\LogicException $e) {
                $error = $e->getMessage();
            }
        }


        return $this->render('door.html.twig', [
            'error' => $error,
            'action' => $action,
            'state' => $state,
            'door' => $door,
        ]);
    }
}
