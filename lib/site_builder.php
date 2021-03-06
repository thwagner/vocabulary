<?php
    require_once './config/constants.php';

    class SiteBuilder {
        private $toolbox;
        
        public function __construct() {
            $this->toolbox = 
                new Toolbox(HOST, DATABASE, USER, PWD);
        }   
        // Start output-buffering, starts a session, checks access right.
        //  Destroys the current session, if the GET-Variable logout is set.
        static function initPage() {     
            echo SiteBuilder::makeHeader();

            if (Toolbox::checkAccessRight() == 0) {
                die('Access denied!');
            }

            if (isset($_GET['logout'])) {
                    session_destroy();
                    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . APP_DIR . '/index.php');
            }
        }
        
        // Creates a HTML-Header.
        static function makeHeader() {
            $header = <<<HEADER
                    <!DOCTYPE html>
                    <html>

                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>%s</title>
                        <link type="text/css" rel="stylesheet" href="./css/screen.css" />                   
                        <script src="./js/jquery.js"></script>
                        <script src="./js/jfunctions.js"></script>
                        <script src="./js/functions.js"></script>
                    </head>                  
HEADER;

            return sprintf($header, APP_TITLE);
        }
        
        // Create first part of body.
        static function makeWrapper($sec_headline) {
            $wrapper = '<body>
                <div id="wrapper">';
            
            if (isset($_SESSION['user']) == TRUE && 
                    empty($_SESSION['user']) == FALSE) {
                $wrapper .= 
                        '<div id="welcome">Hello ' . 
                        $_SESSION['user'] . '! You are logged in.</div>';
            } 
        
            $wrapper .= '<h1>' . APP_TITLE . '</h1>'; 
            $wrapper .= '<div class="sec_headline"><strong>' . $sec_headline .'</strong></div>';       
            
            return $wrapper;
        }

        // Creates a navigation-ribbon.
        static function makeNavi($active='overview') {
            $registers = 
                array(
                    array(
                        "id" => "overview", 
                        "file" => "overview.php", 
                        "title" => "Words-overview"
                    ), 
                    array(
                        "id" => "search", 
                        "file" => "search.php", 
                        "title" => "Search single words"
                    ), 
                    array(
                        "id" => "add", 
                        "file" => "add.php", 
                        "title" =>" Add new word"
                    ), 
                    array(
                        "id" => "log_out", 
                        "file" => "overview.php?logout=1", 
                        "title" => "Log out"
                    )
                );                                    

            $navi = '<div id="navi">';
  
            foreach ($registers as $ct_item) {
                $navi .=  '<div id="' . $ct_item["id"] . '" class="navi_cell" >
                            <a href="' . $ct_item["file"];
                            if ($ct_item["id"] == $active) {                         
                                $navi .= '" id="active_page">';
                            } else {                           
                                $navi .= '">';  
                            }
                $navi .=     $ct_item["title"] . '</a></div>';
            }
            
            $navi .= '</div>';
            
            return $navi;
        }
        
        // Erstellt eine Vokabel-Tabelle.
        // Parameter: Ergebnis einer SELECT-Query.
        // Return: String, genauer eine HTML-Tabelle.
        public function makeOverviewTable($set) {
            $return = '';
            $i = 1;
            
            $return .= '<table class="t_overview" id="overview_table">';
            $return .= '<thead>
                            <tr>';
                    $return .= '<th class="overview" id="eng">
                                    <span title="Click table-header for changing the order">English</span> 
                                </th>
                                <th class="overview" id="germ">
                                    <span title="Click table-header for changing the order">German </span>
                                    <img src="" class="th_img" />
                                </th>
                                <th class="overview" id="cat">
                                    <span title="Click table-header for changing the order">Category </span>
                                    <img src="" class="th_img" />
                                </th>
                                <th class="overview" id="opt">
                                    Options
                                    <img src="" class="th_img" />
                                </th>';
                $return .= '</tr>
                    </thead>
                    <tbody>';

            foreach ($set as $row) {           
                    $return .= '<tr>';
                        $return .= '<td class="entry">' . $row['english'] . '</td>
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

            $return .= '</tbody>
                </table>';
            
            return $return;
        }
        
        // Erzeugt eine Reihe mit image-Hyperlinks.
        // Parameter:
        // 1. String: Wenn gesetzt, wird ein Hyperlink auf View gesetzt.
        // 2. String: Wenn gesetzt, wird ein Hyperlink auf Edit gesetzt.
        // 3. String: Wenn gesetzt, wird ein Hyperlink auf Delete gesetzt.
        // 4. Int: Die Id des Record, der durch View, Edit, Delete aufgerufen
        //  werden soll. Wird kein Wert uebergeben, so wird der Parameter mit 
        //  0 initialisiert.
        // Return:
        // String (HTML-Code)
        public function makeActionIcons($view, $edit, $delete, $record_id = 0) {         
            $image_dir = 'images';
            
            $back_attr = array(
                'href' => 'javascript:void window.history.back();',
                'src' =>  $image_dir . '/back.png',
                'title' => 'Back to previous page.',
                'alt' => 'back'
            );
            
            $view_attr = array(
                'href' => 'view.php?id=' . $record_id,
                'src' =>  $image_dir . '/view.png',
                'title' => 'View word in detail.',
                'alt' => 'view'
            );
            
            $edit_attr = array(
                'href' => 'edit.php?id=' . $record_id,
                'src' => $image_dir . '/pencil.png',
                'title' => 'Edit this word.',
                'alt' => 'edit'
            );
            
            $delete_attr = array(
                'href' => 'delete.php?id=' . $record_id,
                'src' => $image_dir . '/delete.png',
                'title' => 'Delete this word.',
                'alt' => 'delete'
            );
            
            $attr = array(
                $back_attr,
                $view_attr,
                $edit_attr,
                $delete_attr
            );
            
            $return = '<div class="first_item">&nbsp;</div>';
            $return .= $this->makeActionIconDiv($attr[0]['href'], 
                                $attr[0]['src'], $attr[0]['title'], $attr[0]['alt'], 'back');
   
            if (isset($view) == TRUE && empty($view) == FALSE) {
                $return .= $this->makeActionIconDiv($attr[1]['href'], 
                                $attr[1]['src'], $attr[1]['title'], $attr[1]['alt']);
            }
            
            if (isset($edit) == TRUE && empty($edit) == FALSE) {
                $return .= $this->makeActionIconDiv($attr[2]['href'], 
                                $attr[2]['src'], $attr[2]['title'], $attr[2]['alt']);
            }
            
            if (isset($delete) == TRUE && empty($delete) == FALSE) {
                $return .= $this->makeActionIconDiv($attr[3]['href'], 
                                $attr[3]['src'], $attr[3]['title'], $attr[3]['alt'], 
                                'del_word', 
                                'onclick=" return askConfirmBeforeDelete();"');
            }
            
            $return .= '<br />';
            
            return $return;
        }
        
        // Hilfsfunktion von makeActionIcon()
        private function makeActionIconDiv($href, $scr, $title, $alt, $id='', $onclick='') {
            return '<div class="icon_item">
                            <a class="navi_a" id="' . $id . '" href="' . $href . '" ' . $onclick . '>
                                <img src="' . $scr . '" title="' . $title . '" 
                                    class="function_icon" alt="' . $alt . '" />
                            </a>
                       </div>';
        }

        public function makeEditForm($id) {
            echo '<script src="./js/add.js"></script>';
            
            if (($word = $this->toolbox->getCertainRecord("words", $id)) == 0 &&
                    $id != 0) {
                die('Database-Query failed.');
            } else {  
                
                if ($id == 0) {
                    $word = array(
                        'id'        => 0,
                        'english'   => '',
                        'german'    => '',
                        'cat_id'    => 4,
                        'example'   => '',
                        'note'      => ''
                    );
                }
                              
                $form = '<form action="' . $_SERVER['PHP_SELF'] . 
                        '?id=' . $word['id'] . '" method="post" id="form_add" >';
                    $form .= '<div class="input_row">
                                <div class="input_label">English: </div>
                                <input type="text" name="english" id="english" value="' . 
                                $word['english'] . '" class="text_for_word" />
                             </div>';
                    $form .= '<div class="input_row">
                                <div class="input_label">German: </div>
                                <input type="text" name="german" id="german" value="' .
                                $word['german'] . '" class="text_for_word" />
                            </div>';
                    $form .= '<div class="input_row">                         
                                <div class="input_label">Category: </div>
                                <select name="cat_id">' .
                                    $this->toolbox->makeCategoryOptions($word['cat_id']) .                              
                                '</select>
                            </div>';
                    $form .= '<div class="input_row">
                                <div class="input_label">Example: </div>
                                <textarea rows="2" cols="78" name="example" id="example" >' .
                                    $word['example'] .
                                '</textarea>
                            </div>';
                    $form .= '<div class="input_row">
                                <div class="input_label">Note: </div>
                                <textarea rows="2" cols="78" name="note" id="note" >' .
                                    $word['note'] .
                                '</textarea>
                            </div>';
                    $form .= '<div class="input_row">
                                <input type="submit" name="save" id="save" 
                                    value="save current content" style="margin-top: 10px;" />
                            </div>';
                $form .= '</form>';

                return $form;
            }
        }
        
        // Creates a HTML-Footer.
        static function makeFooter() {
            $footer = <<<FOOTER
                    <div id="footer">Michael Zech - %s</div>
                    <!-- Wrapper - END -->
                    </div> 
                    </body>
                </html>
FOOTER;
        
            return sprintf($footer, TIME_SPACE_DEVELOPMENT);
        }
    }
?>
