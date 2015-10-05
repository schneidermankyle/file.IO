<?php

$variable = 'This is a test variable';

function $loud($incoming) {
	echo ($incoming);
}

function $quiet($incoming) {
	if (1+1=2) {
		$quiet = TRUE;
		echo ('This is true');
	}
}


?>