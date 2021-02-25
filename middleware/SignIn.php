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
   $provider        = 'app';
   $email 		    = $_POST['email'];
   $password 		= $_POST['password'];
   $fcmToken 		= $_POST['fcmToken'];
   
   /*
   $provider        = 'app';
   $email 		    = 'iamrohityadav24@gmail.com';
   $password 		= 'password';
   $fcmToken 		= 'APA91bEpokAREg7e1R5koiTpjV6PumIM1WSFMhatRRepadEy9pAz9XlkhNL';
   */
   
   $users = new Users();
   //$users->appSignInFirst($provider, $email, $password, $fcmToken);
   $users->appSignInSecond($provider, $email, $password, $fcmToken);
}
?>