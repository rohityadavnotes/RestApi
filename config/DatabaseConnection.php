<?php
/* Including the Constants.php file */
include("Constants.php");

class DatabaseConnection  /* Create a class called DatabaseConnection */        
{
   /* Create connection variable to check database connection */
	private $connection;

	/* Class constructor */
	function __construct()
	{
        
	}
    
    /* Establishing database connection */
    public function connect()
	{
        /* Connecting to mysql database */
       $this->connection = new mysqli(DATABASE_HOST_NAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

        /* Checking if any error occured while connecting */
        if ($this->connection->connect_error) 
        {
          die("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * Get connection function
     * @return connection
     */
    public function getConnection() 
    {
		/* finally returning the connection */
        return $this->connection;
	}

    /* Closing database connection */
    public function close()
    {
        mysqli_close($this->$connection);
    }
}
?>