<?php
    exec('mysqldump -u root vocab > vocab.sql');
    exec('mysql -h mysql12.1blu.de -u s140986_1919031 -psksWMS#16 db140986x1919031 < vocab.sql');
    echo '<p>Live-System has been updated.</p>';
?>
