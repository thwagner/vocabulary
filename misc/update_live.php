<!--
    Live-System (bei 1blu.de) mit den lokalen Daten ueberschreiben.
-->
<?php
//    Wird das PHP-Skript nicht ueber das HTML-Formular (update_live.html) 
//            aufgerufen, so erfolgt ein Abbruch.
    if (isset($_POST['submit_update']) == TRUE && 
            empty($_POST['submit_update']) == FALSE) {
        // MySQL-Dump erzeugen.
        exec('mysqldump -u root vocab > vocab.sql');
        // MySQL-Dump auf dem Live-System einspielen. 
        //  KEINEN Unbruch in die Zeile einfuegen!
        exec('mysql -h mysql12.1blu.de -u s140986_1919031 -psksWMS#16 db140986x1919031 < vocab.sql');
        // Abschliessende Erfolgsmeldung.
        echo '<p>Live-System has been updated.</p>';
    } else {
        echo '<p>Script stopped because of illegal use.</p>';
    }
?>
