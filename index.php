<?php
        ob_start();
	session_start();
        
        require_once './config/constants.php';
        require_once 'toolbox.php';
        require_once 'site_builder.php';
        
        echo SiteBuilder::makeHeader();
        echo SiteBuilder::makeWrapper('User-Authentification');      
        	
	if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . APP_DIR .'/index.php');
	} else {
		$error = 'no_error';
	
		if (isset($_POST['login'])) {
                    
                        if (empty($_POST['name']) == FALSE AND empty($_POST['password']) == FALSE) {
                            $name = Toolbox::sanitizeString($_POST['name']);
                            $password = Toolbox::sanitizeString($_POST['password']);

                            try {
                                    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PWD);
                                    
                                    $SELECT = 'SELECT * 
                                                FROM `users` 
                                                WHERE `email` = "' . $name . '" AND `pwd` = "' . $password . '"';                                   
                                    $result = $pdo->query($SELECT);
                     
                                    if ($result->rowCount() == 1) {
                                            $user = $result->fetch(PDO::FETCH_ASSOC); // Assoziatives Array aus Object.
                                            
                                            $_SESSION['id'] = $user['id'];
                                            $_SESSION['user'] = $user['first_name'] . ' ' . 
                                                    $user['last_name'];
                                            
                                            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . 
                                                    APP_DIR . '/overview.php');
                                    } else {
                                            $error = 'login_failed';
                                    }
                            } catch(PDOException $pdo_e) {
                                    echo '<p>' . $pdo_e->getMessage() . '</p>';
                                    die('Excecution stopped.');
                            }

                            $pdo = null;
                        } else {
                            $error = 'parameter_missed';
                        }
		} 
	}
	
        if (isset($error) == TRUE AND $error == 'login_failed') {
            echo '<p>Authentication failed. Please try again.</p>';
        } else if (isset($error) == TRUE AND $error == 'parameter_missed') {
            echo '<p>Please make sure to enter your email address and your password.</p>';
        } else {
            echo '<p>Please enter your email address and password to log in!</p>';
        }
        
	echo '<form method="post" action="index.php">';
		echo '<div class="input_row">
                            <div class="input_label">Email: </div>
                            <input type="text" name="name" />
                      </div>';
		echo '<div class="input_row">
                        <div class="input_label">Password: </div>
                        <input type="password" name="password" />
                      </div>';
		echo '<div class="input_row">
                        <input type="submit" name="login" value="login" />
                      </div>';
	echo '</form>';        
        
        echo SiteBuilder::makeFooter();
        ob_flush();
?>