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

private function $setUp($variable) {
    if ($variable) {
        $newVariable = 1;
    } else if ($testIsComplete) {
        $newVariable = 2;
    }
    
    if ($this->isTrue) {
        // We need more brackets!
        echo ('we are winning the test');
    }
}


?>