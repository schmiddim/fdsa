<?php

/*
 * @todo attach a registry object to this thing
 * 
 */
interface IDatabase
{

	/** Aggregations: */

	/** Compositions: */

	/**
	 * 
	 *
	 * @return string
	 * @access public
	 */
	public function getLastError( );

	/**
	 * 
	 *
	 * @return int
	 * @access public
	 */
	public function getLastId( );

	/**
	 * 
	 *
	 * @param string SqlStatement 

	 * @param string values_ 

	 * @return bool
	 * @access public
	 */
	public function CommitCommand( $SqlStatement,  $values_, $selectStatement=false );

	/**
	 * 
	 *
	 * @return string
	 * @access public
	 */
	public function getResult( );

} // end of IDatabase



/**
 * class DatabaseMySql
 * 
 */

final class Configuration {
	const DB_HOST='localhost'; 
	const DB_DATABASE='gloria'; 
	const DB_PORT=3306; 
	const DB_USER='root'; 
	const DB_PASSWORD='1q2w3e4r'; 
	
	
}
class DatabaseMySql implements IDatabase
{

	/** Aggregations: */

	/** Compositions: */

	 /*** Attributes: ***/
	private $dbh;

	private $resultArray;
	private $lastError = array();
	private $lastWarning = array();
	/**
	 * 
	 *
	 * @return string
	 * @access public
	 */
	
	public function __construct(){		
		$db = new PDO(
				'mysql:host='.Configuration::DB_HOST.';dbname='.Configuration::DB_DATABASE.';port='.Configuration::DB_PORT, 
				Configuration::DB_USER, 
				Configuration::DB_PASSWORD, 
				array( 
					PDO::ATTR_PERSISTENT => true, 
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
			#		PDO::NOTICES_FETCH =>PDO::NOTICES_ENABLED,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				) 
			); 
			$this->dbh = $db	;	
			
	}//construct
	public function getLastError( ) {
		return $this->lastError;
	} // end of member function getLastError


	/**
	 * 
	 *
	 * @return int
	 * @access public
	 */
	public function getLastId( ) {
		return $this->id;
	} // end of member function getLastId

	/**
	 * 
	 *
	 * @param string SqlStatement 

	 * @param string values_ 

	 * @return bool
	 * @access public
	 */
	public function CommitCommand( $SqlStatement,  $values , $selectStatement=false) {
	 	$vals=array();
		foreach ($values as $key =>$value){
			if ($value ==null){	
				array_push($vals, "");
			}else{
			array_push($vals, $value);
			}
		}
	 		
	 
		$stmt= $this->dbh->prepare($SqlStatement);
	 	try{
		if($stmt->execute($vals)){		
			if ($selectStatement)		
				$this->resultArray= $stmt->fetchAll();
		
		}
	 	} catch (Exception $e){
	 		;
	 	}
	 	$this->id= $this->dbh->lastInsertId();
	 	$this->lastError = $stmt->errorInfo();
		$this->getLastWarning();
	 	return $stmt->errorCode();
		
	 	
	
	} // end of member function CommitCommand
	public function getLastWarning(){	
		$sql ="SELECT @@warning_count";
		$sql = "SHOW WARNINGS";
		$stmt= $this->dbh->prepare($sql);
		$stmt->execute();						
		$this->lastWarning =$stmt->fetchAll();
		return $this->lastWarning;
	}
	/**
	 * 
	 *
	 * @return string
	 * @access public
	 */
	public function getResult( ) {
		
		return $this->resultArray;
			   
	} // end of member function getResult_



} // end of DatabaseMySql


?>