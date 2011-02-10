<?php

interface IDatabase2{
	public function setDebugger($d="");
	public function getLastError();
	public function getLastWarning();
	public function getResult();
	public function getLastId();
	public function query($sqlstatement);
	public function modifiyDb($sqlstatement);	
	
	
	
}

class DatabaseMysql2{
	public function setDebugger($d=""){}
	public function getLastError(){}
	public function getLastWarning(){}
	public function getResult(){}
	public function getLastId(){}
	public function query($sqlstatement){}
	public function modifiyDb($sqlstatement){}	
	
	
	
}



?>

