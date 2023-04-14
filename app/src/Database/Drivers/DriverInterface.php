<?php
namespace nasservb\AgencyAssistant\Database\Drivers;

interface DriverInterface{

	public function connect($hostname,$database,$username,	$password);
	
	public function run($query,&$row='',&$max=0);

	public function getLastInsertedId();
}