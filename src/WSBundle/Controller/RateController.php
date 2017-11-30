<?php

namespace WSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\Rate;

class RateController extends Controller
{
/*{
"value" : 3.5,
"rateDate" : "2016/12/01 12:12:00",
"id_user" : 1,
"id_project" : 1
}*/
    public function createAction(Request $request)
    {
        $errors = array();
        $data = json_decode($request->getContent(), true);

        $em=$this->getDoctrine()->getManager();

        $rate = new Rate();

        if ($request->isMethod('POST')) {
            $value = $data['value'];
            $rateDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['rateDate']);
            $id_user = $data['id_user'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);

            $rate->setRateDate($rateDate);
            $rate->setValue($value) ;
            $rate->setProject($project) ;
            $rate->setUser($user) ;

            if (count($errors) == 0) {

                $em->persist($rate);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed",'errors' => $errors));
    }

    public function updateAction(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            $id_user = $data['id_user'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);
            $rate = $em->getRepository('WSBundle:Rate')->findOneBy(array('user' => $user, 'project' => $project));
            $value = $data['value'];
            $rateDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['rateDate']);

            $rate->setValue($value);
            $rate->setRateDate($rateDate);
            $rate->setUser($user);
            $rate->setProject($project);

            if (count($errors) == 0) {

                $em->persist($rate);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }
}
