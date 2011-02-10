<?php 
require_once 'Helpers/Debugger.php';
require_once('content.php');
require_once('php/blog.php');	
require_once 'Orm/Analyse.php';
require_once 'Orm/Manager.php';
require_once 'Orm/SqlGenerator.php';
require_once 'Helpers/Registry.php';


$reg=Registry::getInstance();
$reg->setDebugger(new DebuggerEcho());
$debugger=$reg->getDebugger();
/*
use Orm\Reflector;
use SimpleBlog\Blog;
use SimpleBlog\Category;
use SimpleBlog\Comment;
*/
$blog=new Blog('Unerkl&auml;rliches am Rande','Worte des Parteivorsitzenden');


#$debugger=DebuggerFactory::deliver(DebuggerFactory::D_ECHO);

foreach ($categories as $c)
	$blog->addCategory(new Category($c));

?>
<!DOCTYPE html>
<html lang="de">
<head>
	<title>Unerkl&auml;rliches am Rande</title>
	<link rel="stylesheet" type="text/css" href="layout.css" />
	<meta charset="UTF-8">
</head>
<body>

	<div id="container">
	<div id="header">
		<div id="logo">
	
		</div>	
		<h1><?php echo $blog->title(); ?></h1>
		<h3><?php echo $blog->slogan();?></h3>

	</div>
	<div id="left">
		<div id="widget"><?php #echo $recent;?></div>
		<div id="widget"><?php #echo $archiv;?></div>
		<div id="widget"><ul><?php #echo $blog->getCategories('<li>','</li>');?></ul></div>
	</div><!--left-->

	<div id="center">	
		<div id="content">
		<?
		#echo $content1;
		/************content****************************/
		$c = new Comment("User","neuer Kommentar");
		$rc=new Analyse($blog);		
		$sqlgen= new SqlGenerator($rc);
		$debugger->debug($sqlgen->getCreateTableCommand());
		echo "--------------"; 
		$debugger->debug($sqlgen->getInsertCommand());
		echo $rc;
		
		/************content****************************/
		?></div>
		
	</div><!--center-->


	<div id="footer"><?echo $footer;?></div>
	</div><!-- container -->
</body>
</html>
