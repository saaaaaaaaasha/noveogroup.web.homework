<?php
#task1
require_once "lib/data.php";

function getReplaceContent($sr,$file) {
  $search = array();
  $replace = array();
  $i = 0; 
  foreach ($sr as $key => $value) {
    $search[$i]="%$key%";
    $replace[$i]=$value;
    $i++;
  }   
  return str_replace($search,$replace,file_get_contents($file));  
}


foreach($users as $name) {
  $sr["name"]=$name;
  $list.=getReplaceContent($sr,"tmpl/list_item.tpl");
}

$sr["items"]=$list;
$content=getReplaceContent($sr,"tmpl/main_content.tpl");


echo $content;
?>