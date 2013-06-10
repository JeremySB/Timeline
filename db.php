<?php

try {
     $db = new PDO('mysql:host=localhost;dbname=ncfheorg_tline', 'ncfheorg_tline', '7H#&SiS71!0M7Oa');
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
     echo 'ERROR: ' . $e->getMessage();
}
?>