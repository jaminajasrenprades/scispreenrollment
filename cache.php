<?php

class Simple_Cache {

	// Number of seconds a page should remain cached for
	public $cache_expires = 3600;

	// Path to the cache folder
	public $cache_folder = "/home/usr/www/cache/";

	// Include query strings to make the cached page file unique
	public $include_query_strings = true;

	// The current cache file, this will get set when loaded
	private $cache_file = "";

	/**
	 * Set the current cache file from the page URL
	 */
	public function __construct() {
		$file = $_SERVER['REQUEST_URI'];
		if (!$this->include_query_strings && strpos($file, "?") !== false) {
			$qs = explode("?", $file);
			$file = $qs[0];
		}

		$this->cache_file = $this->cache_folder . md5($file) . ".html";
	}

	/**
	 * Checks whether the page has been cached or not
	 * @return boolean
	 */
	public function is_cached() {
		$modified = (file_exists($this->cache_file)) ? filemtime($this->cache_file) : 0;
		return ((time() - $this->cache_expires) < $modified);
	}

	/**
	 * Reads from the cache file
	 * @return string the file contents
	 */
	public function read_cache() {
		return file_get_contents($this->cache_file);
	}

	/**
	 * Writes to the cache file
	 * @param string $contents the contents
	 * @return boolean
	 */
	public function write_cache($contents) {
		return file_put_contents($this->cache_file, $contents);
	}
}

// Initiate the cache class
$cache = new Simple_Cache();

// Check if the page has already been cached and not expired
// If true then we output the cached file contents and finish
if ($cache->is_cached()) {
	echo $cache->read_cache();
	exit();
}

// Ok so the page needs to be cached
// Turn on output buffering
ob_start();