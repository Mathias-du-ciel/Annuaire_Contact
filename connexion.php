
<?php
try {
    $cnt=new PDO('mysql:host=localhost;dbname=grud','root','');
} catch (Exception $e) {
   die ('Erreur de connexion');
}

 ?>