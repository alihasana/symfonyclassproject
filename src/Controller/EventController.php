<?php

namespace App\Controller;

use App\Controller\MasterController;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

class EventController extends MasterController
{
    public function register(Request $request){
        dump('Inside EventController register');
        
        $em = $this->getDoctrine()->getManager();
        $event = new Event($request->get("name"), $request->get("type"), $request->get("dateEvent"), $this->getUser());
        try {
            $em->persist($event);
            $em->flush();
            return $this->returnJson(["Event created"], 200);
        } catch (Doctrine\ORM\EntityNotFoundException $e) {
            return $this->returnJson([ $e->getMessage() ], 403);
        }
    }
    
}
