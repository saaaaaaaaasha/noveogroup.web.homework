<?php

require_once("Model.php");
require_once("View.php");

class Controller{

  private $view;
  private $model;
  
  public function __construct(){
    $this->view=new View();
    $this->model=new Model();
  }

  public function showListing() {
    $data=$this->model->printAllFiles();
	echo $this->view->getContent($data);
  }

}

?>