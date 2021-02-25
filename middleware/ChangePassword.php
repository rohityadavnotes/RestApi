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
    $oldPassword	= $_POST['oldPassword'];
    $newPassword	= $_POST['newPassword'];
    
    /*
    $provider       = 'app';
    $email 		    = 'iamrohityadav24@gmail.com';
    $oldPassword 	= 'oldpassword';
    $newPassword 	= 'newpasssword';
    */
    
    $users = new Users();
    $users->changePasswordUsingMail($provider, $email, $oldPassword, $newPassword);
}
?>