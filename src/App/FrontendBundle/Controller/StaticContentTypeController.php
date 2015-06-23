<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticContentTypeController
 *
 * @author Marek S
 */
namespace App\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticContentTypeController extends Controller{
    
    public function editAction(Request $request) {
        $id = $request->getRequest()->get('id');
        $name = $request->getRequest()->get('name');
        $desc = $request->getRequest()->get('description');
        
        $sct = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->find($id);
        $data = array();
        if($sct){
            $sctn = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->findOneBy(array('name' => $name));
            if($sctn){
                $data['validationText'] = 'Static content type exists with this type.';
            }
            else{
                $data['validationText'] = 'Static content type created.';
                $sct->setName($name);
                $sct->setDescription($desc);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($sc);
                $em->flush();
            }
        }
        else{
            $data['validationText'] = 'Cannot find static content type.';
        }
        return \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
    
    public function getAction($id) {
        $sct = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->find($id);
        $data = array();
        $data['validation'] = false;
        if($sct){
            $data['validation'] = true;
            $data['name'] = $sct->getName();
            $data['description'] = $sct->getDescription();
        }
        return \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
    
    public function createAction() {
        
    }
}
