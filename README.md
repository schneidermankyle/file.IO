# file.IO (Name in progress)
A stand alone class for accessing, manipulating and searching of files.

This class is still very early in development, this readme will be more or less a places for storing my notes at the moment. When finished this class will allow developers to quickly create or open various files in order to edit, search and replace functions and variables on the fly. Below is a quick example of where this project is going.

``` php
// Open file by passing in the path to file or 
// Create file by passing in the path to dir with the filename as second option
$file = new class('path to file');

// Some Configs //
$file->logging = 'ALL';
$file->logLocation = 'path';

if ($file->IsOpen) {
  // Some public member variables //
	echo ($file->fileSize);
	echo ($file->fileLength);
	echo ($file->type);
	echo ($file->path);

	// PHP/JS //
	$file->returnFunction('functionName');
	$file->returnVariable('variableName');
	$file->returnObject($object);
	$file->replaceFunction('functionName', $newFunctionText);
	$file->replaceVariable('variableName', $newVariableValue);
	$file->replaceObject($object);
	$file->insertFunction($funtion);
	$file->insertVariable($variable);
	$file->insertObject($variable);

	// HTML //
	$file->returnElement('element');
	$file->replaceElement('element', $occourance = (int)1);
	$file->insertElement($html, $where = 'body');

	// CSS //
	$file->returnRule('.rule');
	$file->replaceRule('.rule', $newRule);
	$file->insertRule('.rule', $rule);

	// Omni //
	$file->findWord('word', $occourance = (int)1);
	$file->replaceWord('word', $occourance = (int)1);
	$file->getContents();

  // More filetypes and functionality soon //
	
}

$file->close();
```
