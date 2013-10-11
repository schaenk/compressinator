<?php

/**
 * Compress JS & CSS files
 *
 * @author Marc Schenk <marc.schenk@kletterfux.ch>
 */
class Compressinator {

	/**
	 * File content buffer
	 * @var string
	 */
	private $_buffer = '';

	/**
	 * Path for compressed file
	 * @var string
	 */
	private $_outputPath = '';


	/**
	 * Compress a CSS Files
	 *
	 * @param string $sourcePath Path where the css files are
	 * @param string $outputPath Location where the compressed file should be saved
	 * @param array $filesToIgnore Array with filenames which should not be added
	 * @return void
	 */
	public function compressCss($sourcePath, $outputPath, $filesToIgnore=array()) {
		$this->_writeBuffer($sourcePath, $filesToIgnore);
		$this->_buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $this->_buffer);
		$this->_buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $this->_buffer);
		$this->_buffer = preg_replace('!\040*([;\:,\{\}\(])\040*!', '\\1', $this->_buffer);

		$this->_outputPath = $outputPath;
		$this->_writeFile();
	}

	/**
	 * Compress a JavaScript Files
	 *
	 * @param string $sourcePath Path where the js files are
	 * @param string $outputPath Location where the compressed file should be saved
	 * @param array $filesToIgnore Array with filenames which should not be added
	 * @return void
	 */
	public function compressJs($sourcePath, $outputPath, $filesToIgnore=array()) {
		$this->_writeBuffer($sourcePath, $filesToIgnore);
		$this->_buffer = preg_replace('![\s]+/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $this->_buffer);
		$this->_buffer = preg_replace('![\s]+//.*!', '', $this->_buffer);
		$this->_buffer = str_replace(array("\n", "\r", "\n", "\t"), '', $this->_buffer);
		$this->_buffer = preg_replace('!\040{2,}!', ' ', $this->_buffer);

		$this->_outputPath = $outputPath;
		$this->_writeFile();
	}

	/**
	 * Write file content into buffer
	 *
	 * @param string $sourcePath Path to source directory
	 * @param array $ignore Array of filenames which should be ignored
	 * @return void
	 */
	private function _writeBuffer($sourcePath, $ignore=array()) {
		$sourceContent = scandir($sourcePath);
		foreach($sourceContent as $filename) {
			if(is_file($sourcePath . $filename) && !in_array($filename, $ignore)) {
				$this->_buffer.= file_get_contents($sourcePath . $filename);
			}
		}
	}

	/**
	 * Write buffer into file and reset buffer
	 *
	 * @param string $filename Filename
	 * @return void
	 */
	private function _writeFile() {
		$file = fopen($this->_outputPath, 'w+');
		rewind($file);
		fwrite($file, $this->_buffer);
		fclose($file);
		$this->_buffer = '';
	}

}

?>
