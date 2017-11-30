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
            $id_user = $data['id'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
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
}
