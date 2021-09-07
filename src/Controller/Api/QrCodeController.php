<?php

namespace App\Controller\Api;

use App\Repository\QrCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class QrCodeController extends AbstractController
{
    /**
     * @Route("/api/v1/qrcodes", name="api_qr_code")
     */
    public function index(QrCodeRepository $qrCodeRepository, Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $qrcodesOwned = $qrCodeRepository->findBy(['author'=> $user]);
        $qrcodesShared = $qrCodeRepository->findShared($user);
        $qrcodes['owned'] = $qrcodesOwned;
        $qrcodes['shared'] = $qrcodesShared;
       
     
        return $this->json($qrcodes, 200, [], [
            'groups'=>'read:qrcodes'
        ]);
    }
}
