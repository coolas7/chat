
<?php 

require __DIR__ . '/vendor/autoload.php'; 

use VytautasUoga\Task\User;
use VytautasUoga\Task\Message;
use VytautasUoga\Task\Form;
use VytautasUoga\Task\FormValidator;

// check and insert form data
if(isset($_POST['submit'])) {

    $validation = new FormValidator($_POST);
    $errors = $validation->validateForm();

    if(empty($errors)) {

        $form = new Form($_POST);
        $form->insertFormData();

    }
}

// php pagination, detect page
if(!isset($_GET['page'])) {
    $current_page = 1;
} else {
    $current_page = $_GET['page'];
}


?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Žinutės</title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css" />
    </head>
    <body>
        <div id="wrapper">
            <h1>Jūsų žinutės</h1>
            <!-- form -->
            <form action="index.php"  method="post" id="form">
                <p <?= (isset($errors['name'])) ? 'class="err"' : '' ?>>
                    <label for="name">Vardas *</label><br/>
                	 <?= (isset($errors['name'])) ? $errors['name'].'<br/>' : '<span class="error"></span><br/>'; ?>
                    <input id="name" type="text" name="name" 
                    value="<?= htmlspecialchars($_POST['name']) ?? '' ?>" />
                </p>
                <p <?= (isset($errors['last_name'])) ? 'class="err"' : '' ?>>
                    <label for="last_name">Pavardė *</label><br/>
                     <?= (isset($errors['last_name'])) ? $errors['last_name'].'<br/>' : '<span class="error"></span><br/>' ?>
                    <input 
                        id="last_name" 
                        type="text" 
                        name="last_name" 
                        value="<?= htmlspecialchars($_POST['last_name']) ?? '' ?>" 
                    />
                </p>
                <p <?= (isset($errors['birthdate'])) ? 'class="err"' : '' ?>>
                    <label for="birthdate">Gimimo data *</label><br/>
                     <?= (isset($errors['birthdate'])) ? $errors['birthdate'].'<br/>' : '<span class="error"></span><br/>' ?>
                    <input 
                        id="birthdate"
                        type="date"
                        name="birthdate"
                        min="1900-01-01" 
                        max="<?= date_create('now')->modify('-1 day')->format('Y-m-d');?>" 
                        value="<?= htmlspecialchars($_POST['birthdate']) ?? '' ?>" 
                    />
                </p>
                <p <?= (isset($errors['email'])) ? 'class="err"' : '' ?>>
                    <label for="email">El.pašto adresas</label><br/>
                     <?= (isset($errors['email'])) ? $errors['email'].'<br/>' : '<span class="error"></span><br/>' ?>
                    <input id="email" type="text" name="email" value="<?= htmlspecialchars($_POST['email']) ?? '' ?>" />
                </p>
                <p <?= (isset($errors['message'])) ? 'class="err"' : '' ?>>
                    <label for="message">Jūsų žinutė *</label><br/>
                     <?= (isset($errors['message'])) ? $errors['message'].'<br/>' : '<span class="error"></span><br/>' ?>
                    <textarea id="message" name="message" value="<?= htmlspecialchars($_POST['message']) ?? '' ?>"></textarea>
                </p>
                <p>
                    <span>* - privalomi laukai</span>
                    <input type="submit" value="Skelbti" name="submit" />
                    <img id="loader" style="display: none;" src="img/ajax-loader.gif" alt="" />
                </p>
            </form>
            <!-- messages container -->
            <?php 
            	$messages_obj = new Message(); 
                $total_pages = $messages_obj->getNumberOfPages();
                $page_messages = $messages_obj->getPageMessages($current_page);
            ?>

            <ul id="messages-container">

            <?php if (count($page_messages) > 0) :

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

            		<?php endforeach; ?>

                <?php else : ?>

                    <li style="text-align: center;">Žinučių nėra!</li>

                <?php endif; ?>
            </ul>
            <!-- pages numbers -->
            <div style="text-align: center;">

            <?php for ($page=1; $page <= $total_pages; $page++) : ?>

                    <a 
                        href="index.php?page=<?= $page ?>" 
                        class="page-link <?= ($page == $current_page) ? 'active' : '' ?>" 
                        data-id="<?= $page ?>"
                    >
                        <?= $page ?>
                    </a>

            <?php endfor; ?>

            </div>
        </div>
        
        <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
