<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 9:40 PM
 */

namespace WSBundle\Controller;


use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\CollaborationGroup;

class CollaborationGroupController extends Controller
{

    public function newAction(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $group = new CollaborationGroup();

        if ($request->isMethod('POST')) {
            $name = $data['name'];
            //$creationDate = $data['creationDate'];
            $group->setName($name);
            //$group->setCreationDate($creationDate);
            $group->setCreationDate(new DateTime());

            if (count($errors) == 0) {

                $em->persist($group);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }
}