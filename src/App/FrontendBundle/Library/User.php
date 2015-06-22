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
    static public $doctrine;
    static public $instance;
    
    private $userSessionID = "USER_ID";
    private $expirationTimeSessionID = "EXPIRATION_TIME_ID";
    
    private $user;
    private $time;
    private $expirationTime;
    
    public function __construct($time = 15) {
        if(isset($_SESSION[$this->userSessionID])){
            $userid = (int)$_SESSION[$this->userSessionID];
            $this->user = self::$doctrine->getRepository('AppFrontendBundle:User')->find($userid);
            $this->expirationTime = $_SESSION[$this->expirationTimeSessionID];
            $this->time = $time * 60 * 1000;
            if(!$this->user){
                throw new \Exception('Cannot find user with with id ' . $userid . '.');
            }
        }
    }
    
    public function getExpirationTime(){
        return $this->expirationTime;
    }
    
    public function getDoctrineObject(){
        return $this->user;
    }
    
    public function delete(){
        unset($_SESSION[$this->userSessionID]);
        unset($_SESSION[$this->expirationTimeSessionID]);
    }


    public static function create($email, $password, $time = 15){
        $object = new User($time);
        $user = self::$doctrine->getRepository('AppFrontendBundle:User')->findOneBy(array('email' => $email));
        if($user){
            if($user->getPassword() == $password){
                $object->user = $user;
                $object->expirationTime = time() + $object->time;
                $_SESSION[$object->userSessionID] = $user->getId();
                $_SESSION[$object->expirationTimeSessionID] = $object->expirationTime;
                self::$instance = $object;
                return true;
            }
        }
        return false;
    }
}
