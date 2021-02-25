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
    $provider       = 'app';
    $email		    = $_POST['email'];
    
    /*
    $provider       = 'app';
    $email 		    = 'iamrohityadav24@gmail.com';
    */
   
   $users = new Users();
   $users->sendOtpOnMail($provider, $email);
}
?>