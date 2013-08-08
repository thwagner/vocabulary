<?php
    ob_start();
    session_start();
        
    require_once './config/constants.php';
    require_once 'toolbox.php';
    require_once 'site_builder.php';

    echo SiteBuilder::makeHeader();

    if (Toolbox::checkAccessRight() == 0) {
        die('Access denied!');
    }

    if (isset($_GET['logout'])) {
            session_destroy();
            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . APP_DIR . '/index.php');
    }
?>
