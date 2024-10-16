<?php

$sunucu = "localhost";
$kullanici = "root";
$parola = "";
$vt = "e-ticaret_boutique";

$db = new mysqli($sunucu,$kullanici,$parola,$vt);
$db -> set_charset("utf8");


?>
