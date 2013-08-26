<?php
    ob_start();
    session_start();
        
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::initPage();     
    
    if (isset($_GET['id']) == FALSE && empty($_GET['id']) == TRUE) {
        die('No id-parameter has been passed.');
    }
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('View word in detail');
    echo SiteBuilder::makeNavi();     
    echo $site_builder->makeActionIcons('', 'edit', 'del', $_GET['id']);
 
    $word = $toolbox->getCertainRecord('words', $_GET['id']);
    
    echo '<table class="table_view" border="0">';
        echo '<tr>';
            echo '<td class="td_view_desc" ><strong>English:</strong></td><td>' . $word['english'] . '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td class="td_view_desc" ><strong>German:</strong></td><td>' . $word['german'] . '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td class="td_view_desc" ><strong>Example:</strong></td><td>' . $word['example'] . '</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td class="td_view_desc" ><strong>Note:</strong></td><td>' . $word['note'] . '</td>';
        echo '</tr>';
    echo '</table>';
    
    echo SiteBuilder::makeFooter();
    
    $toolbox->destroyPdo();
    ob_flush();
?>
