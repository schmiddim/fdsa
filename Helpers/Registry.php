<?php
require_once ('Helpers/geshi/geshi.php');
class Registry{
	
	/*----------singleton---------------*/
	protected static $instance=null;
	
	public static function getInstance(){
		if (self::$instance==null)
			self::$instance  =new Registry();
		return self::$instance;
	}#getInstance
	
	protected function __construct(){}#__construct	
	private function __clone(){}
	/*----------singleton---------------*/
	
	protected $values=array();
	
	const KEY_DEBUGGER='debugger';
	const KEY_DBH='dbh';
	const KEY_CONFIG='config';
	protected function set($key, $value){
		$this->values[$key]=$value;
	}#set
	protected  function get($key){
		if (isset($this->values[$key]))
			return $this->values[$key];
		return null;
	}#get
	
	public function setDebugger(IDebugger $d){
		$this->set(self::KEY_DEBUGGER, $d);
	}
	public function getDebugger(){
		return $this->get(self::KEY_DEBUGGER);
	}
	
	public function setDbHandle(DatabaseMySql2 $d){
		$this->set(self::KEY_DBH, $d);
	}
	
	public function getDbHandle(){
		return $this->get(self::KEY_DBH);
	} 
	
	public function getConfig(){	
		return $this->get(self::KEY_CONFIG);
		
	}
	public function setConfig (Config $c){
		$this->set(self::KEY_CONFIG, $c);
	}
}#registry
/*****************************************************************************************************/

?>

