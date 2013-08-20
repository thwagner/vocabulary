<?php
    require_once './config/constants.php';
    require_once './lib/toolbox.php';
    require_once './lib/site_builder.php';
    
    SiteBuilder::makeSession();    
    
    $site_builder = new SiteBuilder(HOST, DATABASE, USER, PWD);
    $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
    
    echo SiteBuilder::makeWrapper('Search for words');
    echo '<script src="./js/overview.js"></script>';
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
                
        echo '<table style="margin-top: 15px;">';
            echo '<tr>';
                echo '<th>English</th><th>German</th><th>Category</th><th>Options</th>';
            echo '</tr>';

            foreach ($set as $row) {
                echo '<tr>' . 
                        '<td class="entry">' . $row['english'] . '</td>
                         <td class="entry">' . $row['german'] . '</td>
                         <td class="entry">' . $row['name'] . '</td>
                         <td>
                            <a href="view.php?id=' . $row['id'] . '">
                                <img src="images/view.png" title="View word in detail." 
                                    class="function_icon" alt="view" />
                            </a>
                            <a href="edit.php?id=' . $row['id'] . '">
                                <img src="images/pencil.png" title="Edit this word." 
                                    class="function_icon" alt="edit" />
                            </a>
                            <a href="delete.php?id=' . $row['id'] . '" id="del_word" 
                                onclick="return askConfirmBeforeDelete();">
                                <img src="images/delete.png" title="Delete this word." 
                                    class="function_icon" alt="delete" />
                            </a>
                          </td>  
                     </tr>';
            }

        echo '</table>';
    }
    
    echo SiteBuilder::makeFooter();
    
    ob_flush();
?>
