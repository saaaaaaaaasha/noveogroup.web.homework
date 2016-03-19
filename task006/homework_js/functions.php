<?php
	//if data hasn't been sent, then redirect to index page
	if ($_GET["getdata"]!=1) header("Location: index.html");
	
	$content="";
	//array of field names
	$fieldnames=array("ФИО","Пол","Город","E-mail","Логин","Пароль","О себе","Родился");

	$content.="<h1>Добро пожаловать,<small> ".$_POST["fl4"]."</small></h1><hr>";
	for($i=0;$i<count($fieldnames);$i++) {
		$content.="<div class=\"form-group\"><label class=\"col-sm-2 control-label\">".$fieldnames[$i]."</label>";
		$content.="<div class=\"col-sm-10\"><p class=\"form-control-static\">".$_POST["fl$i"]."</p>    </div></div>";
	}
	
	//print information
	echo $content;
?>

