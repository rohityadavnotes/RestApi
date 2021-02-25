<?php
require_once('../data/Users.php');

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0)
{
    $response["status"]	= false;
	$response["code"]	= METHOD_NOT_ALLOWED;
    $response["message"]= 'Only post request allow';
	$response["data"]	= null;
	
	$jsonResponse = json_encode($response);
	header('Content-type: application/json');
    echo $jsonResponse;
}
else
{
    $provider       = $_POST['provider'];
    $socialId       = $_POST['socialId'];
    $picture        = $_POST['picture'];
    $firstName 	    = $_POST['firstName'];
    $lastName 		= $_POST['lastName'];
    $email 		    = $_POST['email'];
    $fcmToken 		= $_POST['fcmToken'];
    
    /*
    $provider       = 'google';
    $socialId       = '12345678987456321456987';
    $picture        = 'url';
    $firstName 	    = 'Rohit';
    $lastName 		= 'Yadav';
    $email 		    = 'iamrohityadav24@gamil.com';
    $fcmToken 		= 'APA91bEpokAREg7e1R5koiTpjV6PumIM1WSFMhatRRepadEy9pAz9XlkhNL';
    */
    
    $users = new Users();
    $users->insertSocialSignIn($provider, $socialId, $picture, $firstName, $lastName, $email, $fcmToken);
}
?>