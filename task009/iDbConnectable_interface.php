<?php

interface iDbConnectable { 
	/**
	* @param Array $attributes
	* @return iDbConnectable
	*/
    public function __construct($_table,$_attributes);
 	/**
	* @param integer $pk
	* @return iDbConnectable
	*/
    public function findByPk($pk);
    /**
	* make 'insert' if there no id and 'update where id = ?' if there is
	* returns itself
	* @return iDbConnectable
	*/
    public function save();
	/**
	* use new $this->_construct; for each element
	*
	* @param string $attribute
	* @param string $value
	* @return iDbConnectable[] $objects - возвращает массив объектов текущего класса
	*/    
    public function where($attribute, $value,$with=false);
    
}