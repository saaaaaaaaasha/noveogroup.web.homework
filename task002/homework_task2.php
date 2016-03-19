<?php
#task2

function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a["popularity"] < $b["popularity"]) ? 1 : -1;
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

usort($brands, "cmp");

$content.="<br><br>After sorting: <br>";
while (list($key, $value) = each($brands)) {
    $content.= "\$brands[$key][\"popularity\"]= " . $value["popularity"] . "<br>";
}

echo $content;

//print_r($brands); 


?>