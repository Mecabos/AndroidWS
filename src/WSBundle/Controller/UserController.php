<?php

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

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $data=json_decode($request->getContent(),true);
        $values = array();
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $user = new User();

        if ($request->isMethod('POST')) {
            $email = $data['email'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];

            $values['email'] = $email;
            $values['firstname'] = $firstname;
            $values['lastname'] = $lastname;

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
