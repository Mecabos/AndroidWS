<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 9:40 PM
 */

namespace WSBundle\Controller;

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

    public function newAction(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $user = new User();

        if ($request->isMethod('POST')) {
            $email = $data['email'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];

            $user->setEmail($email);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);

            if (count($errors) == 0) {

                $em->persist($user);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }
}
