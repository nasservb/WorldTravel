<?php

namespace nasservb\AgencyAssistant\Database\Drivers;

 class Mysql implements DriverInterface{

	public $connection;

	function connect($hostname,$database,$username,	$password)
	{
		if (!$this->connection)
        {			
			$this->connection= mysqli_connect($hostname, $username, $password,$database);  			
			mysqli_set_charset($this->connection,'UTF8');		
        }
	}
	
	public function run($query,&$row='',&$max=0)
	{
		$Result = mysqli_query($this->connection,$query ) ;
		if($Result)
		{
			if (is_bool($Result) === true) return $Result;//for update query
			$row = mysqli_fetch_assoc($Result);
			$max = mysqli_num_rows($Result); 
			if($max>0)
			{
				$result=array();
				for($i=0;$i<$max;$i++)
				{
					$result[$i]=$row;
					$row = mysqli_fetch_assoc($Result);
				}
				$row = $result[0];
				mysqli_free_result($Result);
				return $result;
			}
			else
			{
				return 0;
			}
		} 
		else
		{ 
            $message=str_replace('\'',"/",mysqli_error($this->connection));
            $code=str_replace('\'',"/",mysqli_errno($this->connection));
            
            throw new Exception("Invalid query:". $code . ' message: '.  $message );
		}
	}	 

	public function getLastInsertedId() {
		return  mysqli_insert_id($this->connection);
	}
}
