<?php
    ob_start();
    session_start();
        
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::initPage(); 
    echo '<script src="./js/search.js"></script>';
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('Search for words');
    echo SiteBuilder::makeNavi('search');

            echo '<pre>';
                print_r($_GET);
            echo '</pre>';
            
    echo SiteBuilder::makeFooter();
    
    ob_flush();
?>
      