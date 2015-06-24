<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Marek S
 */

namespace App\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller {

    public function registerAction() {
        $view = 'AppFrontendBundle:User:register.html.twig';
        return $this->render($view, array());
    }
    
    public function loginAction(){
        $view = 'AppFrontendBundle:User:login.html.twig';
        return $this->render($view, array());
    }
    
    public function confirmRegisterAction(){
        
    }
    
    public function registerLoggedUserAction(){
        $data = array();
        try{
            $obj = new \App\FrontendBundle\Library\User($this->getDoctrine());
            $data['validation'] = true;
        } 
        catch (\Exception $ex) {
            $data['validation'] = false;
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
    
    public function loginConfirmAction(\Symfony\Component\HttpFoundation\Request $request) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $data = array();
        $data['validation'] = false;
        $data['validationText'] = 'Invalid email or password.';
        if(\App\FrontendBundle\Library\User::create($this->getDoctrine(), $email, $password)){
            $data['validation'] = true;
            $data['validationText'] = 'Logged in to account. ';
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }

    public function logoutAction() {
        $data = array();
        try{
            $user = new \App\FrontendBundle\Library\User($this->getDoctrine());
            $user->delete();
            $data['validation'] = true;
            $data['validationText'] = 'You logged out.';
        }
        catch(\Exception $ex){
            $data['validation'] = false;
            $data['validationText'] = 'You are not logged in.';
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
}
