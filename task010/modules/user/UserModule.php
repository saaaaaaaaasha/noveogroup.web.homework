<?php
class UserModule extends CWebModule
{
    
    public $defaultController = 'user';
    public $viewPath = '/user';
    //pulbic $layout = '';
    
    public function init() {
        $this->setImport(array(
            'user.models.*',
            'user.components.*',
        ));
    }
}