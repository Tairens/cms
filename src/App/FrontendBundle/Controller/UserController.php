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
    /* Need to use serializer in next version! */
    private function userMenuToArray($object) {
        $data = array();
        $data['url'] = $object->getUrl();
        $data['icon'] = $object->getIcon();
        $data['color'] = $object->getColor();
        $data['position'] = $object->getPosition();
        return $data;
    }

    public function registerAction() {
        $view = 'AppFrontendBundle:User:register.html.twig';
        return $this->render($view, array());
    }

    public function loginAction() {
        try {
            new \App\FrontendBundle\Library\User($this->getDoctrine());
        } catch (\Exception $ex) {
            $view = 'AppFrontendBundle:User:login.html.twig';
            return $this->render($view, array());
        }
        return $this->redirect('/staticcontent/new');
    }

    public function confirmRegisterAction() {
        
    }

    public function registerLoggedUserAction() {
        $data = array();
        try {
            $user = new \App\FrontendBundle\Library\User($this->getDoctrine());
            $data['validation'] = true;
            $data['user'] = $user->get()->
            $data['objects'] = array();
            $objects = $this->getDoctrine()->getRepository('AppFrontendBundle:UserMenu')->findBy(array('userId' => $user->get()->getId()));
            foreach ($objects as $object) {
                $data['objects'][] = $this->userMenuToArray($object);
            }
        } catch (\Exception $ex) {
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
        if (\App\FrontendBundle\Library\User::create($this->getDoctrine(), $email, $password)) {
            $data['validation'] = true;
            $data['validationText'] = 'Logged in to account. ';
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }

    public function logoutAction() {
        $data = array();
        try {
            $user = new \App\FrontendBundle\Library\User($this->getDoctrine());
            $user->delete();
            $data['validation'] = true;
            $data['validationText'] = 'You logged out.';
        } catch (\Exception $ex) {
            $data['err'] = $ex->getMessage();
            $data['validation'] = false;
            $data['validationText'] = 'You are not logged in.';
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }

    public function addUserMenuItemAction(\Symfony\Component\HttpFoundation\Request $request) {
        $data = array();
        try {
            $data['validation'] = true;
            $user = new \App\FrontendBundle\Library\User($this->getDoctrine());
            $icon = $request->get('icon');
            $url = $request->get('url');
            $color = $request->get('color');
            $position = $request->get('position');
            $newIcon = new \App\FrontendBundle\Entity\UserMenu();
            $newIcon->setColor($color);
            $newIcon->setIcon($icon);
            $newIcon->setPosition($position);
            $newIcon->setUrl($url);
            $newIcon->setUserId($user->get()->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newIcon);
            $em->flush();
        } catch (Exception $ex) {
            $data['validation'] = true;
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }

}
