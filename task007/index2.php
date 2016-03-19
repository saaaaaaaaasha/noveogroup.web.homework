<?php
    session_start();

	interface IAuthenticatable {
	    public function hashPassword($userInput);
	    public function verifyPassword($userInput);
	}

	class Authenticatable implements IAuthenticatable{

	    public function hashPassword($userInput){
		    $salt = md5(uniqid('my_prefix', true));
		    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);	    
		    $hash=crypt($userInput, '$2a$08$' . $salt);
		    $_SESSION['hash']=$hash;
		    return $hash;
	    }
	    public function verifyPassword($userInput){
		    if (isset($_SESSION['hash'])) {
		    	$hash=$_SESSION['hash'];
		    	return crypt($userInput, $hash) === $hash;
		    }
		    return false;
	    }
	}


	//$p=new Authenticatable();
	//$pass="12345";
	//$p->hashPassword($pass);
	//if ($p->verifyPassword($pass)) echo "Yuupi<br>";
	//echo "session: ".$_SESSION['hash']."<br><br>";


