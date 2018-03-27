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

    public function createAction(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $errors = array();

        $em = $this->getDoctrine()->getManager();
        $follow = new Follow();

        if ($request->isMethod('POST')) {

            $followDate = new DateTime();
            $email_user = $data['email_user'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email_user));
            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);

            $follow->setUser($user);
            $follow->setProject($project);
            $follow->setFollowDate($followDate);


            if (count($errors) == 0) {

                $em->persist($follow);
                $em->flush();
            }
            return new JsonResponse(array("type" => "success", 'errors' => $errors));

        }
        return new JsonResponse(array("type" => "failed"));

    }

    public function deleteAction(Request $request)

    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $errors = array();

        $email_user = $data['email_user'];
        $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email_user));
        $id_project = $data['id_project'];
        $project = $em->getRepository('WSBundle:Project')->find($id_project);

        $follow = $em->getRepository('WSBundle:Follow')->findOneBy(array('user' => $user, 'project' => $project));

        if ($follow != null) {
            $em->remove($follow);
            $em->flush();
            return new JsonResponse(array("type" => "success", 'errors' => $errors));
        } else {
            return new JsonResponse(array("type" => "success", 'errors' => array("no follow with that id found")));
        }
    }

    public function countByProjectAction(Request $request)
    {
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
                $qb->select('COUNT(f.followDate)')
                    ->from('WSBundle:Follow', 'f')
                    ->Where('f.project = :project')
                    ->setParameters($parameters);
                $followsCount = $qb->getQuery()->getSingleScalarResult();

                if (!array_key_exists('email_user', $data)) {
                    return new JsonResponse(array("followsCount" => $followsCount));
                } else {
                    $email_user = $data['email_user'];
                    $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email_user));
                    if ($user != null) {
                        $follow = $em->getRepository('WSBundle:Follow')->findOneBy(array('user' => $user, 'project' => $project));

                        return new JsonResponse(array("followsCount" => $followsCount, "hasFollowed" => $follow != null));
                    } else {
                        return new JsonResponse(array("type" => "no user found with mail " . $email_user . " to be able to test if he followed project"));
                    }
                }
            } else {
                return new JsonResponse(array("type" => "No project found with id " . $id_project));
            }
        }
        return new JsonResponse(array("type" => "Not a post request"));

    }


}