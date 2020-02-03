<?php

require '../vendor/autoload.php';

use VytautasUoga\Task\User;
use VytautasUoga\Task\Message;

// ajax pagination
if (isset($_GET["page1"])) { 

	$current_page  = $_GET["page1"];

    $messages_obj = new Message(); 
    $page_messages = $messages_obj->getPageMessages($current_page);

	foreach ($page_messages as $message) : 
		$users = new User();
	 	$user = $users->getUser($message['user_id']);
?>
        <li>
            <span><?= $message['date_add']; ?></span>

            <?php if(!empty($user['email'])) : ?>
            	<a href="mailto:<?= $user['email']; ?>"><?= $user['name']; ?></a>,
        	<?php else: 
        		echo $user['name'].',';
        	endif; ?>
            <?= $users->getUserAge($user['birth']); ?> m.<br/>
            <?= $message['message']; ?>
        </li>

	<?php endforeach;

}