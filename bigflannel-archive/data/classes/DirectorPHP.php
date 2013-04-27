<?php

/**
 * DirectorPHP API class
 * Version 1.5
*/

class Director {
	
	# Fill in your API key here. It can be found on your Director preferences pane,
	# under the "About your install" section.
	public $api_key = '';
	
	# Path to your Director install
	# This can also be found on your preferences pane, below the API key		
	public $path = '';
	
	##
	# DO NOT EDIT BEYOND THIS POINT
	##
	
	public $endpoint;
	public $sizes = array();
	public $debug = true;
	public $dead = false;
	public $user_sizes = array();
	public $preview = array();
	public $params = array();
	public $is_local = false;
	public $album;
	public $cache = true;
	public $cache_key = '';
	public $cache_path;
	public $expires;
	public $cache_invalidator;
	public $user_scope = array();
	
	function __construct($api_key = '', $path = '', $debug = true) {
		$this->debug = $debug;
		if (!extension_loaded('curl')) {
			$this->handle_error('The DirectorPHP class requires the cURL library.');
		}
		
		if (!function_exists('json_decode')) {
			$this->handle_error('The DirectorPHP class requires the PHP 5.2.x or higher or the php-json PECL library.');
		}
		
		if (!empty($api_key)) {
			$this->api_key = $api_key;
		}
		
		if (!empty($path)) {
			$this->path = $path;
		}
		
		$this->api_key = trim($this->api_key);
		$this->path = str_replace('http://', '', rtrim($this->path, '/'));
		
		if (empty($this->api_key) || empty($this->path)) {
			$this->handle_error('You must specify an API key and install path.');
		}
		
		if (preg_match('/^(local|hosted)\-(.*)/', $this->api_key, $matches)) {
			if ($matches[1] == 'local') {
				$this->is_local = true;
			}
			$this->api_key = $matches[2];
		} else {
			$this->handle_error('Invalid API key.');
		}
			
		$this->endpoint = 'http://' . $this->path;
		if ($this->is_local) {
			$this->endpoint .= '/index.php?';
		} 
		$this->endpoint .= '/api/';

		$this->cache_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
		$offset = 0;
		if (!strpos($_SERVER['SCRIPT_NAME'], '.php')) {
			$offset = 4;
		}
		$doc_root = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - (strlen($_SERVER['SCRIPT_NAME']) + $offset));
		$this->cache_invalidator = str_replace('DirectorPHP.php', 'cache/clear.php', $_SERVER['HTTP_HOST'] . str_replace(DIRECTORY_SEPARATOR, '/', str_replace($doc_root, '', __FILE__)));
		$this->app = new DirectorApp($this);
		$this->format = new DirectorFormat($this);
		$this->gallery = new DirectorGallery($this);
		$this->album = new DirectorAlbum($this);
		$this->content = new DirectorContent($this);
		$this->utils = new DirectorUtils($this);
		$this->cache = new DirectorCache($this);
		$this->user = new DirectorUser($this);
	}
	
	/********************************************************
		
		public functions
		
		Only methods in this class or a subclass of 
		this class can call these methods.
	
	********************************************************/
	
	protected function format_sizes() {
		if (!empty($this->sizes)) {
			foreach($this->sizes as $key => $size) {
				$temp_arr = array($size['name'], $size['width'], $size['height'], $size['crop'], $size['quality'], $size['sharpening']);
				$this->params[] = "size[$key]=" . join(',', $temp_arr);
			}
		}
		
		if (!empty($this->preview)) {
			$temp_arr = array($this->preview['width'], $this->preview['height'], $this->preview['crop'], $this->preview['quality'], $this->preview['sharpening']);
			$preview = join(',', $temp_arr);
			$this->params[] = 'preview=' . $preview;
		}
		
		if (!empty($this->user_sizes)) {
			foreach($this->user_sizes as $key => $size) {
				$temp_arr = array($size['name'], $size['width'], $size['height'], $size['crop'], $size['quality'], $size['sharpening']);
				$this->params[] = "user_size[$key]=" . join(',', $temp_arr);
			}
		}
	}
	
	public function send($method, $options = array()) {
		if ($this->dead) {
			return array();
		} else {
			if (!empty($options)) {
				foreach($options as $key => $val) {
					if ($key == 'tags') {
						if ($val == 'all') {
							$all = true;
						} else {
							$all = false;
						}
						$this->params[] = 'tags=' . $val[0];
						$this->params[] = 'tags_exclusive=' . $all;
					} else {
						$this->params[] = "$key=$val";
					}
				}
			}
			
			$this->format_sizes();
			
			$params_str = join('&', $this->params);
			$this->params = array();
			
			$tail = md5($params_str);
			
			if ($this->cache && !empty($this->cache_key)) {
				$cache = true;
				$return = $this->cache->get($tail);
			} else {
				$cache = false;
				$return = array();
			}
			
			if (empty($return)) {
				if ($cache) {
					$params_str .= '&invalidator[path]=' . $this->cache_invalidator . '&invalidator[name]=' . $this->cache_key . '/' . $tail;
				}
				$ch = curl_init($this->endpoint . $method . '?' . $params_str); 
				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$return = trim(curl_exec($ch));

				if (curl_errno($ch) != 0) {
					$error = curl_error($ch);
					curl_close($ch);
					$this->handle_error('Error encountered when trying to connect to Director: ' . $error);
				}
				if ($cache) {
					$this->cache->fill($return, $tail);
				}
				curl_close($ch);
			}

			$response = json_decode($return);	

			if (!empty($response->error)) {
				$this->handle_error('DirectorAPI Error: ' . $response->error);
			}
			if (!$this->cache) {
				$this->cache = true;
			}
			return $response->data;
		}
	}
	
	function handle_error($msg) {
		if ($this->debug) {
			die($msg);
		} else {
			$this->dead = true;
		}
	}
	
}

class DirectorWrapper {
	protected $parent;
	function __construct($parent) {
		$this->parent = $parent;
	}
}

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
include($path . 'Gallery.php');
include($path . 'App.php');
include($path . 'Format.php');
include($path . 'Content.php');
include($path . 'Album.php');
include($path . 'Utils.php');
include($path . 'Cache.php');
include($path . 'User.php');

?>