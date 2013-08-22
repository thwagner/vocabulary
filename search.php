<?php
    ob_start();
    session_start();
        
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::initPage();    
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('Search for words');
    echo SiteBuilder::makeNavi('search');
    
    if (isset($_GET['search_string']) == TRUE && 
            empty($_GET['search_string']) == FALSE) {
        $search_string = Toolbox::sanitizeString($_GET['search_string']);
    } else {
        $search_string = '';
    }
    
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get">';
        echo '<input type="text" name="search_string" id="search_string" 
            value="' . $search_string . '" />&nbsp;';
        if (isset($_GET['start']) == FALSE && empty($_GET['start']) == TRUE) {
            echo '<input type="submit" name="start" id="start" value="Start search" />&nbsp;';
        } else {
            echo '&nbsp;<a href="' . $_SERVER['PHP_SELF'] . '">
                    Reset search form
                </a>';
        }
    echo '</form>';
  
    if (isset($_GET['start']) == TRUE && empty($_GET['start']) == FALSE) {             
        $SELECT = 'SELECT `words`.`id`, `english`, `german`, `name` 
                            FROM `words` JOIN `categories`
                            ON `words`.`cat_id` = `categories`.`id` 
                            WHERE `english` LIKE "%' . $search_string . '%" OR
                                `german` LIKE "%' . $search_string . '%" 
                            ORDER BY `english`';
        $_SESSION['select'] = $SELECT;
        $set = $toolbox->getSetOfRecords($SELECT);
        
        echo $site_builder->makeOverviewTable($set);
    }
    
    echo SiteBuilder::makeFooter();
    
    ob_flush();
?>
