<?php

	function confirmPassword($hash, $password)
	{
	    return crypt($password, $hash) === $hash;
	}
	 
	function hashPassword($password,$prefix)
	{
	    $salt = md5(uniqid($prefix, true));
	    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
	    return crypt($password, '$2a$08$' . $salt);
	}

	$login ="admin";
	$hash = '$2a$08$NWE5Yzk1N2IyODM1YWU2Mu9AGV.yPA8nQO2EymRsXA0GievDT0IbK'; //hash of password '12345'
	$prefix = "my_prefix"; //prefix for salt

	$content="";

    //authorization
    if((isset($_POST['auth']))){
        $ulogin=htmlspecialchars($_POST['login']);
        $upassword=htmlspecialchars($_POST['password']);
        $content="<b>Your login</b>: ".$ulogin."<br><b>Your password</b>: ".$upassword."<br><br>";
    }
   
    //check password and login
	if(confirmPassword($hash, $upassword) && $login===$ulogin) {
		$content.= "You enter <b>right</b> login and password."; 
	} else {
		$content.= "You enter <b>wrong</b> login or password.";
	}

	//$content.= "<br>Hash: ".hashPassword($upassword,$prefix)."<br>"; //show hash

	echo $content;