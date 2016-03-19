<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password;
	private $_identity;
	public $verifyCode;

	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
            array(
                 'password', 'length', 'min' => 4, 'max'=>20,
                 'tooShort'=>Yii::t("translation", "{attribute} содержит недостаточно символов."),
                 'tooLong'=>Yii::t("translation", "{attribute} содержит слишком много символов."),
            ),
 			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),                  
		);
	}
       
	public function attributeLabels()
	{
		return array(
            'username'=>'Имя пользователя',
            'password'=>'Пароль',
            'verifyCode'=>'Проверочный код',
		);
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity,0);
			return true;
		}
        $this->addError('password','Некорректное имя пользователя или пароль.');
		return false;
	}
}
