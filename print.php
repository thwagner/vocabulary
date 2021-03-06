<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="./css/print_sheet.css" type="text/css" rel="stylesheet" />
        <title>Print-Screen</title>
    </head>
    <body>
        <?php
            ob_start();            

            require_once './config/constants.php';
            require_once './lib/toolbox.php';
  
            echo '<script src="./js/search.js"></script>';
            
            if (isset($_SESSION['select']) == TRUE && empty($_SESSION['select']) == FALSE) {
                $sql = $_SESSION['select'] . ' ORDER BY `english`';
            } else {
                die('Session-Variable "select" is not set. Execution stopped.');
            }
            
            $toolbox = new Toolbox(HOST, DATABASE, USER, PWD);
            $set = $toolbox->getSetOfRecords($sql);
            // START - main
            echo '<div id="main">';
                echo '<p><span class="description">Creation date &amp; time: </span><i>' . 
                        date('d.m.Y, H:i') . '</i></p>';
                echo '<table class="print_table" border="0">';
                    echo '<tr class="tr_head">';
                        echo '<td></td>
                                <td class="content">English</td>
                                <td class="content">German</td>
                                <td class="content">Category</td>
                                <td class="content">Example</td>
                                <td class="content">Note</td>';
                    echo '</tr>';

                    while ($row = $set->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                            echo '<td> - </td>';
                            echo '<td class="content">' . $row['english'] . '</td>';
                            echo '<td class="content">' . $row['german'] . '</td>';
                            echo '<td class="content">' . $row['name'] . '</td>';
                            echo '<td class="content">' . $row['example'] . '</td>';
                            echo '<td class="content">' . $row['note'] . '</td>';
                        echo '</tr>';
                    }   
                echo '</table>';
                
                echo '<div id="foot">' . $_SERVER['SERVER_NAME'] . ' - Vocabulary book by Michael Zech - 2013</div>';
            // END - main
            echo '</div>';
            
            $toolbox->destroyPdo();
            ob_flush();
        ?>
    </body>
</html>
