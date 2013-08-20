<?php
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::makeSession(); 

    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    $site_builder = new SiteBuilder();

    $SELECT = 'SELECT `words`.`id`, `english`, `german`, `name` 
                    FROM `words` JOIN `categories`
                    ON `words`.`cat_id` = `categories`.`id`
                    ORDER BY `english`';
    $set = $toolbox->getSetOfRecords($SELECT);

    echo SiteBuilder::makeWrapper('Words-Overview');
    echo SiteBuilder::makeNavi('overview');

    echo $site_builder->makeOverviewTable($set);
    echo SiteBuilder::makeFooter();

    ob_flush();
?>