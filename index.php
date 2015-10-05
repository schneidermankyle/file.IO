<?php
require './classes/file.class.php';

$demo = new file('./temp/demo.php');

var_dump($demo->returnFunction('quiet'));

echo ('were are alive');

?>