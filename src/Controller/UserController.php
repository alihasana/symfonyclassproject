<?php
namespace App\Controller;

use App\Controller\MasterController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends MasterController {
    public function register(Request $request, UserPasswordEncoderInterface $encodePass){
        dump('Inside register');
        
        if(!filter_var( $request -> get("email"), FILTER_VALIDATE_EMAIL ))
            return $this->returnJson(["PLEASE PROVIDE VALIDE EMAIL SYNTAX"], 403);
        $er = $this->getDoctrine()->getRepository(User::Class);
        $theUser = $er->findOneBy(["email" => $request->get("email")]);
        dump($theUser);
        if(!$theUser) {
            $em = $this->getDoctrine()->getManager();
            $user = new User($request->get("name"), $request->get("email"), $request->get("password"));
            $user->setPassword($encodePass->encodePassword($user, $request->get("password")));
            try {
               $em->persist($user);
               $em->flush();
               return $this->returnJson(["User created"], 200);
            } catch (Doctrine\ORM\EntityNotFoundException $e) {
                return $this->returnJson([ $e->getMessage() ], 403);
            }
        } else return $this->returnJson(["Email already exits"], 200);
         //   return $this->render('register/register.html.twig');
    }

    public function getLogin(){
        dump('Inside getLogin');
        return $this->redirectToRoute('index');
    }
    
    public function postLogin(AuthenticationUtils $authenticationUtils){
        dump('Inside postLogin');
        $error = $authenticationUtils->getLastAuthenticationError();
        $email = $authenticationUtils->getLastUsername();
        return $this -> redirectToRoute('login_post');
    }

    

    /** 
     * Return in JSON Formate
     * @param 
     */
    private function returnJson($data, $status = 200) {
        return new Response(json_encode($data), $status, ["Content-Type" => "application/json"]);
    }
} 