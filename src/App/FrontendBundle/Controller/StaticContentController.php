<?php

namespace App\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticContentController extends Controller
{
    public function createAction(){
        $types = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->findAll();
        $view = 'AppFrontendBundle:StaticContent:create.html.twig';
        return $this->render($view, array('page_title' => 'Create new', 'types' => $types));
    }
    
    public function editAction($id){
        $obj= $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContent')->find($id);
        if($obj){
            $types = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->findAll();
            $view = 'AppFrontendBundle:StaticContent:create.html.twig';
            return $this->render($view, array('page_title' => 'Edit ' . $obj->getTitle(), 'types' => $types));
        }
       throw $this->createNotFoundException('No content found for id '.$id );
    }
    
    public function validateCreationAction(\Symfony\Component\HttpFoundation\Request $request){
        $pageTitle = $request->request->get('title');
        $pageType = $request->request->get('typeName');
        $content = $request->request->get('content');
        $title = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContent')->findOneBy(array('title' => $pageTitle));
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $data = array();
        $data['validation'] = false;
        if(!$title){
            $type = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->findOneBy(array('name' => $pageType));
            if($type){
                $data['validation'] = true;
                $data['validationText'] = 'Object created.';
                
                $sc = new \App\FrontendBundle\Entity\StaticContent();
                $sc->setTitle($pageTitle);
                $sc->setTypeId($type->getId());
                $sc->setContent($content);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($sc);
                $em->flush();

            }
            else{
                $data['validationText'] = 'This type doesn\'t exists in databse.';
            }
        }
        else{
            $data['validationText'] = 'This name exists in database';
        }
        $response->setData($data);
        return $response;
    }
    
    public function validateEditAction(\Symfony\Component\HttpFoundation\Request $request){
        $pageTitle = $request->request->get('title');
        $pageType = $request->request->get('typeName');
        $content = $request->request->get('content');
        $id = $request->request->get('id');
        $obj = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContent')->find($id);
        if($obj){
            $title = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContent')->findOneBy(array('title' => $pageTitle));
            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $data = array();
            $data['validation'] = false;
            if(!$title){
                $type = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->findOneBy(array('name' => $pageType));
                if($type){
                    $data['validation'] = true;
                    $data['validationText'] = 'Object edited.';

                    $em = $this->getDoctrine()->getManager();
                    
                    $sc = $em->getRepository('AppFrontendBundle:StaticContent')->find($id);
                    $sc->setTitle($pageTitle);
                    $sc->setTypeId($type->getId());
                    $sc->setContent($content);
                    
                    $em->flush();

                }
                else{
                    $data['validationText'] = 'This type doesn\'t exists in databse.';
                }
            }
            else{
                $data['validationText'] = 'This name exists in database';
            }
        }
        else{
            $data['validationText'] = 'Object not found.';
        }
        $response->setData($data);
        return $response;
    }
    
    public function getAction($id){
        $object = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContent')->find($id);
        $type = $this->getDoctrine()->getRepository('AppFrontendBundle:StaticContentType')->find($object->getTypeId());
        $data = array();
        $data['title'] = $object->getTitle();
        $data['content'] = $object->getTitle();
        $data['typeName'] = $type->getName();
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
}
