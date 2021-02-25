<?php
/* Including the DatabaseConnection.php file */
require_once('../config/DatabaseConnection.php');

class Users /* Create a class called Users */                 
{
	/* Create connection variable to check database connection */
	private $databaseConnection;
	private $dbUsersTable 	= 'users';
	private $dbOtpTable 	= 'password_reset';

	/* Class constructor */
	function __construct()
	{
		/* Create DatabaseConnection class object */
		$this->databaseConnection = new DatabaseConnection();

		/* Connecting to database */
		$this->databaseConnection->connect();
	}
	
	/**
     * Convert array to json
	 * 
     * @param AssociativeArray $response
     */
	public function jsonEncode($response) 
	{
		$jsonResponse = json_encode($response);
		header('Content-type: application/json');
		return $jsonResponse;
	}
	
	/**
     * Get random string function
	 * 
     * @return String
     */
	public function generateRandomString($length = 20) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++)
	    {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return md5($randomString);
	}

	/* Generate random otp */
	public function generateOTP()
	{
		$number = rand(100000, 999999);
		return $number;
	}

	/**
     * Get time difference, between otpCreateTime and currentTime
	 * 
     * @param String $otpCreateTime
     */
	function getTimeDifferenceInMinutes($otpCreateTime)
    {
        $timeOne    = $otpCreateTime;
        date_default_timezone_set('Asia/Kolkata');
        $timeTwo    = date('h:i:s');
        
        $firstTime      = strtotime($timeOne);
        $secondTime     = strtotime($timeTwo);
        $diff           = $firstTime - $secondTime;
        $timeInSeconds  = abs($diff);
        $timeInminutes  = $timeInSeconds/60;
        return $timeInminutes;
    }
	
	/**
     * Check email exist
	 * 
     * @param String $email
     */
	public function isEmailExist($email, $provider) 
	{
		if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$isExistQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
			$isExistResult 	= $this->databaseConnection->getConnection()->query($isExistQuery);
			$num_of_rows 	= $isExistResult->num_rows;
			
			if($num_of_rows > 0)
			{
				return true;
			}
			else
			{
				return false;  
			}
		}
	}

	/**
     * Check provider and socialId is exist or not
	 * 
     * @param String $provider
	 * @param String $socialId
     */	  
	public function isProviderAndSocialIdExist($provider, $socialId) 
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($socialId) === false || trim($socialId) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (socialId), social id missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$isExistQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE provider = '$provider' AND socialId = '$socialId'";
			$isExistResult 	= $this->databaseConnection->getConnection()->query($isExistQuery);
			$num_of_rows 	= $isExistResult->num_rows;
			
			if($num_of_rows > 0)
			{
				return true;
			}
			else
			{
				return false;  
			}
		}
	}

	/**
     * Creating new account
	 * @param String $provider User app provider
	 * @param String $picture User photo
     * @param String $firstName User first name
     * @param String $lastName User last name
	 * @param String $gender User gender
	 * @param String $countryCode User countryCode
     * @param String $phoneNumber User phone number
	 * @param String $email User email
     * @param String $password User password
     * @param String $fcmToken User fcm token
     */
	public function appSignUp($provider, $picture, $firstName, $lastName, $gender, $countryCode, $phoneNumber, $email, $password, $fcmToken)
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($picture) === false) 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (picture), picture missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($firstName) === false || trim($firstName) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (firstName), first name missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($lastName) === false || trim($lastName) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (lastName), last name missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($gender) === false || trim($gender) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (gender), gender missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($countryCode) === false || trim($countryCode) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (countryCode), country code missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($phoneNumber) === false || trim($phoneNumber) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (phoneNumber), phone number missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($password) === false || trim($password) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (password), password missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($fcmToken) === false || trim($fcmToken) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (fcmToken), FCM token missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			if($this->isEmailExist($email, $provider))
			{
				$response["status"]	= false;
				$response["code"]	= USER_ALREADY_EXIST;
				$response["message"]= "User already exist with this email : $email";
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
			else
			{
				$fileName           = $_FILES['profilePic']['name'];
				$fileContentType    = $_FILES['profilePic']['type'];
				$fileTempName       = $_FILES['profilePic']['tmp_name'];
				$fileError          = $_FILES['profilePic']['error'];
				$fileSize           = $_FILES['profilePic']['size'];
				
				/* Allow extensions */
				$fileExtensions = ['jpeg','jpg','png'];
				
				$value = explode('.', $fileName);
				$fileExtension = strtolower(end($value));
				
				/* Base url where uploaded folder created */
				$baseUrl    = 'https://backend24.000webhostapp.com/RestApi/uploaded/';
				
				/* Generate random file name and add extension */
				$fileRandomName             = hash('sha1', basename($fileName).'-'.bin2hex(openssl_random_pseudo_bytes(32))).'.'.$fileExtension;
				
				/* Full store file path, which is store in database */
				$completeUploadFilePathWithRandomName     = $baseUrl.$fileRandomName;
				
				/* Folder name where file store, in my case folder name is uploaded */
				$folderName = '../uploaded/';
				
				/* Target directory where move_uploaded_file function call */
				$targetDirectory     = dirname(__FILE__).'/'.$folderName.$fileRandomName;
				
				/* Upload file max size on 10MB */
				$fileMaxSize = 10 * 1024 * 1024;
				
				/* Check extension is exit in $fileExtensions array */
				if (in_array($fileExtension,$fileExtensions)) 
				{
					if ($fileSize > $fileMaxSize) 
					{
						$response["status"]	= false;
						$response["code"]	= PARAMETER_REQUIRED;
						$response["message"]= 'Allow File Size 5 MB Only';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
					else if (file_exists($targetDirectory)) 
					{
						$response["status"]	= false;
						$response["code"]	= PARAMETER_REQUIRED;
						$response["message"]= 'Sorry, File Name Already Exists';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
					else
					{
						try 
						{
							if (!move_uploaded_file($fileTempName,$targetDirectory)) 
							{
								$response["status"]	= false;
								$response["code"]	= INTERNAL_SERVER_ERROR;
								$response["message"]= 'File Uploaded Failed';
								$response["data"]	= null;
								echo $this->jsonEncode($response);
							}
							else
							{
								date_default_timezone_set('Asia/Kolkata'); 
								
								$phoneNumberVerified 	= 1;
								$emailVerified 			= 1;
								$lastLogIn 				= date('Y-m-d H:i:s');
								$createdAt 				= date('Y-m-d H:i:s');
								$updatedAt 				= date('Y-m-d H:i:s');
								$expiredAt 				= date('Y-m-d H:i:s');
								$accountVerifiedByAdmin = 1;
								
								$signUpQuery 	= "INSERT INTO ".$this->dbUsersTable." (provider, picture, firstName, lastName, gender, countryCode, phoneNumber, phoneNumberVerified, email, emailVerified, password, fcmToken, lastLogIn, createdAt, updatedAt, expiredAt, accountVerifiedByAdmin) VALUES('$provider', '$completeUploadFilePathWithRandomName', '$firstName', '$lastName', '$gender', '$countryCode', '$phoneNumber', '$phoneNumberVerified', '$email', '$emailVerified', '$password', '$fcmToken', '$lastLogIn', '$createdAt', '$updatedAt', '$expiredAt', '$accountVerifiedByAdmin')";
								$signUpResult 	= $this->databaseConnection->getConnection()->query($signUpQuery);
								
								if(!$signUpResult)
								{
									$response["status"]	= false;
									$response["code"]	= INTERNAL_SERVER_ERROR;
									$response["message"]= 'Unknown error occurred when sign up';
									$response["data"]	= null;
									echo $this->jsonEncode($response);
								}
								else
								{
									$getQuery 		= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
									$getResult 		= $this->databaseConnection->getConnection()->query($getQuery);
									$num_of_rows 	= $getResult->num_rows;
									
									if($num_of_rows > 0)
									{
										$row = mysqli_fetch_assoc($getResult);
										
										$array = array();
										
										$array["id"]     		 			= $row["id"];
										$array["provider"]     				= $row["provider"];
										$array["social_id"]      			= $row["socialId"];
										$array["picture"]     		 		= $row["picture"];
										$array["first_name"]     			= $row["firstName"];
										$array["last_name"]      			= $row["lastName"];
										$array["gender"]      	 			= $row["gender"];
										$array["country_code"]   			= $row["countryCode"];
										$array["phone_number"]   			= $row["phoneNumber"];
										$array["phone_number_verified"] 	= $row["phoneNumberVerified"];
										$array["email"]          			= $row["email"];
										$array["email_verified"] 			= $row["emailVerified"];
										$array["password"]       			= $row["password"];
										$array["fcm_token"]      			= $row["fcmToken"];
										$array["last_login"]     			= $row["lastLogIn"];
										$array["created_at"]     			= $row["createdAt"];
										$array["updated_at"]    	 		= $row["updatedAt"];
										$array["expired_at"]     			= $row["expiredAt"];
										$array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];
										
										$response["status"]	= true;
										$response["code"]	= OK;
										$response["message"]= 'Sign up successfully';
										$response["data"]	= $array;
										echo $this->jsonEncode($response);	
									}
								}
							}
						}
						catch (Exception $exception)
						{
							$response["status"]	= false;
							$response["code"]	= INTERNAL_SERVER_ERROR;
							$response["message"]= $exception->getMessage();
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
					}
				}
				else
				{
					$response["status"]	= false;
					$response["code"]	= PARAMETER_REQUIRED;
					$response["message"]= 'Invalid file extension';
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
			}
		}
	}

	/**
     * Access user account
	 * 
	 * @param String $provider User app provider
	 * @param String $email User email
     * @param String $password User password
     * @param String $fcmToken User fcm token
     */
	public function appSignInFirst($provider, $email, $password, $fcmToken)
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($password) === false || trim($password) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (password), password missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($fcmToken) === false || trim($fcmToken) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (fcmToken), FCM token missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$signInQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider' AND password = '$password'";
			$signInResult 	= $this->databaseConnection->getConnection()->query($signInQuery);
			$num_rows 		= $signInResult->num_rows;
			
			if($num_rows > 0)
			{
				date_default_timezone_set('Asia/Kolkata'); 

				$lastLogIn = date('Y-m-d H:i:s');
				$updatedAt = date('Y-m-d H:i:s');
					
				$updateQuery 	= "UPDATE ".$this->dbUsersTable." SET fcmToken = '$fcmToken', lastLogIn = '$lastLogIn', updatedAt = '$updatedAt' WHERE email = '$email' AND provider = '$provider'";
				$updateResult 	= $this->databaseConnection->getConnection()->query($updateQuery);
					
				if(!$updateResult)
				{
					$response["status"]	= false;
					$response["code"]	= INTERNAL_SERVER_ERROR;
					$response["message"]= 'Unknown error occurred when update token';
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
				else
				{
					$getQuery 		= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
					$getResult 		= $this->databaseConnection->getConnection()->query($getQuery);
					$num_of_rows 	= $getResult->num_rows;
						
					if($num_of_rows > 0)
					{
						$row = mysqli_fetch_assoc($getResult);
							
						$array = array();

						$array["id"]     		 			= $row["id"];
						$array["provider"]     				= $row["provider"];
						$array["social_id"]      			= $row["socialId"];
						$array["picture"]     		 		= $row["picture"];
						$array["first_name"]     			= $row["firstName"];
						$array["last_name"]      			= $row["lastName"];
						$array["gender"]      	 			= $row["gender"];
						$array["country_code"]   			= $row["countryCode"];
						$array["phone_number"]   			= $row["phoneNumber"];
						$array["phone_number_verified"] 	= $row["phoneNumberVerified"];
						$array["email"]          			= $row["email"];
						$array["email_verified"] 			= $row["emailVerified"];
						$array["password"]       			= $row["password"];
						$array["fcm_token"]      			= $row["fcmToken"];
						$array["last_login"]     			= $row["lastLogIn"];
						$array["created_at"]     			= $row["createdAt"];
						$array["updated_at"]    	 		= $row["updatedAt"];
						$array["expired_at"]     			= $row["expiredAt"];
						$array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];

						$response["status"]	= true;
						$response["code"]	= OK;
						$response["message"]= 'Sign in successfully';
						$response["data"]	= $array;
						echo $this->jsonEncode($response);	
					}
				}
			}
			else
			{
				$response["status"]	= false;
				$response["code"]	= NOT_FOUND;
				$response["message"]= 'Email or Password is incorrect. Please try again';
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
	}

	/**
     * Access user account here we if email is exist then check password
	 * 
	 * @param String $provider User app provider
	 * @param String $email User email
     * @param String $password User password
     * @param String $fcmToken User fcm token
     */
	public function appSignInSecond($provider, $email, $password, $fcmToken)
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($password) === false || trim($password) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (password), password missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($fcmToken) === false || trim($fcmToken) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (fcmToken), FCM token missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$signInQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
			$signInResult 	= $this->databaseConnection->getConnection()->query($signInQuery);
			$num_of_rows 	= $signInResult->num_rows;

			if($num_of_rows > 0)
			{
				$row = mysqli_fetch_assoc($signInResult);

				$dbEmail          = $row["email"];
				$dbPassword       = $row["password"];

				if($dbEmail === $email && $dbPassword === $password)
				{
					date_default_timezone_set('Asia/Kolkata'); 
					
					$lastLogIn = date('Y-m-d H:i:s');
					$updatedAt = date('Y-m-d H:i:s');
					
					$updateQuery 	= "UPDATE ".$this->dbUsersTable." SET fcmToken = '$fcmToken', lastLogIn = '$lastLogIn', updatedAt = '$updatedAt' WHERE email = '$email' AND provider = '$provider'";
					$updateResult 	= $this->databaseConnection->getConnection()->query($updateQuery);
					
					if(!$updateResult)
					{
						$response["status"]	= false;
						$response["code"]	= INTERNAL_SERVER_ERROR;
						$response["message"]= 'Unknown error occurred when update token';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
					else
					{
						$getQuery 		= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
						$getResult 		= $this->databaseConnection->getConnection()->query($getQuery);
						$num_of_rows 	= $getResult->num_rows;
						
						if($num_of_rows > 0)
						{
							$row = mysqli_fetch_assoc($getResult);
							
							$array = array();
							
							$array["id"]     		 			= $row["id"];
							$array["provider"]     				= $row["provider"];
							$array["social_id"]      			= $row["socialId"];
							$array["picture"]     		 		= $row["picture"];
							$array["first_name"]     			= $row["firstName"];
							$array["last_name"]      			= $row["lastName"];
							$array["gender"]      	 			= $row["gender"];
							$array["country_code"]   			= $row["countryCode"];
							$array["phone_number"]   			= $row["phoneNumber"];
							$array["phone_number_verified"] 	= $row["phoneNumberVerified"];
							$array["email"]          			= $row["email"];
							$array["email_verified"] 			= $row["emailVerified"];
							$array["password"]       			= $row["password"];
							$array["fcm_token"]      			= $row["fcmToken"];
							$array["last_login"]     			= $row["lastLogIn"];
							$array["created_at"]     			= $row["createdAt"];
							$array["updated_at"]    	 		= $row["updatedAt"];
							$array["expired_at"]     			= $row["expiredAt"];
							$array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];

							$response["status"]	= true;
							$response["code"]	= OK;
							$response["message"]= 'Sign in successfully';
							$response["data"]	= $array;
							echo $this->jsonEncode($response);	
						}
						else
						{
							$response["status"]	= false;
							$response["code"]	= NOT_FOUND;
							$response["message"]= "User doesn't exist with this email : $email";
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
					}
				}
				else
				{
					$response["status"]	= false;
					$response["code"]	= INVALID_PASSWORD;
					$response["message"]= 'Invalid password';
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
			}	
			else
			{
				$response["status"]	= false;
				$response["code"]	= NOT_FOUND;
				$response["message"]= "User doesn't exist with this email : $email";
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
	}
	
	/**
     * Sign In using social network like Google, Facebook, LinkedIn , Twitter etc.,
	 * 
	 * @param String $provider User sign in with social network
     * @param String $socialId User social network id
	 * @param String $picture User social network picture
     * @param String $firstName User first name
     * @param String $lastName User last name
	 * @param String $email User email
     * @param String $fcmToken User fcm token
     */
	public function insertSocialSignIn($provider, $socialId, $picture, $firstName, $lastName, $email, $fcmToken)
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($socialId) === false || trim($socialId) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (socialId), social id missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($picture) === false || trim($picture) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (picture), picture missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($firstName) === false || trim($firstName) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (firstName), first name missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($lastName) === false || trim($lastName) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (lastName), last name missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($fcmToken) === false || trim($fcmToken) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (fcmToken), FCM token missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if($this->isProviderAndSocialIdExist($provider, $socialId))
		{
			$this->updateSocialSignIn($provider, $socialId, $picture, $firstName, $lastName, $email, $fcmToken);
		}
		else
		{
			date_default_timezone_set('Asia/Kolkata'); 

			$emailVerified 			= 1;
			$lastLogIn 				= date('Y-m-d H:i:s');
			$createdAt 				= date('Y-m-d H:i:s');
			$updatedAt 				= date('Y-m-d H:i:s');
			$expiredAt 				= date('Y-m-d H:i:s');

			$signInQuery 	= "INSERT INTO ".$this->dbUsersTable." (provider, socialId, picture, firstName, lastName, email, emailVerified, fcmToken, lastLogIn, createdAt, updatedAt, expiredAt) VALUES('$provider', '$socialId', '$picture', '$firstName', '$lastName', '$email', '$emailVerified', '$fcmToken', '$lastLogIn', '$createdAt', '$updatedAt', '$expiredAt')";
			$signInResult 	= $this->databaseConnection->getConnection()->query($signInQuery);
				
			if(!$signInResult)
			{
				$response["status"]	= false;
				$response["code"]	= INTERNAL_SERVER_ERROR;
				$response["message"]= 'Unknown error occurred when social sign in';
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
			else
			{
			     $getQuery 		= "SELECT * FROM ".$this->dbUsersTable." WHERE provider = '$provider' AND socialId = '$socialId'";
			     $getResult 	= $this->databaseConnection->getConnection()->query($getQuery);
			     $num_of_rows 	= $getResult->num_rows;
			     
			     if($num_of_rows > 0)
			     {
			         $row = mysqli_fetch_assoc($getResult);
			         
			         $array = array();
			         
			         $array["id"]     		 			= $row["id"];
			         $array["provider"]     			= $row["provider"];
			         $array["social_id"]      			= $row["socialId"];
			         $array["picture"]     		 		= $row["picture"];
			         $array["first_name"]     			= $row["firstName"];
			         $array["last_name"]      			= $row["lastName"];
			         $array["gender"]      	 			= $row["gender"];
					 $array["country_code"]   			= $row["countryCode"];
			         $array["phone_number"]   			= $row["phoneNumber"];
			         $array["phone_number_verified"] 	= $row["phoneNumberVerified"];
			         $array["email"]          			= $row["email"];
			         $array["email_verified"] 			= $row["emailVerified"];
			         $array["password"]       			= $row["password"];
			         $array["fcm_token"]      			= $row["fcmToken"];
			         $array["last_login"]     			= $row["lastLogIn"];
			         $array["created_at"]     			= $row["createdAt"];
			         $array["updated_at"]    	 		= $row["updatedAt"];
			         $array["expired_at"]     			= $row["expiredAt"];
			         $array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];
			         
			         $response["status"]	= true;
			         $response["code"]	= OK;
			         $response["message"]= 'User social sign in successfully';
			         $response["data"]	= $array;
			         echo $this->jsonEncode($response);	
			     }
			}
		}
	}

	/**
     * Update
	 * 
	 * @param String $provider User sign in with social network
     * @param String $socialId User social network id
	 * @param String $picture User social network picture
     * @param String $firstName User first name
     * @param String $lastName User last name
	 * @param String $email User email
     * @param String $fcmToken User fcm token
     */
	public function updateSocialSignIn($provider, $socialId, $picture, $firstName, $lastName, $email, $fcmToken)
	{
		date_default_timezone_set('Asia/Kolkata'); 

		$lastLogIn 				= date('Y-m-d H:i:s');
		$updatedAt 				= date('Y-m-d H:i:s');
		
		$updateQuery 	= "UPDATE ".$this->dbUsersTable." SET picture = '$picture', firstName = '$firstName', lastName = '$lastName', email = '$email', fcmToken = '$fcmToken', lastLogIn = '$lastLogIn', updatedAt = '$updatedAt' WHERE provider = '$provider' AND socialId = '$socialId'";
		$updateResult 	= $this->databaseConnection->getConnection()->query($updateQuery);

		if(!$updateResult)
		{
			$response["status"]	= false;
			$response["code"]	= INTERNAL_SERVER_ERROR;
			$response["message"]= 'Unknown error occurred when update token';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
		    $getQuery 		= "SELECT * FROM ".$this->dbUsersTable." WHERE provider = '$provider' AND socialId = '$socialId'";
		    $getResult 		= $this->databaseConnection->getConnection()->query($getQuery);
		    $num_of_rows 	= $getResult->num_rows;
		    
		    if($num_of_rows > 0)
			{
			    $row = mysqli_fetch_assoc($getResult);
			    
			    $array = array();
			    
			    $array["id"]     		 			= $row["id"];
			    $array["provider"]     				= $row["provider"];
			    $array["social_id"]      			= $row["socialId"];
			    $array["picture"]     		 		= $row["picture"];
			    $array["first_name"]     			= $row["firstName"];
			    $array["last_name"]      			= $row["lastName"];
			    $array["gender"]      	 			= $row["gender"];
				$array["country_code"]   			= $row["countryCode"];
				$array["phone_number"]   			= $row["phoneNumber"];
				$array["phone_number_verified"] 	= $row["phoneNumberVerified"];
				$array["email"]          			= $row["email"];
				$array["email_verified"] 			= $row["emailVerified"];
				$array["password"]       			= $row["password"];
				$array["fcm_token"]      			= $row["fcmToken"];
				$array["last_login"]     			= $row["lastLogIn"];
				$array["created_at"]     			= $row["createdAt"];
				$array["updated_at"]    	 		= $row["updatedAt"];
				$array["expired_at"]     			= $row["expiredAt"];
				$array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];

				$response["status"]	= true;
				$response["code"]	= OK;
				$response["message"]= 'User social sign in successfully';
				$response["data"]	= $array;
				echo $this->jsonEncode($response);	
			}
		}
	}

	/**
     * Get users
	 * 
	 * @param String $apiKey
     * @param String $pageNumber
     */
	public function getUsers($apiKey, $pageNumber)
    {
		if(isset($apiKey) === false || trim($apiKey) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (apiKey), api key missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if($apiKey != API_KEY)
		{
			$response["status"]	= false;
			$response["code"]	= INVALID_API_KEY;
			$response["message"]= 'Invalid api key';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			/* page number you want */
			if(isset($pageNumber) === false || trim($pageNumber) === '') 
			{
				$pageNumber = 1;
			}
			else
			{
				/* convert the page number to an integer */
				$pageNumber = (int)$pageNumber;
			}
			
			/* number of items fetch in one page */
			$limit = 5;
			
			/**
			 * $start It is a number where to start fetch data from table,
			 * EXAMPLE : if start number is 5 then row fetch start from 6 number row
			 */
			if($pageNumber)
			{
				$start = ($pageNumber - 1) * $limit; 
			}
			else
			{
				$start = 0;
			}

			$getUsersTableQuery = "SELECT * FROM ".$this->dbUsersTable."";
			$getUsersTableResult= mysqli_query($this->databaseConnection->getConnection(), $getUsersTableQuery);
			$numberOfRows 		= mysqli_num_rows($getUsersTableResult);
			
			if($numberOfRows > 0)
			{
				$pageData = array();
				$pageData["current_page_number"]    = $pageNumber;
				$pageData["total_number_of_items"]  = $numberOfRows;
				$pageData["item_in_one_page"]    	= $limit;
				$pageData["total_number_of_pages"]  = ceil($numberOfRows/$limit);
				
				/**
				 * LIMIT : MySQL provides a LIMIT clause that is used to specify the number of records to return.
				 * The LIMIT clause makes it easy to code multi page results or pagination with SQL, and is very 
				 * useful on large tables. Returning a large number of records can impact on performance.
				 * 
				 * EXAMPLE : Assume we wish to select all records from 1 - 30 (inclusive) from a table called "Orders".
				 * The SQL query would then look like this :
				 * 											$query = "SELECT * FROM Orders LIMIT 30";
				 * 
				 * When the SQL query above is run, it will return the first 30 records. What if we want to select records 16 - 25 (inclusive)?
				 * Mysql also provides a way to handle this : 
				 * 
				 * by using OFFSET : offset is any number starting from 0, putting 0 as the offset does not return any records in the query.
				 * 
				 * EXAMPLE : The SQL query below says "return only 10 records, start on record 16 (OFFSET 15)" :
				 * $query = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
				 * 
				 * SOME QUERY :
				 * $query = "SELECT * FROM register_user ORDER BY id DESC LIMIT 4 OFFSET 7";  
				 */

				$getPageQuery 	= "SELECT * FROM ".$this->dbUsersTable." ORDER BY id ASC LIMIT ".$limit." OFFSET ".$start."";
				$getPageResult 	= mysqli_query($this->databaseConnection->getConnection(), $getPageQuery);
				$num_of_rows 	= mysqli_num_rows($getPageResult);
				
				if($num_of_rows > 0)
				{
				    if($num_of_rows > $limit)
				    {
				        $count = $limit;
				    }
				    else
				    {
				        $count = $num_of_rows;
				    }
				    
					for($sloop = 0; $sloop < $count; $sloop++)
					{
						$row = mysqli_fetch_assoc($getPageResult);
						
						$array = array();

						$array["id"]     		 			= $row["id"];
						$array["provider"]     				= $row["provider"];
						$array["social_id"]      			= $row["socialId"];
						$array["picture"]     		 		= $row["picture"];
						$array["first_name"]     			= $row["firstName"];
						$array["last_name"]      			= $row["lastName"];
						$array["gender"]      	 			= $row["gender"];
						$array["country_code"]   			= $row["countryCode"];
						$array["phone_number"]   			= $row["phoneNumber"];
						$array["phone_number_verified"] 	= $row["phoneNumberVerified"];
						$array["email"]          			= $row["email"];
						$array["email_verified"] 			= $row["emailVerified"];
						$array["password"]       			= $row["password"];
						$array["fcm_token"]      			= $row["fcmToken"];
						$array["last_login"]     			= $row["lastLogIn"];
						$array["created_at"]     			= $row["createdAt"];
						$array["updated_at"]    	 		= $row["updatedAt"];
						$array["expired_at"]     			= $row["expiredAt"];
						$array["account_verified_by_admin"] = $row["accountVerifiedByAdmin"];

						$rowArray[]           = $array;
						$pageData["users"]    = $rowArray;
					}
					
					$response["status"]	= true;
					$response["code"]	= OK;
					$response["message"]= 'Get page successfully';
					$response["data"]	= $pageData;
					echo $this->jsonEncode($response);
				}
				else
				{
					$response["status"]	= false;
					$response["code"]	= NO_CONTENT;
					$response["message"]= 'No page';
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
			}
			else
			{
				$response["status"]	= false;
				$response["code"]	= NO_CONTENT;
				$response["message"]= 'Table is empty';
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
    }

	/**
     * Send sms
	 * 
	 * @param String $countryCode
     * @param String $phoneNumber
	 * @param String $otp
     */
	public function sendSMS($countryCode, $phoneNumber, $otp)
	{
		/* Write code here for send OTP on Phone Number*/ 
		return true;
	}
	
	/**
     * Send mail
	 * 
     * @param String $email
	 * @param String $otp
     */
	public function sendMail($firstName, $lastName, $sendTo, $otp)
	{
		/* recipient */
		$to = $sendTo;

		/* sender */
		$from = 'noreply@badasoftware.com';
		$fromName = 'Bada Software';

		/* email subject */
		$subject = "Forgot Password mail for ".$sendTo."";

		/* mail body */
		$message = '<html>
		<head>
		</head>
		<body>
			<center><h1><b>Forgot Password Mail</b></h1></center><br>
			<p>Dear '.$firstName.' '.$lastName.', <br>
			You have received this mail because, we recieved a password reset request. If you did not make this request, you can ignore this mail.<br>
			OTP Code :-  <b>'.$otp.'</b><br>
			This code expires after 10 minutes. Use this code within 10 minutes to reset your password.<br><br>
			Thanks!
			
			<a href="http://www.badasoftware.com/">Visit our website</a>
		</body>
		</html>
		';

		/* To send HTML mail, the Content-type header must be set */
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		/* Additional headers */
		$headers[] = 'To: '.$firstName.' '.$lastName.' <'.$to.'>';
		$headers[] = 'From: '.$fromName.' <'.$from.'>';
		$headers[] = 'Reply-To: '.$from.'';
		$headers[] = 'Cc: '.$from.'';
		$headers[] = 'Bcc: '.$from.'';

		$sent = mail($to, $subject, $message, implode("\r\n", $headers));

		return $sent;
	}

	/**
     * Send otp on mail
	 * 
	 * @param String $provider
	 * @param String $email
     */
	public function sendOtpOnMail($provider, $email) 
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$isEmailExistInUserTableQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
			$isEmailExistInUserTableResult 	= $this->databaseConnection->getConnection()->query($isEmailExistInUserTableQuery);
			$num_of_rows 					= $isEmailExistInUserTableResult->num_rows;

			if($num_of_rows > 0)
			{
				$row = mysqli_fetch_assoc($isEmailExistInUserTableResult);

				$dbFirstName      = $row["firstName"];
				$dbLastName       = $row["lastName"];

				$isEmailExistInOtpTableQuery 	= "SELECT * FROM ".$this->dbOtpTable." WHERE email = '$email'";
				$isEmailExistInOtpTableResult 	= $this->databaseConnection->getConnection()->query($isEmailExistInOtpTableQuery);
				$num_of_rows 					= $isEmailExistInOtpTableResult->num_rows;
				
				if($num_of_rows > 0)
				{
					$deleteQuery 	= "DELETE FROM ".$this->dbOtpTable." WHERE email = '$email'";
					$deleteResult 	= $this->databaseConnection->getConnection()->query($deleteQuery);

					if(!$deleteResult)
					{
						$response["status"]	= false;
						$response["code"]	= INTERNAL_SERVER_ERROR;
						$response["message"]= 'Unknown error occurred when store OTP';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
					else
					{
					    date_default_timezone_set('Asia/Kolkata'); 
					    
						$otp 			= $this->generateOTP();
						$otpCreateTime 	= date('h:i:s');
						$token 			= $this->generateRandomString();
						
						$insertQuery = "INSERT INTO ".$this->dbOtpTable." (email, otp, otpCreateTime, token) VALUES('$email', '$otp', '$otpCreateTime', '$token')";
						$insertResult = $this->databaseConnection->getConnection()->query($insertQuery);
						
						if(!$insertResult)
						{
							$response["status"]	= false;
							$response["code"]	= INTERNAL_SERVER_ERROR;
							$response["message"]= 'Unknown error occurred when store OTP';
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
						else
						{	    
							if($this->sendMail($dbFirstName, $dbLastName, $email, $otp))
							{
								$otpData = array();
								$otpData["otp_for"]= $email;
								$otpData["otp"]    = $otp;
								
								$response["status"]	= true;
								$response["code"]	= OK;
								$response["message"]= 'OTP send successfully';
								$response["data"]	= $otpData;
								echo $this->jsonEncode($response);
							}
							else
							{
								$response["status"]	= false;
								$response["code"]	= CREATED;
								$response["message"]= 'OTP create successfully, but not send';
								$response["data"]	= null;
								echo $this->jsonEncode($response);
							}
						}
					}
				}
				else
				{
				    date_default_timezone_set('Asia/Kolkata'); 
				    
					$otp 			= $this->generateOTP();
					$otpCreateTime 	= date('h:i:s');
					$token 			= $this->generateRandomString();
						
					$insertQuery 	= "INSERT INTO ".$this->dbOtpTable." (email, otp, otpCreateTime, token) VALUES('$email', '$otp', '$otpCreateTime', '$token')";
					$insertResult = $this->databaseConnection->getConnection()->query($insertQuery);
						
					if(!$insertResult)
					{
						$response["status"]	= false;
						$response["code"]	= INTERNAL_SERVER_ERROR;
						$response["message"]= 'Unknown error occurred when store OTP';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
					else
					{
						if($this->sendMail($dbFirstName, $dbLastName, $email, $otp))
						{
							$otpData = array();
							$otpData["otp_for"]= $email;
							$otpData["otp"]    = $otp;
								
							$response["status"]	= true;
							$response["code"]	= OK;
							$response["message"]= 'OTP send successfully';
							$response["data"]	= $otpData;
							echo $this->jsonEncode($response);
						}
						else
						{
							$response["status"]	= true;
							$response["code"]	= CREATED;
							$response["message"]= 'OTP create successfully, but not send';
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
					}
				}
			}
			else
			{
				$response["status"]	= false;
				$response["code"]	= NOT_FOUND;
				$response["message"]= "User doesn't exist with this email : $email";
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
	}

	/**
     * Send otp on phone number
	 * 
	 * @param String $provider
	 * @param String $countryCode 
	 * @param String $phoneNumber
     */
	public function sendOtpOnPhoneNumber($provider, $countryCode, $phoneNumber) 
	{

	}

	/**
     * Verify otp when send on mail
	 * 
	 * @param String $provider 
	 * @param String $email
	 * @param String $otp
     */
	public function verifyOtpWhenSendOnMail($provider, $email, $otp) 
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($otp) === false || trim($otp) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (otp), otp missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$isEmailExistInUserTableQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
			$isEmailExistInUserTableResult 	= $this->databaseConnection->getConnection()->query($isEmailExistInUserTableQuery);
			$num_of_rows 					= $isEmailExistInUserTableResult->num_rows;

			if($num_of_rows > 0)
			{
				$getOtpQuery 	= "SELECT * FROM ".$this->dbOtpTable." WHERE email = '$email'";
				$getOtpResult 	= $this->databaseConnection->getConnection()->query($getOtpQuery);
				$num_of_rows 	= $getOtpResult->num_rows;
	
				if($num_of_rows > 0)
				{
					$row = mysqli_fetch_assoc($getOtpResult);
	
					$dbOtp  		  = $row["otp"];
					$dbOtpCreateTime  = $row["otpCreateTime"];
					$dbToken  		  = $row["token"];
					
					/* After 10 minutes token expired */
					if($this->getTimeDifferenceInMinutes($dbOtpCreateTime) <= 10.0)
					{
						if ($dbOtp != $otp)
						{
							$response["status"]	= false;
							$response["code"]	= NOT_ACCEPTABLE;
							$response["message"]= 'Invalid OTP';
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
						else
						{
							$tokenData = array();
							$tokenData["token"]  = $dbToken;
		
							$response["status"]	= true;
							$response["code"]	= OK;
							$response["message"]= 'OTP verify successfully';
							$response["data"]	= $tokenData;
							echo $this->jsonEncode($response);
						}
					}
					else
					{
						$response["status"]	= false;
						$response["code"]	= NOT_ACCEPTABLE;
						$response["message"]= 'Your OTP has expired. please regenerate OTP';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
				}
				else
				{
					$response["status"]	= false;
					$response["code"]	= NOT_FOUND;
					$response["message"]= "User doesn't generate OTP";
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
			}
			else
			{
				$response["status"]	= false;
				$response["code"]	= NOT_FOUND;
				$response["message"]= "User doesn't exist with this email : $email";
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
	}

	/**
     * Verify otp when send on phone number
	 * 
	 * @param String $provider  
	 * @param String $countryCode
	 * @param String $phoneNumber
	 * @param String $otp
     */
	public function verifyOtpWhenSendOnPhoneNumber($provider, $countryCode, $phoneNumber, $otp) 
	{

	}

	/**
     * Change password, if you already signin in app
	 * 
	 * @param String $provider  
	 * @param String $email
	 * @param String $oldPassword
	 * @param String $newPassword
     */
	public function changePasswordUsingMail($provider, $email, $oldPassword, $newPassword) 
	{

	}

	/**
     * Forgot password, if you not signin in app
	 * 
	 * @param String $provider 
	 * @param String $token
	 * @param String $email
	 * @param String $newPassword
     */
	public function forgotPasswordUsingMail($provider, $token, $email, $newPassword) 
	{
		if(isset($provider) === false || trim($provider) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (provider), provider missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else if(isset($token) === false || trim($token) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (token), token missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		if(isset($email) === false || trim($email) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (email), email missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		if(isset($newPassword) === false || trim($newPassword) === '') 
		{
			$response["status"]	= false;
			$response["code"]	= PARAMETER_REQUIRED;
			$response["message"]= 'Required parameter (newPassword), new password missing';
			$response["data"]	= null;
			echo $this->jsonEncode($response);
		}
		else
		{
			$isEmailExistInUserTableQuery 	= "SELECT * FROM ".$this->dbUsersTable." WHERE email = '$email' AND provider = '$provider'";
			$isEmailExistInUserTableResult 	= $this->databaseConnection->getConnection()->query($isEmailExistInUserTableQuery);
			$num_of_rows 					= $isEmailExistInUserTableResult->num_rows;

			if($num_of_rows > 0)
			{
				$getTokenQuery 	= "SELECT * FROM ".$this->dbOtpTable." WHERE email = '$email'";
				$getTokenResult = $this->databaseConnection->getConnection()->query($getTokenQuery);
				$num_of_rows 	= $getTokenResult->num_rows;
				
				if($num_of_rows > 0)
				{
					$row = mysqli_fetch_assoc($getTokenResult);
					
					$dbTokenCreateTime  = $row["otpCreateTime"];
					$dbToken  		    = $row["token"];
					
					/* After 10 minutes token expired */
					if($this->getTimeDifferenceInMinutes($dbTokenCreateTime) <= 10.0)
					{
						if ($dbToken != $token)
						{
							$response["status"]	= false;
							$response["code"]	= NOT_ACCEPTABLE;
							$response["message"]= 'Invalid token';
							$response["data"]	= null;
							echo $this->jsonEncode($response);
						}
						else
						{
							date_default_timezone_set('Asia/Kolkata'); 
							
							$updatedAt = date('Y-m-d H:i:s');
							
							$updateQuery 	= "UPDATE ".$this->dbUsersTable." SET password = '$newPassword', updatedAt = '$updatedAt' WHERE email = '$email' AND provider = '$provider'";
							$updateResult 	= $this->databaseConnection->getConnection()->query($updateQuery);
							
							if(!$updateResult)
							{
								$response["status"]	= false;
								$response["code"]	= INTERNAL_SERVER_ERROR;
								$response["message"]= 'Unknown error occurred when update token';
								$response["data"]	= null;
								echo $this->jsonEncode($response);
							}
							else
							{
								$response["status"]	= true;
								$response["code"]	= OK;
								$response["message"]= 'Password changed successfully';
								$response["data"]	= null;
								echo $this->jsonEncode($response);
							}
						}
					}
					else
					{
						$response["status"]	= false;
						$response["code"]	= NOT_ACCEPTABLE;
						$response["message"]= 'Your Token has expired. please regenerate Token';
						$response["data"]	= null;
						echo $this->jsonEncode($response);
					}
				}
				else
				{
					$response["status"]	= false;
					$response["code"]	= NOT_FOUND;
					$response["message"]= "User doesn't generate Token";
					$response["data"]	= null;
					echo $this->jsonEncode($response);
				}
			}
			else
			{
				$response["status"]	= false;
				$response["code"]	= NOT_FOUND;
				$response["message"]= "User doesn't exist with this email : $email";
				$response["data"]	= null;
				echo $this->jsonEncode($response);
			}
		}
	}

	/**
     * Change password using phone number, if you already signin in app
	 * 
	 * @param String $provider 
	 * @param String $countryCode
	 * @param String $phoneNumber
	 * @param String $oldPassword
	 * @param String $newPassword
     */
	public function changePasswordUsingPhoneNumber($provider, $countryCode, $phoneNumber, $oldPassword, $newPassword) 
	{

	}

	/**
     * Forgot password using phone number, if you not signin in app
	 * 
	 * @param String $provider 
	 * @param String $token
	 * @param String $countryCode
	 * @param String $phoneNumber
	 * @param String $newPassword
     */
	public function forgotPasswordUsingPhoneNumber($provider, $token, $countryCode, $phoneNumber, $newPassword) 
	{

	}
}
?>