<?php 
#namespace SimpleBlog;
class Blog{
	
	
	
	private $dummyint;
	private $dummydouble;
	protected $title, $slogan;		
	
	protected $categories=array();
	public function __construct($title, $slogan){
		$this->title=$title;
		$this->slogan=$slogan;
		
		$this->dummyint=32000;
		$this->dummydouble=3.1415;
	}#function
	public function addCategory(Category $c){
		array_push($this->categories, $c);
		
	}#function
	public function getCategories($pre='',$post=''){
		$retval='';
		foreach ($this->categories as $c){
			$retval.=$c->getTag($pre,$post);
		}
		return $retval;
	}#function 
	
	
	public function addArticle(Article $a){
		
	}
	public function title($title=""){
		if (empty($title)){
			return $this->title;
		} else {
			$this->title=$title;
		}#fi
	}#title
	public function slogan($slogan=""){
		if (empty($title)){
			return $this->slogan;
		} else {
			$this->slogan=$slogan;
		}#fi
	}#slogan
}#class



class Article{
	protected $title, $autor,$comments,$tags, $categories, $text;
	protected $article;
	
}#Article

class Tag{
	protected $article;
	protected $name;
}#Tag

class Category{
	protected $articles;
	protected $parentCategory;
	protected $name;
	public function __construct($name){
		$this->name=$name;
	}#function
	public function getTag($pre="", $post=""){
		return "$pre{$this->name}$post\n";
	}

}#Category

class Comment{
	protected $autor, $text;
	public function __construct($autor, $text){
		$this->autor=$autor;
		$this->text=$text;
		
	}
	public function returnSelf(){
		return $this;
	}
}#Comment


class Autor{
	protected $name, $fname,$email;
}#Autor
?>