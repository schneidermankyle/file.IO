<?php
require './classes/file.class.php';

$demo = new file('./temp/demo.php');

var_dump( $demo->returnFunction('setUp') );



echo ('were are alive');

?>