<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/30/2017
 * Time: 4:11 AM
 */

namespace WSBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\Follow;

class FollowController extends Controller
{

    public function addFollowAction(Request $request) //success
    {

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();
        $follow = new Follow();

        if ($request->isMethod('POST')) {
            //$followDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['followDate']);
            $followDate = new DateTime();
            $id_user = $data['id_user'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);

            $follow->setUser($user);
            $follow->setProject($project);
            $follow->setFollowDate($followDate);


            if (count($errors) == 0) {

                $em->persist($follow);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));

        }
        return new JsonResponse(array("type"=>"failed"));

    }
}