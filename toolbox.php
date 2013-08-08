<?php
    class Toolbox {
        private $pdo;
        
        public function __construct($host, $database, $user, $pwd) {
            try {
                $this->pdo = 
                        new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $pwd);
            } catch (PDOException $exc) {
                $exc->getMessage();
                die('Trying to construct PDO-Object failed.');
            }
        } 
        
         public function makeCategoryOptions($selected) {
            $SELECT = 'SELECT `id`, `name`
                        FROM `categories`
                        ORDER BY `name`';
            $return = '';
                    
            $set = $this->pdo->query($SELECT);
            
            foreach ($set as $row) {
                if ($row['id'] == $selected) {
                    $return .= '<option selected value="' . 
                                $row['id'] . '">' . 
                                $row['name'] . 
                            '</option>' . "\n";
                } else {
                    $return .= '<option value="' . 
                                $row['id'] . '">' . 
                                $row['name'] . 
                            '</option>' . "\n";
                }
            }
            
            return $return;
        }
        
        public function getCertainRecord($table, $id) {
            $SELECT = 
                    'SELECT * 
                        FROM ' . $table .
                        ' WHERE id = ' . $id;
            
            try {
                $set = $this->pdo->query($SELECT);

                return $set->fetch(PDO::FETCH_BOTH);
            } catch (PDOException $exc) {
                $exc->getMessage();
                
                return 0;
            }
        }
        
        public function getSetOfRecords($query_string) {
            try {
                return $this->pdo->query($query_string);
            } catch (PDOException $pdo_exp) {
                $pdo_exp->getMessage();
                die('Exception during execution of database-query.');
            }
        }
        // Execute INSERT-, UPDATE-, DELETE-Queries to a
        //  database.
        //  Parameter: SQL-String to be executed.
        public function execAddEditDelQuery($sql_query) {
            try {               
                $count = $this->pdo->exec($sql_query);
                
                return $count;               
            } catch (PDOException $exc) {               
                return 0;
            }
        }
        
        static function sanitizeString($string) { 
            // 1. Entferne Leerzeichen am Anfang und am Ende.
            $return = trim($string);
            // 2. strip_tags(): Macht aus "will<b>y</b> & me ' OR 1=1" 
            //  "willy & me ' OR 1=1".
            $return = strip_tags($return);       
            // 3. htmlentities(): Macht aus dem Return von 1. 
            //  "willy &amp; me ' OR 1=1".
            $return = htmlentities($return);
            // 4. addslashes(): Macht aus dem Return
            //  von 2. "willy &amp; me \' OR 1=1".
            $return = addslashes($return);

            return $return;
        }
        
        static function checkAccessRight() {
        
            if (isset($_SESSION['id']) && 
                    !empty($_SESSION['id'])) {
                    // Result == Access granted!
                    return 1;
            } else {
                    // Result == Access denied!
                    return 0;
            }
        }
    }
?>
