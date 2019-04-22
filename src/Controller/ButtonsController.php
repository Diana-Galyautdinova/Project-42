<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ButtonsController extends AbstractController
{

    /**
     * @Route("/ajax42/", name="ajax42")
     */
    public function index(LoggerInterface $logger, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $logger->debug($request->request->get('name'));

            return new JsonResponse([
                'response' => $request->request->get('name')
            ]);
        }

        return $this->render('Buttons/index.html.twig');
    }
}
