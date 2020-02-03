<?php 

namespace VytautasUoga\Task;

class FormValidator
{

	private $data;
	private $errors = [];
	private static $fields = ['name', 'last_name', 'email', 'birthdate', 'message'];

	public function __construct($post_data)
	{
		$this->data = $post_data;
	}

	public function validateForm()
	{

	    $this->validateName();
	    $this->validateLastname();
	    $this->validateEmail();
	    $this->validateBirth();
	    $this->validateMessage();

	    return $this->errors;

	}

	private function validateName()
	{

		$val = trim($this->data['name']);

	    if(empty($val)) {

	      $this->addError('name', 'įveskite vardą');

	    } else {

	    	if(!preg_match('/^[a-zA-Z0-9]{3,15}$/', $val)) {

	    		$this->addError('name','vardą turi sudaryti 3-15 raidės arba skaičiai');

	    	}

	    }

	}

	private function validateLastname()
	{
		
		$val = trim($this->data['last_name']);

	    if(empty($val)) {

	    	$this->addError('last_name', 'įveskite pavardę');

	    } else {

		    if(!preg_match('/^[a-zA-Z0-9]{3,15}$/', $val)) {

		    	$this->addError('last_name','pavardę turi sudaryti 3-15 raidės arba skaičiai');

		    }

	    }

	}

	private function validateEmail()
	{

		$val = trim($this->data['email']);

	
	    if(!empty($val) && !filter_var($val, FILTER_VALIDATE_EMAIL)) {

	    	$this->addError('email', 'neteisingai įvestas el.pašto adresas');

	    }
	    
	}

	private function validateBirth()
	{
		
		$val = trim($this->data['birthdate']);

	    if(empty($val)) {

	    	$this->addError('birthdate', 'įveskite savo gimimo datą');

	    }

	}

	private function validateMessage()
	{

		$val = $this->data['message'];

	    if(empty($val)) {

	      $this->addError('message', 'žinutė negali būti tuščia');

	    } else {

	    	if(!preg_match('/^[a-zA-Z0-9 .:()?!.,]{2,255}$/', $val)) {

	    		$this->addError('message','žinutę turi sudaryti 2-255 simboliai');

	    	}

	    }

	}

	private function addError($key, $val)
	{

		$this->errors[$key] = $val;

	}
}