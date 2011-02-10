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
	private $dbh;
	private $lastId;
	private $lastError=array();
	private $lastWarning=array();
	
	public function setDebugger($d=""){}
	public function getLastError(){}
	public function getLastWarning(){}
	public function getResult(){}
	public function getLastId(){return $this->lastId;}
	public function query($sqlstatement){}
	public function modifyDb($sql){
		$this->dbh->exec($sql);
		$this->lastId=$this->dbh->lastInsertId();
		
		
		
	}	
	public function __construct(Config $c){
		$dbsettings=$c->getDbConf();
		$dsn="mysql:dbname={$dbsettings['database']};host={$dbsettings['host']}";
		$this->dbh=new PDO
			(
			$dsn, 
			$dbsettings['user'], 
			$dbsettings['pwd'],
			array( 
					PDO::ATTR_PERSISTENT => true, 
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
			#		PDO::NOTICES_FETCH =>PDO::NOTICES_ENABLED,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			) 
		
		
		);								
	}#construct;
	
	
	
}



?>

