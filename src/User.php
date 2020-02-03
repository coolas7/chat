<?php

namespace VytautasUoga\Task;


class User extends DatabaseConnection
{

	public function insertUser(string $name, string $last_name, string $birth, string $email)
	{

		$mysqli = $this->connect();

		$exists = $this->checkUserExists($name, $last_name, $birth);

		if (!$exists) {
			$stmt = $mysqli->prepare("INSERT INTO users (name, last_name, birth, email) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssss', $name, $last_name, $birth, $email);
			
			if ($stmt->execute()) {

				return true;

			} else {

				return false;

			}

		} else {

			return $exists; // user id

		}

	}

	private function checkUserExists(string $name, string $last_name, string $birth)
	{

		$mysqli = $this->connect();
		$stmt = $mysqli->prepare("SELECT id FROM users WHERE name = ? AND last_name = ? AND birth = ?");
		$stmt->bind_param('sss', $name, $last_name, $birth);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows === 0) {

			return false;

		} else {

			while($row = $result->fetch_assoc()) {

			  $id = $row['id'];

			}

			return $id;

		}

	}

	public function getUserAge(string $user_birth)
	{

		$user_birth = strtotime($user_birth);
		$current_date = strtotime(date('Y-m-d'));

		$age = -1;

		while ($user_birth < $current_date) {

		  $age++;
		  $user_birth = strtotime("+1 year", $user_birth);

		}

		return $age;

	}

	public function getUser(int $user_id)
	{

		$sql = "SELECT * FROM users WHERE id = ".$user_id;
		$result = $this->connect()->query($sql);
		$user = $result->fetch_assoc();

		return $user;

	}

	public function getLastUserId()
	{

		$last_id = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
		$result = $this->connect()->query($last_id);
		$row = $result->fetch_assoc();
		$last_id = $row['id'];

		return $last_id;

	}

}