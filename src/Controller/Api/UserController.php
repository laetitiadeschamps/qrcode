<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
* @Route("/api/v1/user", name="user_")
*/
class UserController extends AbstractController
{
    
    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $JsonData = $request->getContent();
        $user = new User();
        $serializer->deserialize($JsonData, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]); 
        $user->setRoles(['ROLE_USER']);
        //TODO Validation 
        // $errors = $this->validator->validate($user, null, ['add']);
        // //If there are any errors, we send back a list of errors (reformatted for clearer output)
        // if (count($errors) > 0) {
        //     $errorslist = array();
        //     foreach ($errors as $error) {
        //         $field = $error->getPropertyPath();
        //         $errorslist[$field] = $error->getMessage();
        //     }
        //     return $this->json($errorslist, 400);
        // }
        $user->setPassword(
            $passwordEncoder->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        $this->em->persist($user);
        $this->em->flush();
        return $this->json($user);
    }
}
