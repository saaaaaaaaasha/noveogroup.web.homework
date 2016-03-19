<?php
/** home work 2, task 1 */

class MyClass{

  private $str;
  
  public function __get($name) {
    if (isset($this->$name)) {
      echo "I called to variable '$name'\r\n";
	  return $this->$name;
	}
	return false;
  }

  function __construct() {
    $this->str="Hello";
    echo "I'm created\r\n";
  }
   
  function __clone() {
    echo "I'm cloned\r\n";
  }
  
  public function __toString() {
    return get_class($this)."\r\n";
  }
  
  public function __call($function, $args) {
    $args = implode(', ', $args);
    print "I called to method $function() with args '$args' failed!\r\n";
  }
		
  private function simpleFunction($arg1,$arg2,$arg3) {
    //echo "I called to method '".__FUNCTION__."'\r\n"; 
    return $arg1.$arg2.$arg3;
  }
}


$myObject= new MyClass(); //create object of MyClass
$myObject2 = clone $myObject; //clone
echo $myObject; //print object
$myObject->str."a\r\n"; //request variable
$myObject->simpleFunction("Go ","go ","go!")."a\r\n"; //request method

?>