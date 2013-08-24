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
    
    if (isset($_GET['search_string']) == TRUE && 
            empty($_GET['search_string']) == FALSE) {
        $search_string = Toolbox::sanitizeString($_GET['search_string']);
    } else {
        $search_string = '';
    }
    
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get">';
        echo '<div class="search_opt">
                <input type="text" name="search_string" id="search_string" 
                value="' . $search_string . '" class="search_value" ';
                if (isset($_GET['start']) == TRUE && 
                        empty($_GET['start']) == FALSE) {
                    echo 'disabled="disabled"';
                }
        echo ' />';
        if (isset($_GET['start']) == FALSE && empty($_GET['start']) == TRUE) {
            echo '<input type="submit" name="start" id="start" value="Start search" 
                    class="search_value" />
                </div>';           
        } else {
            echo '&nbsp;<a class="search_value" href="' . $_SERVER['PHP_SELF'] . '">
                    Reset search form
                    </a>
                    <a href="./print.php?sql=' . $_SESSION['select'] . '"
                        style="margin-left:330px;" >
                        <img src="./images/printer.png" alt="printer_img" 
                         title="Click to get a print-optimized layout of this table!" />
                    </a>              
                </div>';
        }        
        echo '<div class="search_opt">
                <input type="radio" name="language" value="english" '; 
                setRadiobutton('english', 'checked="checked"');
        echo    ' class="search_value" />English';
        echo '<input type="radio" name="language" value="german"';
            setRadiobutton('german', '');
        echo ' class="search_value" />German';
        echo  '</div>';  
        // Das automatische Anlegen eines PHP-Arrays setzt voraus, dass das der 
        //  Value des Attribut "name" mit eckigen Klammern endet.
        echo '<div class="search_opt">
              <input type="checkbox" name="category[]" value="2" 
                class="search_value cat_box" id="business" ';
                setCheckbox(2);
        echo ' />Business';
        echo '<input type="checkbox" name="category[]" value="4" 
                class="search_value cat_box" id="general" ';
                setCheckbox(4);
        echo '/>General';
        echo '<input type="checkbox" name="category[]" value="3" 
                class="search_value cat_box" id="informal" ';
                setCheckbox(3);
        echo ' />Informal';
        echo '<input type="checkbox" name="category[]" value="1" 
                class="search_value cat_box" id="technology" ';
                setCheckbox(1);
        echo ' />Technology'; 
        echo '</div>';       
    echo '</form>';
 
    if (isset($_GET['start']) == TRUE && empty($_GET['start']) == FALSE) { 
        if (isset($_GET['category']) == FALSE) {
            die('ERROR: Mandatory variable category not assigned.');
        }
        // START - Kriterien-String fuer die WHERE-Condition des SQL-Statements
        //  zusammenbauen.
        $crits = '';
        $amount_categories = count($_GET['category']);
               
        if (isset($_GET['search_string'])== TRUE && 
                empty($_GET['search_string']) == FALSE) {
            $crits .= ' `' . $_GET['language'] . 
                    '` LIKE "%' . $_GET['search_string'] . '%"';
        }
        
        if ($amount_categories != 4) {
           if ($crits != '') {            
               $crits .= ' AND (';
           } else {
               $crits .= ' (';
           }
           
           for ($i = 0; $i < $amount_categories; $i++) {
               if ($i > 0) {
                   $crits .= ' OR ';
               }
               
               $crits .= '`cat_id` = ' . $_GET['category'][$i];
           }  
           
           $crits .= ')';
        }
        
        // ENDE - Kriterien-String
        $SELECT = 'SELECT `words`.`id`, `english`, `german`, `name`, `note`, `example` 
                            FROM `words` JOIN `categories`
                            ON `words`.`cat_id` = `categories`.`id`'; 
        if ($crits != '') {
            $SELECT .= ' WHERE ' . $crits;
        }       
     
        $_SESSION['select'] = $SELECT;
        $set = $toolbox->getSetOfRecords($SELECT);
        
        echo $site_builder->makeOverviewTable($set);
    }
    
    echo SiteBuilder::makeFooter();
    
    ob_flush();
    
    function setRadiobutton($language, $else='') {
        if (isset($_GET['start']) == TRUE && empty($_GET['start']) == FALSE) {
            
            echo 'disabled="disabled"'; 
            
            if (isset($_GET['language']) == TRUE && 
                    $_GET['language'] == $language) {
                echo 'checked="checked"';
            }                                    
        } else {
            echo $else; // Beim Laden English voreingestellt.
        }
    }
    
    function setCheckbox($cat_id) {
        if (isset($_GET['start']) == TRUE && empty($_GET['start']) == FALSE) {
            
            echo 'disabled="disabled"'; 
            
            if (isset($_GET['category']) == TRUE && 
                    in_array($cat_id, $_GET['category']) == TRUE) {
                echo 'checked="checked"';
            }  else {
                echo '';
            }                                  
        } else {
            echo 'checked="checked"';
        }
    }       
?>
