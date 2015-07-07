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

    private static $userSessionID = "USER_ID";
    private static $expirationTimeSessionID = "EXPIRATION_TIME_ID";
    private $user;
    private $expirationTime;
    private $doctrine;

    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        if ($session->get(self::$userSessionID)) {
            $userid = $session->get(self::$userSessionID);
            $this->user = $this->doctrine->getRepository('AppFrontendBundle:User')->find($userid);
            $this->expirationTime = $session->get(self::$expirationTimeSessionID);
            if (!$this->user) {
                throw new \Exception('Cannot find user with with id ' . $userid . '.');
            }
        } else {
            throw new \Exception('Session doesn\'t exist.');
        }
    }

    public function getExpirationTime() {
        return $this->expirationTime;
    }

    public function delete() {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $session->set(self::$userSessionID, NULL);
        $session->set(self::$expirationTimeSessionID, NULL);
    }

    public function get() {
        return $this->user;
    }

    public static function create($doctrine, $email, $password, $time = 15) {
        $user = $doctrine->getRepository('AppFrontendBundle:User')->findOneBy(array('email' => $email));
        if ($user) {
            if ($user->getPassword() == $password) {
                $session = new \Symfony\Component\HttpFoundation\Session\Session();
                $session->set(self::$userSessionID, $user->getId());
                $session->set(self::$expirationTimeSessionID, time() + ($time * 60 * 1000));
                return true;
            }
        }
        return false;
    }

}
