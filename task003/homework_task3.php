<?php
#task3

function fillSpace($count) {
  $str="";
  for($i=0;$i<$count*2;$i++) {
    $str.=" ";
  }
  return $str;
}

function createTree($data,$parent_id,$k,$tree=""){
  if (isset($data[$parent_id]) && count($data[$parent_id])!=0){
    foreach($data[$parent_id] as $cat){
      $tree .= fillSpace($k).$cat["name"].' #'.$cat["id"]."\r\n";
      $tree .= createTree($data,$cat["id"],$k+1);
	}
  }
  else return null;
  return $tree;
}


$handle = fopen("categories.csv", "r") or die("Error of file!");
$i=0;
$data=array(); //array of data from file

while($str=fgetcsv($handle,1000,";")) {	
  //rename keys for easy operation
  //first column is "id", second - "parent"_id and third - "name category"
  $namedStr=array("id" => $str[0],"parent_id" => $str[1],"name" => $str[2]); 
  
  //add category in array
  $data[$namedStr["parent_id"]][$namedStr["id"]] = $namedStr;
}

//build tree
$content=createTree($data,"",0);

//print tree
echo $content;
fclose($handle);

?>