<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Marek S
 */

namespace App\FrontendBundle\Library;


class User {
    private $userSessionID = "USER_ID";
    private $expirationTimeSessionID = "EXPIRATION_TIME_ID";
    
    private $user;
    private $time;
    private $expirationTime;
    private $doctrine;
    
    public function __construct($doctrine, $time = 15) {
        $this->doctrine = $doctrine;
        if(isset($_SESSION[$this->userSessionID])){
            $userid = (int)$_SESSION[$this->userSessionID];
            $this->user = $this->doctrine->getRepository('AppFrontendBundle:User')->find($userid);
            $this->expirationTime = $_SESSION[$this->expirationTimeSessionID];;
            if(!$this->user){
                throw new \Exception('Cannot find user with with id ' . $userid . '.');
            }
        }
        else{
            throw new \Exception('Session doesn\'t exist.');
        }
    }
    
    public function getExpirationTime(){
        return $this->expirationTime;
    }
    
    public function delete(){
        unset($_SESSION[$this->userSessionID]);
        unset($_SESSION[$this->expirationTimeSessionID]);
    }

    public static function create($doctrine, $email, $password, $time = 15){
        $user = $doctrine->getRepository('AppFrontendBundle:User')->findOneBy(array('email' => $email));
        if($user){
            if($user->getPassword() == $password){
                $_SESSION[$object->userSessionID] = $user->getId();
                $_SESSION[$object->expirationTimeSessionID] = time() + ($time * 60 * 1000);
                return true;
            }
        }
        return false;
    }
}
