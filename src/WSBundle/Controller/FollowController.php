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

    public function addFollowAction(Request $request)
    {

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();
        $follow = new Follow();

        if ($request->isMethod('POST')) {
            //$followDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['followDate']);
            $followDate = new DateTime();
            $email_user = $data['email_user'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email'=>$email_user));
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

    public function deleteAction(Request $request)

    {
        $errors = array() ;
        $id = $request->get('id');
        $em=$this->getDoctrine()->getManager();
        $follow=$em->getRepository('WSBundle:Follow')->find($id);
        $em->remove($follow);
        $em->flush();
        return new JsonResponse(array("type"=>"success",'errors' => $errors));
    }

    public function countByProjectAction (Request $request){
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        if ($request->isMethod('POST')) {

            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);
            if ($project != null) {
                $parameters = array(
                    'project' => $project->getId(),
                );

                $qb->select('COUNT(f)')
                    ->from('WSBundle:Follow','f')
                    ->Where('f.project = :project')
                    ->setParameters($parameters);
                $followsCount = $qb->getQuery()->getSingleScalarResult();
                return new JsonResponse(array ("followsCount" => $followsCount));
            }

            return new JsonResponse(array("type" => "no user with that mail"));

        }
        return new JsonResponse(array("type" => "failed"));
    }



}