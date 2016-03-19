<?php
require_once "iDbConnectable_interface.php";


class DbConnectable implements iDbConnectable {
    protected $db;
    protected $table;
    public $attributes;

    public function __construct($_table,$_attributes){
        $this->db=new PDO('mysql:host=localhost;dbname=instagram', 'root','');
        $this->table=$_table;
        foreach ($_attributes as $key => $value) {
            $this->attributes[$key]=$value;
        }
		
        foreach($_attributes as $key => $value) {
            if(!isset($this->attributes[$key])) {
                echo 'ERROR! Mismatch number of parameters!';
                exit;
            }
        }
		
        return $this;
    }

    public function findByPk($pk){
        try{
            $result = $this->db->query("SELECT * from `".$this->table."` WHERE `id`= $pk");
            $r=$result->fetch();
            if(!$r) return false;

            foreach ($this->attributes as $key => $value) {
                $this->attributes[$key]=$r[$key];
            }
            return $this;
        }
        catch (PDOException $e){
            echo "ERROR! ".$e->getMessage()."\n";
            exit();
        }
    }

    public function save(){
         try{
            $k=$this->db->query("SELECT * from `".$this->table."` WHERE `id`=".$this->attributes['id']);
            $r=$k->fetch();
            $data=array();
            $i=0;
            $in="";

            if(!$r){
                foreach ($this->attributes as $key => $value) {
                    $data[$i++]=$value;
                }               
                $in  = str_repeat('?,', count($data) - 1) . '?';
                $row=$this->db->prepare("INSERT INTO `".$this->table."` VALUES($in)");
                $row->execute($data);
            }
            else{
                foreach ($this->attributes as $key => $value) {
                    if($key=="id") continue;
                    $in.=$key."=:".$key.",";
                }
                $in=substr($in,0,strlen($in)-1);
                $row=$this->db->prepare("UPDATE `".$this->table."` SET $in WHERE id=:id");
                $row->execute($this->attributes);
            }
            return $this;
        }
        catch (PDOException $e){
            echo "ERROR! ".$e->getMessage()."\n";
            exit();
        }
    }


    public function where($attribute, $value,$with=false){
 		$data=array();
        $result=array();
        $attributes=array();
        $i=0;

        $k=$this->db->query("SELECT * FROM `".$this->table."` WHERE $attribute='$value'");

        while($r=$k->fetch()) {
            foreach ($this->attributes as $key => $value) {
                $attributes[$key]=$r[$key];
            }
			$data[$i++] = new DbConnectable($this->table,$attributes);
        }

        if (!$with) return $data;
        $attributes=array();

        for($i=0;$i<count($data);$i++) {

            $id=$data[0]->attributes['id'];

            $k=$this->db->query("SELECT t2.* FROM `".$this->table."` t1,`$with` t2 WHERE t1.id=t2.id_".$this->table." AND t1.id='$id'");       
            //echo "SELECT t2.* FROM `".$this->table."` t1,`$with` t2 WHERE t1.id=t2.id_".$this->table." AND t1.id='$id'"."<br>";

            $j=0;
            while($r=$k->fetch()) {
                foreach ($r as $key => $value) {
                    if (is_numeric($key)) continue;
                    $attributes[$key]=$r[$key];
                }
                $result[$j++] = new DbConnectable($with,$attributes);                
            }
            $data[$i]->$with=$result;
        }

        return $data;
    }
	
    public function __get($name)
    {        
        if (isset($this->attributes[$name]))
        {
            return $this->attributes[$name];   
        }
		else return $this->name;
    }
    
     public function __set($name,$value)
    {        
        if (isset($this->attributes[$name]))
        {
            $this->attributes[$name] = $value;
        }   
		else return $this->name = $value;
    }	
	
	
	
}