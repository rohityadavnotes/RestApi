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
   $apiKey 		    = $_POST['apiKey'];
   $pageNumber 		= $_POST['pageNumber'];
   
   /*
   $apiKey 		    = 'key';
   $pageNumber 		= '1';
   */
   
   $users = new Users();
   $users->getUsers($apiKey, $pageNumber);
}
?>