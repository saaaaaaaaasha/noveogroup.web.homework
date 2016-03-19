<?php

interface iStorage {
    public function storeObject($key,$object);
    public function remove($key);   
    public function getObject($key);
}

class MyStorage implements iStorage{
    private $data;
    
    public function MyStorage() {
        $this->data=array();
    }
    
    public function storeObject($key,$object) {
        if (isset($this->data[$key])) {
            return false;
        }
        $this->data[$key]=$object;
        return true;
    }
    
    public function remove($key) {
        if (!isset($this->data[$key])) {
            return false;
        }
        unset($this->data[$key]);
        return true;
    }
    
    public function getObject($key){
        if (!isset($this->data[$key])) {
            //return false;
            throw new Exception('error');
        }       
        return $this->data[$key];
    }
 
}


class MyStorageHandler {
    private static $myStorage;
    
    public static function getInstance(){
        if (!isset(self::$myStorage)){
            self::$myStorage=new MyStorage();
        }
           
        return self::$myStorage;
    }
    
}





$myStorage=MyStorageHandler::getInstance();//new MyStorage();
$myStorage=MyStorageHandler::getInstance();


echo "Add Object: ".(($myStorage->storeObject(1, "hello"))?"true":"false")."\n";
echo "Add Object: ".(($myStorage->storeObject(1, "world"))?"true":"false")."\n";
echo "Add Object: ".(($myStorage->storeObject(2, "world2"))?"true":"false")."\n";
echo "Add Object: ".(($myStorage->storeObject("int", 100))?"true":"false")."\n\n";

try{
    $temp=$myStorage->getObject(11);
    var_dump($temp);   
}
catch(Exception $e) {
    echo $e->getMessage();
}



/*
function fillSpace($count) {
for($i=0;$i<$count*2;$i++) $str.="&nbsp;";
return $str;
}
function createTree($data,$parent_id,$k){
if (count($data[$parent_id])!=0){
foreach($data[$parent_id] as $cat){
$tree .= fillSpace($k).$cat["name"].' #'.$cat["id"]."<br>";
$tree .= createTree($data,$cat["id"],$k+1);
}
}
else return null;
return $tree;
}
if (file_exists("categories.csv")){
$f = fopen("categories.csv", "rt") or die("Ошибка файла!");
}
$i=0;
while($temp=fgetcsv($f,1000,";")) {
if ($temp[0]==="") $temp[0]=(int)0;
if ($temp[1]==="") $temp[1]=(int)0;
$semp=array("id" => $temp[0],"parent_id" => $temp[1],"name" => $temp[2]);
$data[$semp["parent_id"]][$semp["id"]] = $semp;
}
$content=createTree($data,0,0);
echo $content;
fclose($f);
*/

/*#task1
$ids = array(1,2,3,4,"353","sfsf");
$sql= 'SELECT * FROM `table` WHERE `id` IN (';//)';
for($i=0;$i<count($ids);$i++) {
    $sql.=$ids[$i].',';
}

$sql=substr($sql,0,strlen($sql)-1).')';

//$str=implode(", ", $ids);
//echo $str;
//echo $sql;

#task2

$weeks=array("Вс","Пн","Вт","Ср","Чт","Пт","Сб");
$days=array(31,28,31,30,31,30,31,31,30,31,30,31);
$w=date("w")-1;
$m=date("m");
$d=date("d");



echo "w: $w   m:$m  d:$d \n\n ";
$start=false;
$content="";
foreach($weeks as $value) {$content.=sprintf("%' 8s",$value);}

for ($i=0;$i<$days[$m]+$w;$i++) {
    if ($i%7==0) $content.="\n";
    if ($i>$w) $start=true;   
    if ($start==false) {$content.=sprintf("%' 6s"," ");}
    else $content.=sprintf("%' 6s",$i-$w);
}
//echo $content;


//выравнивание (ширина 20 символов) по правому краю, пустоту заполняем '_':
//printf("%'_20s",MyString);  >>> ____________MyString <<< 


#task3

function dosmth($var1,$var2) {
    $numargs = func_num_args(); 
    var_dump (get_defined_vars());
    
    
    $content="Текущая строка: %s\nИмя файла: %s\nИмя функции: %s\n";
    $content.="Количество аргументов: %s\n";
    //foreach($numargs as $value) $content.=var_dump($value)."\n";
    printf($content,__LINE__,__FILE__,__FUNCTION__,$numargs);
    
    //echo func_get_arg(0);
}

dosmth(4,5);


//echo date("d.m.Y H:m:s");*/
?>

