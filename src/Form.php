<?php

use VytautasUoga\Task\User;
use VytautasUoga\Task\Message;

namespace VytautasUoga\Task;

class Form
{

	private $data;
	
	public function __construct($post_data)
	{

		$this->data = $post_data;

	}

	public function insertFormData()
	{

		$name = trim($this->data['name']);
		$last_name = trim($this->data['last_name']);
		$birth = trim($this->data['birthdate']);
		$message = trim($this->data['message']);
		$email = trim($this->data['email']);

		// insert user data
		$user = new User();
		$success = $user->insertUser($name, $last_name, $birth, $email);

		if ($success) {
			// check if user already exists
			if (is_numeric($success)) {

				$user_id = $success;

			} else {

				$user_id = $user->getLastUserId();

			}

			$age = $user->getUserAge($birth);
			$this->data['age'] = $age;

			// insert user message
			$messages = new Message();
			$success = $messages->insertMessage($user_id, $message);

			if (!$success) {

				echo "Nepavyko išsaugoti žinutės";
				die();

			}

		} else {

			echo "Nepavyko išsaugoti jūsų duomenų";
			die();

		}

    	return json_encode($this->data);

	}

}
