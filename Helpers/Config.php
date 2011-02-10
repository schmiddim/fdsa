<?php
class Config{
	
	private $values;
	public function __construct($configfile=''){
		if (empty($configfile))
			$configfile='config.ini';
		
		$this->values=parse_ini_file($configfile, TRUE);
				
	}#construct
	public function getDebuggerConfiguration(){
		
	}
	public function getDatabaseConfiguration(){
		return $this->values['DATABASE'];	
		
		
		
	}#getDatabaseConfiguration
	public function __toString(){
		$retval="<h1>Config</h1>";
		foreach ($this->values as $group=>$values){
			$retval.= "<h4>$group</h4>";
				foreach ($values as $key =>$value){
					$retval.= "$key: $value<br>";
				}	
		}#each		
		return $retval;	
	}#toString
}#class