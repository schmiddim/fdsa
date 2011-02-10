<?php 
require_once 'Helpers/Config.php';
require_once 'Helpers/Debugger.php';
#require_once 'Helpers/Database.php';
require_once 'Helpers/Registry.php';
require_once 'Helpers/Database2.php';
require_once('content.php');
require_once('php/blog.php');	
require_once 'Orm/Analyse.php';
require_once 'Orm/Manager.php';
require_once 'Orm/SqlGenerator.php';



$reg=Registry::getInstance();

$reg->setDebugger(new DebuggerEcho());
$reg->setConfig(new Config());
$config=$reg->getConfig();
$reg->setDbHandle(new DatabaseMySql2($config));
$debugger=$reg->getDebugger();
$db=$reg->getDbHandle();



$blog=new Blog('Mein Titel Titel Titel','scheiße dreck kacken');
/**
 *@todo relations^^ 
 * 
 */
/*
foreach ($categories as $c)
	$blog->addCategory(new Category($c));
*/
	
$c = new Comment("User","neuer Kommentar");
$ana=new Analyse($blog);		
$sqlgen= new SqlGenerator($ana, $reg->getConfig());
	
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
						
						echo $config;
				
						#echo $recent;?></div>
		<div id="widget"><h1>Reflect</h1><?php echo $ana;?></div>
		<div id="widget"><h1>empty</h1><!-- <ul><?php #echo $blog->getCategories('<li>','</li>');?></ul> --></div>
	</div><!--left-->

	<div id="center">	
		<div id="content">
		<?
		#echo $content1;
		/************content****************************/
	#echo	$sqlgen->getInsertCommand();
	
	#$debugger->debug($sqlgen->getCreateTableCommand());
	$debugger->debug($sqlgen->getInsertCommand(),'mysql');
	$db->modifyDb($sqlgen->getInsertCommand());
	$debugger->debug($db->getLastId(),"mysql");
	$debugger->debug($sqlgen->getCreateTableCommand(),'mysql');
	$db->modifyDb($sqlgen->getCreateTableCommand());
	
	
		/************content****************************/
		?></div>
		
	</div><!--center-->


	<div id="footer"><?echo $footer;?></div>
	</div><!-- container -->
</body>
</html>
