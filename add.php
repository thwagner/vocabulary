<?php
    ob_start();
    session_start();
        
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::initPage();  
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('Add a new word');
    echo SiteBuilder::makeNavi('add');
 
    if (isset($_POST['save']) == TRUE) {
        $success_report = FALSE;
  
        if (strlen($_POST['english']) >= 2 && is_numeric($_POST['english']) == FALSE &&
                strlen($_POST['german']) >= 2 && is_numeric($_POST['german']) == FALSE) {

            $INSERT = 
                    'INSERT INTO `words`
                        (`english`, `german`, `cat_id`, `example`, `note`) 
                        VALUES ("' .
                            $_POST['english'] . '", "' .
                            $_POST['german'] . '", ' .
                            $_POST['cat_id'] . ', "' .
                            $_POST['example'] . '", "' .
                            $_POST['note'] . '"' .
                        ')';
   
           if (($toolbox->execAddEditDelQuery($INSERT)) == 0) {
                echo '<p class="report_fail">
                         Adding word has been failed.
                    </p>';
           } else {
               $success_report = TRUE;
           }
        }
        
        if ($success_report == TRUE) {
            echo '<div id="report" class="report_success">Word has been added.</div>';
        }
    }
    
    echo '<div id="report"></div>';
    
    echo $site_builder->makeEditForm(0);
    
    echo SiteBuilder::makeFooter();
    
    ob_flush();
?>
