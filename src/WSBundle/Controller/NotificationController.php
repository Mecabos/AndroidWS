<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 12/13/2017
 * Time: 2:43 AM
 */

namespace WSBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NotificationController
{

    public function newAction(Request $request) //tested
    {

        /* $data=json_decode($request->getContent(),true);
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
         return new JsonResponse(array("type"=>"failed"));*/


        $data = json_decode($request->getContent(), true);
        //echo 'Hello';

        //   $registrationIds = ;

        if ($request->isMethod('POST')||$request->isMethod('GET')) {
            $token = $data['token'];
            $title = $data['title'];
            $body = $data['body'];

            define('API_ACCESS_KEY', 'AAAADE6C8fQ:APA91bFDjrv4Ssw6YcJs52ppa0XW6Cf3aPP53rh9tOFywh7ciGkVZKt44XaY0fwvB8nwzk_Pgb3ieF4NHqfDKYD_yZpKiOyR7hlyTvhs-R4E7uLazAPQayzKUeJVtgbYtHeycgmEAKNZ');
            $msg = array
            (
                'body' => $body,
                'title' => $title,

            );
            $fields = array
            (
                'to' => $token,
                'notification' => $msg
            );


            $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            echo $result;
            curl_close($ch);

            return new JsonResponse(array("type" => "success"));
        }
        return new JsonResponse(array("type" => "failed"));

    }
}