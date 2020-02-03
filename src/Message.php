<?php

namespace VytautasUoga\Task;

class Message extends DatabaseConnection
{

	const MESSAGES_PER_PAGE = 5;


	protected function getAllMessages()
	{

		$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT 30";

		$result = $this->connect()->query($sql);
		$numRows = $result->num_rows;

		if ($numRows > 0) {

			while ($row = $result->fetch_assoc()) {

				$data[] = $row;

			}

			return $data;

		}
	}

	public function insertMessage(int $user_id, string $message)
	{

		$mysqli = $this->connect();
		$stmt = $mysqli->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
		$stmt->bind_param('is', $user_id, $message);

		if ($stmt->execute()) {

			return true;

		} else {

			return false;

		}

	}

	public function getNumberOfPages()
	{
		$datas = $this->getAllMessages();
		$datas = count($datas);

		$number_of_pages = ceil($datas/self::MESSAGES_PER_PAGE);

		return $number_of_pages;

	}

	public function getPageMessages(int $current_page)
	{

		$mysqli = $this->connect();
		// $current_page = $mysqli->real_escape_string($current_page);
		$page_first_message = ($current_page-1)*5;

		$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT ". $page_first_message .",5";

		$result = $mysqli->query($sql);
		$numRows = $result->num_rows;

		if ($numRows > 0) {

			while ($row = $result->fetch_assoc()) {

				$messages[] = $row;

			}

			return $messages;

		}

	}

}