<?php


/**
 * interface IDebugger_
 * 
 */
interface IDebugger
{


	public function debug($message);



} // end of IDebugger_

/**
 * class DebuggerEcho
 * writes debug messages on the screen buffer
 */
class DebuggerEcho implements IDebugger
{
	const ERROR= 2;
	const STATUS= 1;
	const NOTICE= 0;
	private $loglevel=0;
	private $delimiter='<br>';
	
	public function setDelimiter($delimiter){
		$this->delimiter=$delimiter;
	}
	
	public function setLoglevel($level){
		$this->loglevel=$level;
	}
	/**
	 * 
	 *
	 * @param string message 

	 * @return nothing
	 * @access public
	 */
	public function debug( $message, $priority=0 ) {
		if ($priority >=$this->loglevel)
		echo date('j.m H:m:s',time()). ': ' .   $message . $this->delimiter;
		
	} // end of member function debug



} // end of DebuggerEcho

/**
 * class DebuggerNull
 * Writes nothing (like ls  > /dev/null)
 */

class DebuggerNull implements IDebugger
{
	/**
	 * 
	 *
	 * @param string message 

	 * @return 
	 * @access public
	 */
	public function debug( $message ) {
		
	} // end of member function debug



} // end of DebuggerNull

/**
 * class DebuggerLog
 * Writes the Debug Messages in a log file
 */
class DebuggerLog implements IDebugger
{

	/** Aggregations: */

	/** Compositions: */

	 /*** Attributes: ***/

	/**
	 * handle for the logfile
	 * @access private
	 */
	private $logfile = null;


	/**
	 * Set the path to the logfile
	 *
	 * @param string file 

	 * @return 
	 * @access public
	 */
	public function setLogfile( $file ) {		
		$this->logfile = fopen($file, 'a+');
	} // end of member function setLogfile

	/**
	 * close the file handle
	 * 
	 *
	 * @return 
	 * @access public
	 */
	public function __destruct( ) {		
		if (!empty($this->logfile))
		fclose($this->logfile);
	} // end of member function __destruct



	/**
	 * 
	 *
	 * @param string message 

	 * @return 
	 * @access public
	 */
	public function debug( $message ) {
		if ($this->logfile === null)
			$this->setLogfile("Debugger.log");
		$string = date('j.m H:m:s',time()). "  $message\n";
			
		fwrite($this->logfile, $string);
	} // end of member function debug



} // end of DebuggerLog


/**
 
 * class DebuggerFactory
 * delivers exactly one object from each class which implements the interface
 * IDebugger.
 * Example call:$debugger =DebuggerFactory::deliver(DebuggerFactory::D_LOG);
 
 */

class DebuggerFactory
{
	
	 /*** Attributes: ***/

	/**
	 * An array of Objects wich are derived from the Interface IDebugger
	 * @static
	 * @access private
	 */
	private static $items=array();

	/**	
	 * @var constant
	 * @desc alias for a DebuggerEcho
	 */
	const D_ECHO = 'DebuggerEcho';
	/**	
	 * @var constant
	 * @desc alias for a DebuggerLog
	 */
	const D_LOG = 'DebuggerLog';	
	/**	
	 * @var constant
	 * @desc alias for a DebuggerNull (no debug output
	 */
	const D_NULL = 'DebuggerNull';
	/**
	 * 
	 *
	 * @param string item Name of the desired Debugger


	 * @return IDebugger
	 * @static
	 * @access public
	 */
	public static function deliver( $item ) {
		if (empty(self::$items[$item]))
			self::$items[$item] = new $item();
		return self::$items[$item];
	} // end of member function deliver





} // end of DebuggerFactory
?>
