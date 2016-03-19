<?php
#task2 addition

function mysort($arr,$field)
{
    for($i=0;$i<count($arr)-1;$i++) {
      for($j=$i+1;$j<count($arr);$j++) {
        if ($arr[$i]["$field"] < $arr[$j]["$field"]) {
          $temp=$arr[$i];
          $arr[$i]=$arr[$j];
          $arr[$j]=$temp;
        }
      }
    }

    return $arr; 
}

$brands = array(
  array('name' => 'Oracle','popularity' => 5),
  array('name' => 'Microsoft','popularity' => 10),
  array('name' => '1C','popularity' => '2')
  );

$content="Before sorting: <br>";

while (list($key, $value) = each($brands)) {
    $content.= "\$brands[$key][\"popularity\"]= " . $value["popularity"] . "<br>";
}

$brands=mysort($brands,"popularity");

$content.="<br><br>After sorting: <br>";
while (list($key, $value) = each($brands)) {
    $content.= "\$brands[$key][\"popularity\"]= " . $value["popularity"] . "<br>";
}

echo $content;

//print_r($brands); 


?>