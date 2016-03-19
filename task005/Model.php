<?php

class Model{

  private $data;
  private $index;
	
  public function __construct(){
    $this->data=array();
	$this->index=0;
  }
  
  public function printAllFiles(){
    if (!count($this->data)) {
	  $this->getListFiles(".");  
	}
    return $this->data;
  }
  
  private function getListFiles($dir){
    $list=glob($dir."/*");
    for ($i=0;$i<count($list);$i++) {
      if (is_dir($list[$i])) {
	    $this->getListFiles($list[$i]);
      }
      else {
	    $this->data[$this->index++]=$list[$i];
      }
    }
  }

}


?>