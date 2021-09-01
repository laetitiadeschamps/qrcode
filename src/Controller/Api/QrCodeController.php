<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QrCodeController extends AbstractController
{
    /**
     * @Route("/api/v1/qrcodes", name="api_qr_code")
     */
    public function index(): Response
    {
        return $this->render('api/qr_code/index.html.twig', [
            'controller_name' => 'QrCodeController',
        ]);
    }
}
