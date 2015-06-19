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
    
    public function confirmRegisterAction(){
        
    }
    
    public function loginAction(){
        $view = 'AppFrontendBundle:User:login.html.twig';
        return $this->render($view, array());
    }
    
    public function loginConfirmAction(\Symfony\Component\HttpFoundation\Request $request) {
        $email = $request->request->get('title');
        $password = $request->request->get('typeName');
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $data = array();
        $data['validationText'] = 'Invalid email or password.';
        if(\App\FrontendBundle\Library\User::create($email, $password)){
            $data['validationText'] = 'Logged in to account. ';
        }
        $response->setData($data);
        return $response;
    }

    public function logoutAction() {
        if(isset(\App\FrontendBundle\Library\User::$instance)){
            unset(\App\FrontendBundle\Library\User::$instance);
        }
    }

}
