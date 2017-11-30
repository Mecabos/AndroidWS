<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/30/2017
 * Time: 1:15 AM
 */

namespace WSBundle\Controller;


use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\Membership;

class MembershipController extends Controller
{

    public function addMemberAction(Request $request) //success
    {
        //json test
        /*{
            "id_user" : "3",
	"id_group" : "4",
	"isAdmin" : 0
}*/
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $membership = new Membership();

        if ($request->isMethod('POST')) {
            //$adherationDate = $data['adherationDate'];
            $isAdmin = $data['isAdmin'];
            $id_user = $data['id_user'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
            $id_collaborationGroup = $data['id_group'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->find($id_collaborationGroup);


            $membership->setUser($user);
            $membership->setCollaborationGroup($collaborationGroup);
            $membership->setIsAdmin($isAdmin);
            $membership->setAdherationDate(new DateTime()); //TODO

            if (count($errors) == 0) {

                $em->persist($membership);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function deleteMemberAction(Request $request) //success
    {

        //json Test
/*        {
            "id_user" : "3",
	"id_group" : "4"
}
*/

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $id_user = $data['id_user'];
            $id_group = $data['id_group'];
            $membership = $em->getRepository('WSBundle:Membership')->findOneBy(array('user' => $id_user,'CollaborationGroup' => $id_group));

            if (count($errors) == 0) {

                $em->remove($membership);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }
}