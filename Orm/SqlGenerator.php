<?php


class SqlGenerator{
	private $ao;		//AanalyseObjekt
	private $sqlCommands=array();
	public function __construct(Analyse $ao, Config $c){
		$this->ao=$ao;
		$this->sqlCommands=$c->get('MYSQLCOMMANDS');
		
		
	}#construct

	public function getInsertCommand(){
		$rows=array();
		$values=array();
		foreach ($this->ao->getPropertyValues() as $key =>$value){
			array_push($rows, $key);
			if (is_string($value))		//Escape Strings
				$value="'$value'";
			array_push($values, $value);
		}#each
		$strRows=implode(',',$rows);
		$strValues=implode(',', $values);
	
		$sql=str_replace('#TABLENAME', $this->ao->getClassName(), $this->sqlCommands['insert']);
		$sql=str_replace('#ROWS', $strRows, $sql);
		$sql=str_replace('#VALUES', $strValues, $sql);		
		return str_replace("\n", '<br>', $sql);
	}#getInsertCommand
	
	public function getCreateTableCommand(){	
		$types=array();
		foreach ($this->ao->getPropertyTypes() as $key =>$type){
			array_push($types,$key." ".  $this->getSqlType($type));				
		}
			$strTypes=implode(",",$types);
			
		$sql=str_replace('#TABLENAME', $this->ao->getClassName(), $this->sqlCommands['create']);
		$sql=str_replace('#VALUES', $strTypes, $sql);			
		return $sql;
	}
	
	
	private function getSqlType($phpType){
		switch ($phpType){
			case 'integer':
				return 'int(11)';
			case 'double':
				return 'double';
			case 'string':
				return 'varchar(255)';
			case 'array':
				return 'int(11)';
				
			
		}#case		
	}#getSqlType
	public function getAlterTableCommand(){
		
	}

	public function getUpdateCommand(){
		
	}
	
	
}#class
?>