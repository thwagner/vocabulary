<?php
    ob_start();
    require_once 'header.php';             

    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    $site_builder = new SiteBuilder();

    $SELECT = 'SELECT `words`.`id`, `english`, `german`, `name` 
                    FROM `words` JOIN `categories`
                    ON `words`.`cat_id` = `categories`.`id`
                    ORDER BY `english`';
    $set = $toolbox->getSetOfRecords($SELECT);

    echo SiteBuilder::makeWrapper('Words-Overview');
    echo '<script src="./js/overview.js"></script>';
    echo SiteBuilder::makeNavi('overview');

    echo $site_builder->makeOverviewTable($set);

    echo SiteBuilder::makeFooter();

    ob_flush();
?>