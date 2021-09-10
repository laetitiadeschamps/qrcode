<?php

namespace App\Controller\Api;

use App\Entity\QrCode;
use App\Entity\User;
use App\Repository\QrCodeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/v1/qrcodes", name="api_qr_code-")
 */
class QrCodeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em )
    {
        $this->em=$em;
    }
    /**
    * @Route("", name="list", methods={"GET"})
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
     /**
    * @Route("", name="add", methods={"POST"})
    */
    public function add(QrCodeRepository $qrCodeRepository, UserRepository $userRepository, Security $security, Request $request, SerializerInterface $serializer): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $JsonData = $request->getContent();
        
        $code = new QrCode;
        $serializer->deserialize($JsonData, QrCode::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $code]); 
        $jsonArray = json_decode($request->getContent(), true);
        $code->setAuthor($user);
        $errors = [];
        
        foreach($jsonArray['users'] as $index => $userShared) {
           
            $user = $userRepository->findOneBy(['email'=>$userShared['mail']])?? '';
            if($user) {
                $code->addSharedWith($user);   
            } else {
                $errors[]= "Le mail " . $userShared['mail'] ." n'est pas valide";
            }
            
               
        }
        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $this->em->persist($code);
        $this->em->flush();
        
        return $this->json($code, 200, [], [
            'groups'=>'read:qrcodes'
        ]);
    }
}
