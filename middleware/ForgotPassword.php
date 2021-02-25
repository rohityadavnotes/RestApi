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
    $token		    = $_POST['token'];
    $email		    = $_POST['email'];
    $newPassword	= $_POST['newPassword'];
    
    /*
    $provider       = 'app';
    $token 		    = '2543eb2a3c1b08c5b2cf9d8705317907';
    $email 		    = 'iamrohityadav24@gmail.com';
    $newPassword 	= 'newpasssword';
    */
    
    $users = new Users();
    $users->forgotPasswordUsingMail($provider, $token, $email, $newPassword);
}
?>