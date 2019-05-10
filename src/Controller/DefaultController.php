<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    public function home(Request $request){
        dump('Inside Home');
        $user = ["name" => $this->getUser()->getName(), "email" => $this->getUser()->getEmail(),  ];
        dump($user);
        $name = $request->query->get('name');
        $array  = ["01" => "Aliquam", "02" => "Tempus", "03" => "Magna", "04" => "Ipsum", "05" => "Consequat", "06" => "Etiam"];
        if(!empty($name)) {
            $array = shuffle($array);
        }
        $data = [
        "img" => $array,
        "user" => $user
        ];

        return $this->render('home/home.html.twig', $data);
    }

    // function shuffleArray($name, $array) {
    //     $newArray = [];
    //     for ($i=0; $i < count($array); $i++) { 
    //         if($array[$i] !== $name )
    //             array_push($newArray, $array[$i]);
    //     }
    //     array_rand($newArray);
    //     array_unshift($newArray, $name)
    //     return $newArray;
    // }
}