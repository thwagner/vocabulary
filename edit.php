<?php
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::makeSession();        
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('Editing');
    echo '<script src="./js/overview.js"></script>';
    echo SiteBuilder::makeNavi();
    echo $site_builder->makeActionIcons('view', '', 'del', $_GET['id']);
    
    if (isset($_POST['save']) == TRUE) {
   
        if (strlen($_POST['english']) >= 2 && is_numeric($_POST['english']) == FALSE &&
                strlen($_POST['german']) >= 2 && is_numeric($_POST['german']) == FALSE) {           
            $UPDATE = 
                    'UPDATE `words`
                        SET `english` = "' . $_POST['english'] . '", ' .
                        '`german` = "' . $_POST['german'] . '", ' .
                        '`cat_id` = ' . $_POST['cat_id'] . ', ' .
                        '`example` = "' . $_POST['example'] . '", ' .
                        '`note` = "' . $_POST['note'] .'" ' .
                        'WHERE `id` = ' . $_GET['id'];
    
           if (($toolbox->execAddEditDelQuery($UPDATE)) > 0) {
               echo '<p class="report_success">
                        Editing word has been successful.
                    </p>';
            } else {
               echo '<p class="report_fail">
                        No Editing has been applied because the form-values 
                            are identical to the old values.
                   </p>';
            }
        } else {
            echo '<p class="report_fail">
                        Please fill the boxes 
                            <i>English:</i> and <i>German:</i> 
                            with at least two chars both.
                   </p>';
        }
    }
    
    echo $site_builder->makeEditForm($_GET['id']);    
    echo SiteBuilder::makeFooter();
    
    ob_flush();
?>
