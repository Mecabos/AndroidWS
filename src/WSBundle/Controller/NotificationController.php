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
        $data = json_decode($request->getContent(), true);
        //$tokens = $data['tokens'];
        //$jsonTokens = json_decode($tokens, true);



        if ($request->isMethod('POST')) {
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
                //'to' => $token,
                'registration_ids' => $token,
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