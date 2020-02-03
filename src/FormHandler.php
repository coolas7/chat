<?php 
require '../vendor/autoload.php';

use VytautasUoga\Task\FormValidator;
use VytautasUoga\Task\Form;

//check if supports javascript for ajax form handling
session_start();
$_SESSION['js'] = true;

if ($_SESSION['js'] == true && isset($_POST['name'])) {

	$validation = new FormValidator($_POST);
    $errors = $validation->validateForm();

    if(empty($errors)) {

	    $form = new Form($_POST);
	    $data = $form->insertFormData();

		echo $data;

	} else {

		$error['error'] = $errors;

		echo json_encode($error);

	}

} 
