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
use WSBundle\Entity\CollaborationGroup;
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
            $adherationDate = new DateTime();
            $isAdmin = $data['isAdmin'];
            $email = $data['email'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            $groupName = $data['groupName'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->findOneBy(array('name' => $groupName));

            $membership->setUser($user);
            $membership->setCollaborationGroup($collaborationGroup);
            $membership->setIsAdmin($isAdmin);
            $membership->setAdherationDate($adherationDate);

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
            $groupName = $data['groupName'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->findOneBy(array('name' => $groupName));
            $membership = $em->getRepository('WSBundle:Membership')->findOneBy(array('user' => $id_user,'CollaborationGroup' => $collaborationGroup->getId()));

            if (count($errors) == 0) {

                $em->remove($membership);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function getByGroupNameAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $name = $data['groupName'];
            //$collaborationGroup= new CollaborationGroup();
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->findOneBy(array('name' => $name));
            $groupId=$collaborationGroup->getId();

            $memberList = $em->getRepository('WSBundle:Membership')->findBy(array('CollaborationGroup' => $groupId));

            $userListJson = array();
            foreach ($memberList as $membership) {

                $user = $em->getRepository('WSBundle:User')->find($membership->getUser());

                $userListJson[] = array(
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "id" => $user->getId(),
                );

            }
            return new JsonResponse($userListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }
}