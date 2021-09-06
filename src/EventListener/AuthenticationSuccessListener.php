<?php

namespace App\EventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;

class AuthenticationSuccessListener extends Event
{


    /**
     * @param AuthenticationSuccessEvent $event
     */
    
    
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();

        /** @var User $user */

        $user = $event->getUser();
    
        if (!$user instanceof UserInterface) {
            return;
        }
    
        $data += array(
            'email'=>$user->getEmail(),
            'id'=>$user->getId(),
           
        );
    
        $event->setData($data);
    }
}