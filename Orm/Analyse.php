<?php
	class Analyse{
			private $class;
			private $classname;
			private $hash;			
			private $propertyTypes=array();
			private $propertiyValues=array();
			
			public function __construct($class){
				$this->class=$class;
				$this->classname=$this->getClassName();
				$this->reflect();
			}#construct

			private function reflect(){
				$reflect= new ReflectionClass($this->class);			
				$props=$reflect->getProperties();
				foreach ($props as $prop){	
					$prop->setAccessible(true);			
					$type=null;
					$name=$prop->getName();
					$value=$prop->getValue($this->class);
					$this->propertyTypes[$name]=gettype($value);
					$this->propertyValues[$name]=$value;						
				}	
			}#reflect
			
			public function __toString(){
				$retval="<h4>{$this->classname}</h4>";
				foreach ($this->propertyValues as $key=> $value)					
					$retval.="$key :$value ,type is {$this->propertyTypes[$key]}<p>";
				return $retval;					
			}#toString
			
			public function getClassName(){
				if(!is_object($this->class) && !is_string($this->class)){
					return false;
				} 
				$class=explode('\\', (is_string($this->class)? $this->class : get_class($this->class)));
				return $class[count($class)-1];
			}#getClassName
			
			public function getPropertyTypes(){return $this->propertyTypes;}
			public function getPropertyValues(){return $this->propertyValues;}			
		}#class
?>