<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 9:40 PM
 */

namespace WSBundle\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use WSBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    public function getByEmailAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $email = $data['email'];

            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            if ($user != null){
                $userJson = array(
                    "id" => $user->getId(),
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "birthDate" => $user->getBirthDate()->format("Y/m/d H:m:s"),
                    "bio" => $user->getBio(),
                );
                return new JsonResponse($userJson);
            }else {
                return new JsonResponse(array("type" => "User not found"));
            }

        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function getByEmailWithCountAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $qb = $em->createQueryBuilder();

            $email = $data['email'];

            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            if ($user != null){

                $parameters = array(
                    'user' => $user->getId(),
                );

                $qb->select('g')
                    ->from('WSBundle:CollaborationGroup','g')
                    ->Join('WSBundle:Membership', 'm', 'WITH' , "g.id = m.CollaborationGroup")
                    ->Where('m.user = :user')
                    ->setParameters($parameters);
                $groupsList = $qb->getQuery()->getArrayResult();

                $count=0;
                foreach ($groupsList as $group) {

                    $parameters3 = array(
                        'collaborationGroup' => $group['id'],
                    );
                    $qba = $em->createQueryBuilder();
                    $qba->select('count(project.id)');
                    $qba->from('WSBundle:Project','project')
                        ->Where('project.collaborationGroup = :collaborationGroup')
                        ->setParameters($parameters3);

                    $count += $qba->getQuery()->getSingleScalarResult();

                }

                $contributions=0;
                $parameters4 = array(
                    'user' => $user->getId()
                );
                $qbc = $em->createQueryBuilder();
                $qbc->select('count(payment.id)');
                $qbc->from('WSBundle:Payment','payment')
                    ->Where('payment.user = :user')
                    ->setParameters($parameters4);

                $contributions += $qbc->getQuery()->getSingleScalarResult();


                $countJson = array(
                    "id" => $user->getId(),
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "birthDate" => $user->getBirthDate()->format("Y/m/d H:m:s"),
                    "bio" => $user->getBio(),
                    "projectsCount" => $count,
                    "contributions" => $contributions,
                );
                return new JsonResponse($countJson);
            }else {
                return new JsonResponse(array("type" => "User not found"));
            }

        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function newAction(Request $request) //tested
    {
        // Json test

        /*   {
               "id" : "3",
       "email" : "mohamed@gmail.com",
       "firstname" : "mohamed",
       "lastname" : "kalia",
       "birthdate" : "2017-11-29 23:51:54.000000",
       "bio" : "mybio2"

   }
        */
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $user = new User();

        if ($request->isMethod('POST')) {
            $email = $data['email'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $birthdate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['birthdate']);
            $bio = $data['bio'];

            $user->setEmail($email);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setBirthDate($birthdate);
            $user->setBio($bio);

            if (count($errors) == 0) {

                $em->persist($user);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function updateAction(Request $request) //test
    {

        //Json Test
        /* {
             "id" : "3",
     "email" : "mohamed@gmail.com",
     "firstname" : "mohamed",
     "lastname" : "kalia",
     "bio" : "mybio2"

 }*/

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            $email = $data['email'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            //$email = $data['email'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $birthdate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['birthdate']);
            $bio = $data['bio'];

            //$user->setEmail($email);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setBirthDate($birthdate);
            $user->setBio($bio);

            if (count($errors) == 0) {

                $em->persist($user);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function deleteAction(Request $request) //tested
    {

        //Json Test

        /* {
             "id" : "2"

 }*/
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();



        if ($request->isMethod('POST')) {
            $id = $data['id'];
            $user = $em->getRepository('WSBundle:User')->find($id);

            if (count($errors) == 0) {

                $em->remove($user);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function updateTokenAction(Request $request) //test
    {

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            $email = $data['email'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email' => $email));
            //$email = $data['email'];
            $IdToken = $data['token'];
            $user->setToken($IdToken);

            if (count($errors) == 0) {

                $em->persist($user);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }
}
