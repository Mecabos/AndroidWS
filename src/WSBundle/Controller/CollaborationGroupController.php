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
use Symfony\Component\Validator\Constraints\Date;
use WSBundle\Entity\CollaborationGroup;
use WSBundle\Entity\Membership;
use WSBundle\Entity\User;

class CollaborationGroupController extends Controller
{

    public function newAction(Request $request)//success
    {

        //Json test
 /*       {
            "name": "group 1",
    "creator": "1"
}*/
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $collaborationGroup = new CollaborationGroup();

        if ($request->isMethod('POST')) {
            $name = $data['name'];
            $creationDate = new DateTime();
            $creatorEmail = $data['creatorEmail'];

            $collaborationGroup->setName($name);
            $collaborationGroup->setCreationDate($creationDate);
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $creatorEmail));
            $collaborationGroup->setCreator($user);


            if (count($errors) == 0) {

                $em->persist($collaborationGroup);
                $em->flush();
            }

            $em2=$this->getDoctrine()->getManager();
            $membership = new Membership();
            $adherationDate = new DateTime();
            $membership->setUser($user);
            $membership->setIsAdmin(1);
            $membership->setCollaborationGroup($collaborationGroup);
            $membership->setAdherationDate($adherationDate);

            $em2->persist($membership);
            $em2->flush();

            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function updateNameAction(Request $request)//success
    {
        //Json test
       /* {
            "id" : "4",
	"name" : "new group"
}
*/

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $oldName = $data['oldName'];
            $newName = $data['newName'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->findOneBy(array('name' => $oldName));
            $collaborationGroup->setName($newName);

            if (count($errors) == 0) {

                $em->persist($collaborationGroup);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function getByAdminUserAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        if ($request->isMethod('POST')) {

            $email = $data['email'];

            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            if ($user != null) {
                $parameters = array(
                    'user' => $user->getId(),
                );

                $qb->select('g')
                    ->from('WSBundle:CollaborationGroup','g')
                    ->Join('WSBundle:Membership', 'm', 'WITH' , "g.id = m.CollaborationGroup")
                    ->Where('m.isAdmin =1')
                    ->andWhere('m.user = :user')
                    ->setParameters($parameters);
                $groupsList = $qb->getQuery()->getArrayResult();
                $groupsListJson = array();
                foreach ($groupsList as $group) {
                    array_push($groupsListJson,array(
                        "id" => $group['id'],
                        "name" => $group['name'],
                    ));
                }
                return new JsonResponse($groupsListJson);
            }

            return new JsonResponse(array("type" => "no user with that mail"));

        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function getByUserAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb2 = $em->createQueryBuilder();
        //$qb3 = $em->createQueryBuilder();
        //$qb4 = $em->createQueryBuilder();
        if ($request->isMethod('POST')) {

            $email = $data['email'];

            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            if ($user != null) {
                $parameters = array(
                    'user' => $user->getId(),
                );

                $qb->select('g')
                    ->from('WSBundle:CollaborationGroup','g')
                    ->Join('WSBundle:Membership', 'm', 'WITH' , "g.id = m.CollaborationGroup")
                    ->Where('m.user = :user')
                    ->setParameters($parameters);
                $groupsList = $qb->getQuery()->getArrayResult();
                $groupsListJson = array();

                foreach ($groupsList as $group) {

                    //creator
                    /*$creator = new User();
                    $creator = $em->getRepository('WSBundle:User')->find($group['creator']);


                    $parameters2 = array(
                        'creator' => $group['creator'],
                    );
                    $qb2->select('u')
                        ->from('WSBundle:User','u')
                        ->Join('WSBundle:CollaborationGroup', 'gr', 'WITH' , "u.id = gr.creator")
                        //->Where('m.isAdmin =1')
                        ->Where('gr.creator = :creator')
                        ->setParameters($parameters2);
                    $userCreator = $qb2->getQuery()->getResult();*/




                    $parameters3 = array(
                        'collaborationGroup' => $group['id'],
                    );


                    $qba = $em->createQueryBuilder();
                    $qba->select('count(project.id)');
                    $qba->from('WSBundle:Project','project')
                        ->Where('project.collaborationGroup = :collaborationGroup')
                        ->setParameters($parameters3);

                    $count = $qba->getQuery()->getSingleScalarResult();


                    $qbb = $em->createQueryBuilder();
                    $qbb->select('count(membership.isAdmin)');
                    $qbb->from('WSBundle:Membership','membership')
                        ->Where('membership.CollaborationGroup = :collaborationGroup')
                        ->setParameters($parameters3);

                    $countMembers = $qbb->getQuery()->getSingleScalarResult();



                    $membership = $em->getRepository('WSBundle:Membership')->findOneBy(array('user' => $user, 'CollaborationGroup' => $group['id']));
                    $isAdmin = $membership->getIsAdmin();

                    $date = $group['creationDate'];
                    $creationDate = $date->format('Y/m/d H:m:s');

                    array_push($groupsListJson,array(
                        "id" => $group['id'],
                        "name" => $group['name'],
                        "creationDate" => $creationDate,
                        "projectsCount" => $count,
                        "isUserAdmin" => $isAdmin,
                        "countMembers" => $countMembers,
                        //"creator" => $creatorid,
                        //"creator" => $group['creator'],
                    ));
                }
                return new JsonResponse($groupsListJson);
            }

            return new JsonResponse(array("type" => "no user with that mail"));

        }
        return new JsonResponse(array("type" => "failed"));
    }

}