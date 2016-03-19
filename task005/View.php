<?php

class View{

  private $tmpl;

  public function __construct(){
    $this->tmpl["list_item"]=file_get_contents("tmpl/list_item.tpl");
    $this->tmpl["main"]=file_get_contents("tmpl/main.tpl");
  } 
  
  function getReplaceContent($sr,$file) {
    $search = array();
    $replace = array();
    $i = 0; 
    foreach ($sr as $key => $value) {
      $search[$i]="%$key%";
      $replace[$i]=$value;
      $i++;
    }   
    return str_replace($search,$replace,$file);  
  }
  
  function getContent($data) {
 	$list="";  
    foreach($data as $name) {
      $replaceable["name"]=$name;
      $list.=$this->getReplaceContent($replaceable,$this->tmpl["list_item"]);
    }
    $replaceable["items"]=$list;	
	return $this->getReplaceContent($replaceable,$this->tmpl["main"]);
  }


}

?>