<?php
    ob_start();
    session_start();
    
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    
    echo '<!DOCTYPE html><html><header><title></title></header>';
    
    if (Toolbox::checkAccessRight() == 0) {
            die('Access denied!');
    }

    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);  
    $DELETE = 
            'DELETE FROM `words`
                WHERE `id` =' . $_GET['id'];

    $toolbox->execAddEditDelQuery($DELETE);
    
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . APP_DIR . '/overview.php');
    
    echo '</body></html>';
    
    $toolbox->destroyPdo();
    ob_flush();
?>
