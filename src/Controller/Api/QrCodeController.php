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
 * @Route("/api/v1/qrcodes", name="api_qr_code-", requirements={"id"="\d+"})
 */
class QrCodeController extends AbstractController
{
    private $em;
    private $qrCodeRepository;
    private $security;
    private $serializer;
    private $userRepository;
    public function __construct(EntityManagerInterface $em, QrCodeRepository $qrCodeRepository, Security $security, SerializerInterface $serializer, UserRepository $userRepository )
    {
        $this->em=$em;
        $this->qrCodeRepository = $qrCodeRepository;
        $this->security = $security;
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
    }
    /**
    * @Route("", name="list", methods={"GET"})
    */
    public function index(QrCodeRepository $qrCodeRepository, Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $qrcodesOwned = $qrCodeRepository->findOwned($user);
        $qrcodesShared = $qrCodeRepository->findShared($user);
        $qrcodes['owned'] = $qrcodesOwned;
        $qrcodes['shared'] = $qrcodesShared;
       
     
        return $this->json($qrcodes, 200, [], [
            'groups'=>'read:qrcodes'
        ]);
    }
     /**
    * @Route("/{id}", name="detail", methods={"GET"})
    */
    public function detail(int $id): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $qrcode = $this->qrCodeRepository->find($id);
        if($qrcode->getAuthor()!= $user) {
            return $this->json(["message"=>"Vous n'avez pas le droit de modifier ce code"], 403);  
        }
       
        return $this->json($qrcode, 200, [], [
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
       

        if(count($jsonArray['users']) > 0) {
            $errorslist = [];
            foreach($jsonArray['users'] as $index => $userShared) {
                if(!$userShared['mail'] == '') {
                    $user = $userRepository->findOneBy(['email'=>$userShared['mail']])?? '';
                    if($user) {
                        $code->addSharedWith($user);   
                    } else {
                        $errorslist[]['error']= "Le mail " . $userShared['mail'] ." n'est pas valide";
                    }  
                }
                     
            }
        }
        
        if(isset($errorslist) && count($errorslist) > 0) {
            return $this->json($errorslist, 400);
        }
        $this->em->persist($code);
        $this->em->flush();
        
        return $this->json(["message"=>"Le code a bien été créé"], 201);
    }
     /**
    * @Route("/{id}", name="delete", methods={"DELETE"})
    */
    public function delete(int $id): Response
    {
        $code = $this->qrCodeRepository->find($id);

        $this->em->remove($code);
        $this->em->flush();
        
        return $this->json(["message"=>"Le code a bien été supprimé"], 204);
    }
     /**
    * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
    */
    public function update(int $id, Request $request): Response
    {
          /** @var User $user */
          $user = $this->security->getUser();
          $JsonData = $request->getContent();
        $code = $this->qrCodeRepository->find($id);
        $this->serializer->deserialize($JsonData, QrCode::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $code,  AbstractNormalizer::IGNORED_ATTRIBUTES => ['id']]); 
        $jsonArray = json_decode($request->getContent(), true);

        //reset shared with to then populate it again
        foreach($code->getSharedWith() as $user) {
               $code->removeSharedWith($user);
        }
           
        if(count($jsonArray['users']) > 0) {
            $errorslist = [];
            foreach($jsonArray['users'] as $index => $userShared) {
                if(!$userShared['mail'] == '') {
                    $user = $this->userRepository->findOneBy(['email'=>$userShared['mail']])?? '';
                    if($user) {
                        $code->addSharedWith($user);   
                    } else {
                        $errorslist[]['error']= "Le mail " . $userShared['mail'] ." n'est pas valide";
                    }  
                }
                     
            }
        }
        if(isset($errorslist) && count($errorslist) > 0) {
            return $this->json($errorslist, 400);
        }

        $this->em->flush();
        
        return $this->json(["message"=>"Le code a bien été mis à jour"], 200);
    }
}
