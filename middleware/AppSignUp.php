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
    $picture        = $_FILES["profilePic"];
    $firstName 	    = $_POST['firstName'];
    $lastName 		= $_POST['lastName'];
    $gender         = $_POST['gender'];
    $countryCode 	= $_POST['countryCode'];
    $phoneNumber 	= $_POST['phoneNumber'];
    $email 		    = $_POST['email'];
    $password 		= $_POST['password'];
    $fcmToken 		= $_POST['fcmToken'];
    
    /*
    $provider       = 'app';
    $picture        = 'multipartbody';
    $firstName 	    = 'Rohit';
    $lastName 		= 'Yadav';
    $gender         = 'MALE';
    $phoneNumber 	= '7898680304';
    $email 		    = 'iamrohityadav24@gamil.com';
    $password 		= 'password';
    $fcmToken 		= 'APA91bEpokAREg7e1R5koiTpjV6PumIM1WSFMhatRRepadEy9pAz9XlkhNL';
    */
    
    $users = new Users();
    $users->appSignUp($provider, $picture, $firstName, $lastName, $gender, $countryCode, $phoneNumber, $email, $password, $fcmToken);
}
?>