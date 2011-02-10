<?php


class SqlGenerator{
	private $ao;		//AanalyseObjekt
	public function __construct(Analyse $ao){
		$this->ao=$ao;
	}
	
	/*CREATE TABLE example_timestamp (
         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
         data VARCHAR(100),
         cur_timestamp TIMESTAMP(8)*/
	private $tn="dkdkd";
	private $templateCreate="
						CREATE TABLE IF NOT EXISTS #TABLENAME(\n
							id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,\n
							#VALUES\n						
						);
						";
	private $templateInsert="
						INSERT  INTO #TABLENAME 
						(#ROWS) VALUES (#VALUES)
	
	
	";
	
	#insert into Blog (title, slogan) 
	#VALUES( "unterklärliches am Rande", "Worte des Parteivorsitzenden");
	
	public function getInsertCommand(){
		$rows=array();
		$values=array();
		foreach ($this->ao->getPropertyValues() as $key =>$value){
			array_push($rows, $key);
			array_push($values, $value);
		}
		$strRows=implode(',\n',$rows);
		$strValues=implode(',\n', $values);
	
		$sql=str_replace('#TABLENAME', $this->ao->getClassName(), $this->templateInsert);
		$sql=str_replace('#VALUES', $strValues, $sql);
		
		return str_replace("\n", '<br>', $sql);
	}
	
	public function getCreateTableCommand(){
		

		$types=array();
		foreach ($this->ao->getPropertyTypes() as $key =>$type){
			array_push($types,$key." ".  $this->getSqlType($type));				
		}
			$strTypes=implode(",\n",$types);
			
		$sql=str_replace('#TABLENAME', $this->ao->getClassName(), $this->templateCreate);
		$sql=str_replace('#VALUES', $strTypes, $sql);			
		return str_replace("\n", '<br>', $sql);
	}
	
	
	private function getSqlType($phpType){
		switch ($phpType){
			case 'integer':
				return 'int(11)';
			case 'double':
				return '????';
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
<!-- 
	private function generateCreateTable(){
		$sql = "\nCREATE TABLE IF NOT EXISTS {$this->tablename} (\n";
		$sql.="id int(11) NOT NULL AUTO_INCREMENT,\n";
		foreach ($this->attributeTypes as $key =>$value)
			$sql.="$key {$this->types[$value]} DEFAULT NULL,\n";
		$sql.= "PRIMARY KEY (`id`)\n";
		$sql.=") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->createTableCommand= $sql;
	}//generateCreateTable
	 -->