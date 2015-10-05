<?php
/*
	Copyright (c) 2015 Kyle Schneiderman, http://kyleschneiderman.com

	Permission is hereby granted, free of charge, to any person obtaining
	a copy of this software and associated documentation files (the
	"Software"), to deal in the Software without restriction, including
	without limitation the rights to use, copy, modify, merge, publish,
	distribute, sublicense, and/or sell copies of the Software, and to
	permit persons to whom the Software is furnished to do so, subject to
	the following conditions:

	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
	OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
	WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class file
{
	public $logging = TRUE;
	public $mode = 'development';
	public $logFile = __DIR__;
	public $isOpen = FALSE;
	public $fileSize;
	public $fileLength;
	public $type;
	public $path;
	public $file;

	private $contentArray;
	private $contentString;
	private $errors = array(
		100 => 'There was some sort of error opening the file specified.',
		101 => 'There was an error saving file to string, please check the logs.',
		102 => 'There was an error determining what portion of function should be returned, please specify inner or outer',
		202 => 'There was an error opening the error log file'
	);


	// Prepare Log files
	private function prepareLogs() {
		// First we need to determine if we should log
		if ($this->logging) {
			// Next we need to know if the directory already exists
			if (!is_dir($this->logFile.'/logs')) {
				// We must create directory
				if(!mkdir($this->logFile.'/logs') ) {
					return $this->processError($this->error[202]);
				};
			}

			if (!is_writeable($this->logFile.'/logs/file.log')) {
				// We must create a file
				$errorLog = fopen($this->logFile.'/logs/file.log', 'w');
				if (!$errorLog) {
					return $this->processError($this->error[202]);
				}
				fwrite($errorLog, 'Log created on '.date('l jS \of F Y h:i:s A').PHP_EOL);
				fclose($errorLog);
			}
		}

		return TRUE;
	}

	private function processError($error = NULL, $dump = NULL) {
		// This function's sole purpose to figure out how to handle errors.
		// In the future,  I would like to expand on this and perhaps include more options like json
		if (isset($error) && $this->logging ) {
			// Echo or dump error directly to screen
			if (!$this->mode === 'development') {
				// Then we need to senser ourselves.
				return FALSE;
			}

			// Otherwise continue as usual and output error
			echo ($error);
			if (isset($dump)) {
				var_dump($dump);
			}
		}

		// If logs are to be created, let's handle it now
		if (isset($error) && ($this->logging) ) {
			// Are our logs available?
			if (is_readable($this->logFile.'/logs/file.log')) {
				// Create the error string
				$errorString = 'ERROR: The following was encountered on ' . date('l jS \of F Y h:i:s A'). ' Output: ' . $error . ' Trace( ';
				$i = 0;

				foreach (debug_backtrace() as $trace) {
					$errorString .= ' (error #' . $i . ') file: ' .  $trace['file'] . ' line: ' . $trace['line'] . ' calling function: ' . $trace['function'];
					$i++;
				}
				$errorString .= ' )' . PHP_EOL;

				
				$errorLog = fopen($this->logFile.'/logs/file.log', 'a+');
				if (!$errorLog) {
					// If the file for some reason failed to open, go ahead and process that error as well.
					return $this->processError($this->error[202]);
				}
				fwrite($errorLog, $errorString);
				fclose($errorLog);
			}
		} 
		
		return FALSE;
	}

	// Construct //
	public function __construct($path, $name = null)
	{
		// Make sure error logs are ready.
        if ($this->logging === TRUE) {
		  $this->prepareLogs();
        }


		// See what kind of file we should be working with
		// If path is simply a pointer to directory we will look to create a new file with name
		// Otherwise if it is pointing to file, let's open that file.
		if (is_dir($path) && $name) {
			// Create a file with that name in this path
			$this->file = fopen($path.$name, 'w');
			$this->path = $path.$name;
		} else if (is_file($path) && is_writable($path)) {
			// Then let's go ahead and read it.
			$this->file = fopen($path, 'a+');
			$this->path = $path;
		}

		// If by this point no file is set, error out.
		if (!$this->file) {
			return $this->processError($this->error[100]);
			die();
		}

		// Set some member variables.
		$this->isOpen = TRUE;
		$this->fileSize = fileSize($path).' bytes';
		$this->type = substr(strrchr($path, '.'), 1);
		$this->contentString = file_get_contents($path);
	}

	// In case contents is needed outside the class for post processing.
	// This function also updates the current member variable holding the contents
	public function getContents($format = 'string') {
		switch ($format) {
			case 'string':
				$this->contentString = file_get_contents($this->path);
				return $this->contentString;
				break;
			case 'array':
				$this->contentArray = file($this->path);
				return $this->contentArray;
				break;
			default:
				return FALSE;
				break;
		}	
	}

	// Search the current file and return what makes it a function.
	public function returnFunction($functionName, $break = 'outer') {
		// Look through the file and return a function
		if (!$this->contentString && !$this->getContents()) {
			return $this->processError(101);
		}

		switch ($this->type) {
			case 'php':
				$start = strpos($this->contentString, 'function $'.$functionName);
				break;
			case 'js':
				break;
			default:
				break;
		}

		// The length to first closing block
		$firstLength = strpos($this->contentString, '}', $start) - $start + 1;
		// Determine how many blocks have opened within this span
		$blockCount = substr_count($this->contentString, '{', $start, $firstLength);

		// There are officially sub blocks
		if ($blockCount > 1) {
			// Store an integer of the closing block we are working with.
			$lastFound = strpos($this->contentString, '}', $start);

			for ($i = 1; $i <= $blockCount, $i++) {
				// Loop through each opening block to see if we can find the corrosponding break line. 
				// If any more open blocks are found in between, add it to the blockCount.

			}
		}
	
		// $temp =  substr($this->contentString, $start, $length);


	}


}

?>