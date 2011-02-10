<?php 
require_once 'Helpers/Config.php';
require_once 'Helpers/Debugger.php';
require_once 'Helpers/Database.php';
require_once 'Helpers/Registry.php';
require_once 'Helpers/Database2.php';
require_once('content.php');
require_once('php/blog.php');	
require_once 'Orm/Analyse.php';
require_once 'Orm/Manager.php';
require_once 'Orm/SqlGenerator.php';



$reg=Registry::getInstance();
$reg->setDebugger(new DebuggerEcho());
$reg->setDbHandle(new DatabaseMySql());
$debugger=$reg->getDebugger();
$db=$reg->getDbHandle();
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
		<div id="widget"><?php 
						$config=new Config();
						echo $config;
							
						#echo $recent;?></div>
		<div id="widget"><h1>empty</h1><?php #echo $archiv;?></div>
		<div id="widget"><h1>empty</h1><!-- <ul><?php #echo $blog->getCategories('<li>','</li>');?></ul> --></div>
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
	echo	$db->CommitCommand($rc,null,false);
	 print_r($db->getLastError());
	 print_r($db->getLastWarning());
	
		
		/************content****************************/
		?></div>
		
	</div><!--center-->


	<div id="footer"><?echo $footer;?></div>
	</div><!-- container -->
</body>
</html>
