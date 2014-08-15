<?php

class SAPE_base {

    var $_version = '1.1.7';

    var $_verbose = false;

    var $_charset = ''; // http://www.php.net/manual/en/function.iconv.php

    var $_sape_charset = '';

    var $_server_list = array('dispenser-01.sape.ru', 'dispenser-02.sape.ru');

    var $_cache_lifetime = 3600; 

    
    var $_cache_reloadtime = 600;

    var $_error = '';

    var $_host = '';

    var $_request_uri = '';

    var $_multi_site = false;

    var $_fetch_remote_type = '';

    var $_socket_timeout = 6;

    var $_force_show_code = false;

    var $_is_our_bot = false; 

    var $_debug = false;

    var $_ignore_case = false; 

    var $_db_file = ''; 

    var $_use_server_array = false; 

    var $_force_update_db = false;

    var $_is_block_css_showed = false; 

	var $_is_block_ins_beforeall_showed = false;

    function SAPE_base($options = null) {

        

        $host = '';

        if (is_array($options)) {
            if (isset($options['host'])) {
                $host = $options['host'];
            }
        } elseif (strlen($options)) {
            $host = $options;
            $options = array();
        } else {
            $options = array();
        }

        if (isset($options['use_server_array']) && $options['use_server_array'] == true) {
            $this->_use_server_array = true;
        }

       
        if (strlen($host)) {
            $this->_host = $host;
        } else {
            $this->_host = $_SERVER['HTTP_HOST'];
        }

        $this->_host = preg_replace('/^http:\/\//', '', $this->_host);
        $this->_host = preg_replace('/^www\./', '', $this->_host);

        
        if (isset($options['request_uri']) && strlen($options['request_uri'])) {
            $this->_request_uri = $options['request_uri'];
        } elseif ($this->_use_server_array === false) {
            $this->_request_uri = getenv('REQUEST_URI');
        }

        if (strlen($this->_request_uri) == 0) {
            $this->_request_uri = $_SERVER['REQUEST_URI'];
        }

       
        if (isset($options['multi_site']) && $options['multi_site'] == true) {
            $this->_multi_site = true;
        }

       
        if (isset($options['debug']) && $options['debug'] == true) {
            $this->_debug = true;
        }

        
        if (isset($_COOKIE['sape_cookie']) && ($_COOKIE['sape_cookie'] == _SAPE_USER)) {
            $this->_is_our_bot = true;
            if (isset($_COOKIE['sape_debug']) && ($_COOKIE['sape_debug'] == 1)) {
                $this->_debug = true;
                
                $this->_options = $options;
                $this->_server_request_uri = $this->_request_uri = $_SERVER['REQUEST_URI'];
                $this->_getenv_request_uri = getenv('REQUEST_URI');
                $this->_SAPE_USER = _SAPE_USER;
            }
            if (isset($_COOKIE['sape_updatedb']) && ($_COOKIE['sape_updatedb'] == 1)) {
                $this->_force_update_db = true;
            }
        } else {
            $this->_is_our_bot = false;
        }

        
        if (isset($options['verbose']) && $options['verbose'] == true || $this->_debug) {
            $this->_verbose = true;
        }

        
        if (isset($options['charset']) && strlen($options['charset'])) {
            $this->_charset = $options['charset'];
        } else {
            $this->_charset = 'windows-1251';
        }

        if (isset($options['fetch_remote_type']) && strlen($options['fetch_remote_type'])) {
            $this->_fetch_remote_type = $options['fetch_remote_type'];
        }

        if (isset($options['socket_timeout']) && is_numeric($options['socket_timeout']) && $options['socket_timeout'] > 0) {
            $this->_socket_timeout = $options['socket_timeout'];
        }

        
        if (isset($options['force_show_code']) && $options['force_show_code'] == true) {
            $this->_force_show_code = true;
        }

        if (!defined('_SAPE_USER')) {
            return $this->raise_error('Не задана константа _SAPE_USER');
        }

        
        if (isset($options['ignore_case']) && $options['ignore_case'] == true) {
            $this->_ignore_case = true;
            $this->_request_uri = strtolower($this->_request_uri);
        }
    }

    /**
     * Функция для подключения к удалённому серверу
     */
    function fetch_remote_file($host, $path, $specifyCharset = false) {

        $user_agent = $this->_user_agent . ' ' . $this->_version;

        @ini_set('allow_url_fopen', 1);
        @ini_set('default_socket_timeout', $this->_socket_timeout);
        @ini_set('user_agent', $user_agent);
        if (
                $this->_fetch_remote_type == 'file_get_contents'
                ||
                (
                        $this->_fetch_remote_type == ''
                        &&
                        function_exists('file_get_contents')
                        &&
                        ini_get('allow_url_fopen') == 1
                )
        ) {
            $this->_fetch_remote_type = 'file_get_contents';
            
            if($specifyCharset && function_exists('stream_context_create')) {
                $opts = array( 
                  'http' => array( 
                    'method' => 'GET', 
                    'header' => 'Accept-Charset: '. $this->_charset. "\r\n"
                  ) 
                ); 
                $context = @stream_context_create($opts);                     
                if ($data = @file_get_contents('http://' . $host . $path, null, $context)) {
                    return $data;
                }
            } else {
                if ($data = @file_get_contents('http://' . $host . $path)) {
                    return $data;
                }
            }
            
        } elseif (
                $this->_fetch_remote_type == 'curl'
                ||
                (
                        $this->_fetch_remote_type == ''
                        &&
                        function_exists('curl_init')
                )
        ) {
            $this->_fetch_remote_type = 'curl';
            if ($ch = @curl_init()) {

                @curl_setopt($ch, CURLOPT_URL, 'http://' . $host . $path);
                @curl_setopt($ch, CURLOPT_HEADER, false);
                @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_socket_timeout);
                @curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
                if($specifyCharset) {
                    @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: '. $this->_charset));
                }

				$data = @curl_exec($ch);
				@curl_close($ch);

                if ($data) {
                    return $data;
                }
            }

        } else {
            $this->_fetch_remote_type = 'socket';
            $buff = '';
            $fp = @fsockopen($host, 80, $errno, $errstr, $this->_socket_timeout);
            if ($fp) {
                @fputs($fp, "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n");
                if($specifyCharset) {
                    @fputs($fp, "Accept-Charset: {$this->_charset}\r\n");
                }
                @fputs($fp, "User-Agent: {$user_agent}\r\n\r\n");
                while (!@feof($fp)) {
                    $buff .= @fgets($fp, 128);
                }
                @fclose($fp);

                $page = explode("\r\n\r\n", $buff);
                unset($page[0]);
                return implode("\r\n\r\n", $page);
            }

        }

        return $this->raise_error('Не могу подключиться к серверу: ' . $host . $path . ', type: ' . $this->_fetch_remote_type);
    }

    /**
     * Функция чтения из локального файла
     */
    function _read($filename) {

        $fp = @fopen($filename, 'rb');
        @flock($fp, LOCK_SH);
        if ($fp) {
            clearstatcache();
            $length = @filesize($filename);
            $mqr = @get_magic_quotes_runtime();
            @set_magic_quotes_runtime(0);
            if ($length) {
                $data = @fread($fp, $length);
            } else {
                $data = '';
            }
                @set_magic_quotes_runtime($mqr);
            @flock($fp, LOCK_UN);
            @fclose($fp);

            return $data;
        }

        return $this->raise_error('Не могу считать данные из файла: ' . $filename);
    }

    /**
     * Функция записи в локальный файл
     */
    function _write($filename, $data) {

        $fp = @fopen($filename, 'ab');
        if ($fp) {
            if (flock($fp, LOCK_EX | LOCK_NB)) {
                ftruncate($fp, 0);
                $mqr = @get_magic_quotes_runtime();
                @set_magic_quotes_runtime(0);
                @fwrite($fp, $data);
                @set_magic_quotes_runtime($mqr);
                @flock($fp, LOCK_UN);
                @fclose($fp);

                if (md5($this->_read($filename)) != md5($data)) {
                    @unlink($filename);
                    return $this->raise_error('Нарушена целостность данных при записи в файл: ' . $filename);
                }
            } else {
                return false;
            }

            return true;
        }

        return $this->raise_error('Не могу записать данные в файл: ' . $filename);
    }

    /**
     * Функция обработки ошибок
     */
    function raise_error($e) {

        $this->_error = '<p style="color: red; font-weight: bold;">SAPE ERROR: ' . $e . '</p>';

        if ($this->_verbose == true) {
            print $this->_error;
        }

        return false;
    }

	/**
	 * Загрузка данных
	 */
    function load_data() {
        $this->_db_file = $this->_get_db_file();

        if (!is_file($this->_db_file)) {
            
            if (@touch($this->_db_file)) {
                @chmod($this->_db_file, 0666);
            } else {
                return $this->raise_error('Нет файла ' . $this->_db_file . '. Создать не удалось. Выставите права 777 на папку.');
            }
        }

        if (!is_writable($this->_db_file)) {
            return $this->raise_error('Нет доступа на запись к файлу: ' . $this->_db_file . '! Выставите права 777 на папку.');
        }

        @clearstatcache();

        $data = $this->_read($this->_db_file);
        if (
                $this->_force_update_db
                || (
                        !$this->_is_our_bot
                        &&
                        (
                                filemtime($this->_db_file) < (time() - $this->_cache_lifetime)
                                ||
                                filesize($this->_db_file) == 0
                                ||
                                @unserialize($data) == false
                        )
                )
        ) {
            
            @touch($this->_db_file, (time() - $this->_cache_lifetime + $this->_cache_reloadtime));

            $path = $this->_get_dispenser_path();
            if (strlen($this->_charset)) {
                $path .= '&charset=' . $this->_charset;
            }

            foreach ($this->_server_list as $i => $server) {
                if ($data = $this->fetch_remote_file($server, $path)) {
                    if (substr($data, 0, 12) == 'FATAL ERROR:') {
                        $this->raise_error($data);
                    } else {
                        
                        $hash = @unserialize($data);
                        if ($hash != false) {
                           
                            $hash['__sape_charset__'] = $this->_charset;
                            $hash['__last_update__'] = time();
                            $hash['__multi_site__'] = $this->_multi_site;
                            $hash['__fetch_remote_type__'] = $this->_fetch_remote_type;
                            $hash['__ignore_case__'] = $this->_ignore_case;
                            $hash['__php_version__'] = phpversion();
                            $hash['__server_software__'] = $_SERVER['SERVER_SOFTWARE'];

                            $data_new = @serialize($hash);
                            if ($data_new) {
                                $data = $data_new;
                            }

                            $this->_write($this->_db_file, $data);
                            break;
                        }
                    }
                }
            }
        }

        
        if (strlen(session_id())) {
            $session = session_name() . '=' . session_id();
            $this->_request_uri = str_replace(array('?' . $session, '&' . $session), '', $this->_request_uri);
        }

        $this->set_data(@unserialize($data));
    }
}

/**
 * Класс для работы с обычными ссылками
 */
class SAPE_client extends SAPE_base {

    var $_links_delimiter = '';
    var $_links = array();
    var $_links_page = array();
    var $_user_agent = 'SAPE_Client PHP';

    function SAPE_client($options = null) {
        parent::SAPE_base($options);
        $this->load_data();
    }

	/**
	 * Обработка html для массива ссылок
	 *
	 * @param string $html
	 * @return string
	 */
	function _return_array_links_html($html, $options = null) {

		if(empty($options)) {
			$options = array();
		}

		
		if (
				strlen($this->_charset) > 0
				&&
				strlen($this->_sape_charset) > 0
				&&
				$this->_sape_charset != $this->_charset
				&&
				function_exists('iconv')
		) {
			$new_html = @iconv($this->_sape_charset, $this->_charset, $html);
			if ($new_html) {
				$html = $new_html;
			}
		}

		if ($this->_is_our_bot) {

			$html = '<sape_noindex>' . $html . '</sape_noindex>';

			if(isset($options['is_block_links']) && true == $options['is_block_links']) {

				if(!isset($options['nof_links_requested'])) {
					$options['nof_links_requested'] = 0;
				}
				if(!isset($options['nof_links_displayed'])) {
					$options['nof_links_displayed'] = 0;
				}
				if(!isset($options['nof_obligatory'])) {
					$options['nof_obligatory'] = 0;
				}
				if(!isset($options['nof_conditional'])) {
					$options['nof_conditional'] = 0;
				}

				$html = '<sape_block nof_req="' . $options['nof_links_requested'] .
							'" nof_displ="' . $options['nof_links_displayed'] .
							'" nof_oblig="' . $options['nof_obligatory'] .
							'" nof_cond="' . $options['nof_conditional'] .
							'">' . $html .
						'</sape_block>';
			}
		}

		return $html;
	}

	/**
	 * Финальная обработка html перед выводом ссылок
	 *
	 * @param string $html
	 * @return string
	 */
	function _return_html($html) {

		 if ($this->_debug) {
            $html .= print_r($this, true);
        }

		return $html;
	}

    
    function return_block_links($n = null, $offset = 0, $options = null) {

		
		if(empty($options)) {
			$options = array();
		}

        $defaults = array();
        $defaults['block_no_css'] 		= false;
		$defaults['block_orientation'] 	= 1;
		$defaults['block_width'] 		= '';

		$ext_options = array();
		if(isset($this->_block_tpl_options) && is_array($this->_block_tpl_options)) {
			$ext_options = $this->_block_tpl_options;
		}

        $options = array_merge($defaults, $ext_options, $options);

		
		if (!is_array($this->_links_page)) {
			$html = $this->_return_array_links_html('', array('is_block_links' => true));
			return $this->_return_html($this->_links_page . $html);
		}
		
		elseif(!isset($this->_block_tpl)) {
			return $this->_return_html('');
		}

		

        $total_page_links = count($this->_links_page);

		$need_show_obligatory_block = false;
		$need_show_conditional_block = false;
		$n_requested = 0;

		if(isset($this->_block_ins_itemobligatory)) {
			$need_show_obligatory_block = true;
		}

		if(is_numeric($n) && $n >= $total_page_links) {

			$n_requested = $n;

			if(isset($this->_block_ins_itemconditional)) {
				$need_show_conditional_block = true;
			}
		}

		if (!is_numeric($n) || $n > $total_page_links) {
			$n = $total_page_links;
		}

		
		$links = array();
		for ($i = 1; $i <= $n; $i++) {
			if ($offset > 0 && $i <= $offset) {
				array_shift($this->_links_page);
			} else {
				$links[] = array_shift($this->_links_page);
			}
		}

		$html = '';

		
		$nof_conditional = 0;
		if(count($links) < $n_requested && true == $need_show_conditional_block) {
			$nof_conditional = $n_requested - count($links);
		}

		
		if(empty($links) && $need_show_obligatory_block == false && $nof_conditional == 0) {

			$return_links_options = array(
				'is_block_links' 		=> true,
				'nof_links_requested' 	=> $n_requested,
				'nof_links_displayed'	=> 0,
				'nof_obligatory'		=> 0,
				'nof_conditional'		=> 0
			);

			$html = $this->_return_array_links_html($html, $return_links_options);

			return $this->_return_html($html);
		}

		
		if (!$this->_is_block_css_showed && false == $options['block_no_css']) {
			$html .= $this->_block_tpl['css'];
			$this->_is_block_css_showed = true;
		}

		
		if (isset($this->_block_ins_beforeall) && !$this->_is_block_ins_beforeall_showed){
			$html .= $this->_block_ins_beforeall;
			$this->_is_block_ins_beforeall_showed = true;
		}

		
		if (isset($this->_block_ins_beforeblock)){
			$html .= $this->_block_ins_beforeblock;
		}

		
		$block_tpl_parts = $this->_block_tpl[$options['block_orientation']];

		$block_tpl 			= $block_tpl_parts['block'];
		$item_tpl 			= $block_tpl_parts['item'];
		$item_container_tpl = $block_tpl_parts['item_container'];
		$item_tpl_full 		= str_replace('{item}', $item_tpl, $item_container_tpl);
		$items 				= '';

		$nof_items_total = count($links);
		foreach ($links as $link){

			preg_match('#<a href="(https?://([^"/]+)[^"]*)"[^>]*>[\s]*([^<]+)</a>#i', $link, $link_item);

			if (function_exists('mb_strtoupper') && strlen($this->_sape_charset) > 0) {
				$header_rest = mb_substr($link_item[3], 1, mb_strlen($link_item[3], $this->_sape_charset) - 1, $this->_sape_charset);
				$header_first_letter = mb_strtoupper(mb_substr($link_item[3], 0, 1, $this->_sape_charset), $this->_sape_charset);
				$link_item[3] = $header_first_letter . $header_rest;
			} elseif(function_exists('ucfirst') && (strlen($this->_sape_charset) == 0 || strpos($this->_sape_charset, '1251') !== false) ) {
				$link_item[3][0] = ucfirst($link_item[3][0]);
			}

			

			if(isset($this->_block_uri_idna) && isset($this->_block_uri_idna[$link_item[2]])) {
				$link_item[2] = $this->_block_uri_idna[$link_item[2]];
			}

			$item = $item_tpl_full;
			$item = str_replace('{header}', $link_item[3], $item);
			$item = str_replace('{text}', trim($link), $item);
			$item = str_replace('{url}', $link_item[2], $item);
			$item = str_replace('{link}', $link_item[1], $item);
			$items .= $item;
		}

		
		if(true == $need_show_obligatory_block) {
			$items .= str_replace('{item}', $this->_block_ins_itemobligatory, $item_container_tpl);
			$nof_items_total += 1;
		}

		
		if($need_show_conditional_block == true && $nof_conditional > 0) {
			for($i = 0; $i < $nof_conditional; $i++) {
				$items .= str_replace('{item}', $this->_block_ins_itemconditional, $item_container_tpl);
			}
			$nof_items_total += $nof_conditional;
		}

		if ($items != ''){
			$html .= str_replace('{items}', $items, $block_tpl);

			
			if ($nof_items_total > 0){
				$html = str_replace('{td_width}', round(100/$nof_items_total), $html);
			} else {
				$html = str_replace('{td_width}', 0, $html);
			}

		
			if(isset($options['block_width']) && !empty($options['block_width'])) {
				$html = str_replace('{block_style_custom}', 'style="width: ' . $options['block_width'] . '!important;"', $html);
			}
		}

		unset($block_tpl_parts, $block_tpl, $items, $item, $item_tpl, $item_container_tpl);

		
		if (isset($this->_block_ins_afterblock)){
			$html .= $this->_block_ins_afterblock;
		}

		
		unset($options['block_no_css'], $options['block_orientation'], $options['block_width']);

		$tpl_modifiers = array_keys($options);
		foreach($tpl_modifiers as $k=>$m) {
			$tpl_modifiers[$k] = '{' . $m . '}';
		}
		unset($m, $k);

		$tpl_modifiers_values =  array_values($options);

		$html = str_replace($tpl_modifiers, $tpl_modifiers_values, $html);
		unset($tpl_modifiers, $tpl_modifiers_values);

		
		$clear_modifiers_regexp = '#\{[a-z\d_\-]+\}#';
		$html = preg_replace($clear_modifiers_regexp, ' ', $html);

		$return_links_options = array(
			'is_block_links' 		=> true,
			'nof_links_requested' 	=> $n_requested,
			'nof_links_displayed'	=> $n,
			'nof_obligatory'		=> ($need_show_obligatory_block == true ? 1 : 0),
			'nof_conditional'		=> $nof_conditional
		);

		$html = $this->_return_array_links_html($html, $return_links_options);

		return $this->_return_html($html);
    }

    
    function return_links($n = null, $offset = 0, $options = null) {

		
		$as_block = $this->_show_only_block;

		if(is_array($options) && isset($options['as_block']) && false == $as_block) {
			$as_block = $options['as_block'];
		}

		if(true == $as_block && isset($this->_block_tpl)) {
			return $this->return_block_links($n, $offset, $options);
		}

		

        if (is_array($this->_links_page)) {

            $total_page_links = count($this->_links_page);

            if (!is_numeric($n) || $n > $total_page_links) {
                $n = $total_page_links;
            }

            $links = array();

            for ($i = 1; $i <= $n; $i++) {
                if ($offset > 0 && $i <= $offset) {
                    array_shift($this->_links_page);
                } else {
                    $links[] = array_shift($this->_links_page);
                }
            }

            $html = join($this->_links_delimiter, $links);

            
            if (
                    strlen($this->_charset) > 0
                    &&
                    strlen($this->_sape_charset) > 0
                    &&
                    $this->_sape_charset != $this->_charset
                    &&
                    function_exists('iconv')
            ) {
                $new_html = @iconv($this->_sape_charset, $this->_charset, $html);
                if ($new_html) {
                    $html = $new_html;
                }
            }

            if ($this->_is_our_bot) {
                $html = '<sape_noindex>' . $html . '</sape_noindex>';
            }
        } else {
            $html = $this->_links_page;
			if ($this->_is_our_bot) {
				$html .= '<sape_noindex></sape_noindex>';
			}
        }

        if ($this->_debug) {
            $html .= print_r($this, true);
        }

        return $html;
    }

    function _get_db_file() {
        if ($this->_multi_site) {
            return dirname(__FILE__) . '/' . $this->_host . '.links.db';
        } else {
            return dirname(__FILE__) . '/links.db';
        }
    }

    function _get_dispenser_path() {
        return '/code.php?user=' . _SAPE_USER . '&host=' . $this->_host;
    }

    function set_data($data) {
        if ($this->_ignore_case) {
            $this->_links = array_change_key_case($data);
        } else {
            $this->_links = $data;
        }
        if (isset($this->_links['__sape_delimiter__'])) {
            $this->_links_delimiter = $this->_links['__sape_delimiter__'];
        }
        
        if (isset($this->_links['__sape_charset__'])) {
            $this->_sape_charset = $this->_links['__sape_charset__'];
        } else {
            $this->_sape_charset = '';
        }
        if (@array_key_exists($this->_request_uri, $this->_links) && is_array($this->_links[$this->_request_uri])) {
            $this->_links_page = $this->_links[$this->_request_uri];
        } else {
            if (isset($this->_links['__sape_new_url__']) && strlen($this->_links['__sape_new_url__'])) {
                if ($this->_is_our_bot || $this->_force_show_code) {
                    $this->_links_page = $this->_links['__sape_new_url__'];
                }
            }
        }

		
		if (isset($this->_links['__sape_show_only_block__'])) {
            $this->_show_only_block = $this->_links['__sape_show_only_block__'];
        }
		else {
			$this->_show_only_block = false;
		}

        
        if (isset($this->_links['__sape_block_tpl__']) && !empty($this->_links['__sape_block_tpl__'])
				&& is_array($this->_links['__sape_block_tpl__'])){
            $this->_block_tpl = $this->_links['__sape_block_tpl__'];
        }

		
        if (isset($this->_links['__sape_block_tpl_options__']) && !empty($this->_links['__sape_block_tpl_options__'])
				&& is_array($this->_links['__sape_block_tpl_options__'])){
            $this->_block_tpl_options = $this->_links['__sape_block_tpl_options__'];
        }

		
		if (isset($this->_links['__sape_block_uri_idna__']) && !empty($this->_links['__sape_block_uri_idna__'])
				&& is_array($this->_links['__sape_block_uri_idna__'])){
            $this->_block_uri_idna = $this->_links['__sape_block_uri_idna__'];
        }

		
		$check_blocks = array(
			'beforeall',
			'beforeblock',
			'afterblock',
			'itemobligatory',
			'itemconditional',
			'afterall'
		);

		foreach($check_blocks as $block_name) {

			$var_name = '__sape_block_ins_' . $block_name . '__';
			$prop_name = '_block_ins_' . $block_name;

			if (isset($this->_links[$var_name]) && strlen($this->_links[$var_name]) > 0) {
				$this->$prop_name = $this->_links[$var_name];
			}

		}
    }
}

/**
 * Класс для работы с контекстными ссылками
 */
class SAPE_context extends SAPE_base {

    var $_words = array();
    var $_words_page = array();
    var $_user_agent = 'SAPE_Context PHP';
    var $_filter_tags = array('a', 'textarea', 'select', 'script', 'style', 'label', 'noscript', 'noindex', 'button');

    function SAPE_context($options = null) {
        parent::SAPE_base($options);
        $this->load_data();
    }

    /**
     * Замена слов в куске текста и обрамляет его тегами sape_index
     */
    function replace_in_text_segment($text) {
        $debug = '';
        if ($this->_debug) {
            $debug .= "<!-- argument for replace_in_text_segment: \r\n" . base64_encode($text) . "\r\n -->";
        }
        if (count($this->_words_page) > 0) {

            $source_sentence = array();
            if ($this->_debug) {
                $debug .= '<!-- sentences for replace: ';
            }
            
            foreach ($this->_words_page as $n => $sentence) {
                
                $special_chars = array(
                    '&amp;' => '&',
                    '&quot;' => '"',
                    '&#039;' => '\'',
                    '&lt;' => '<',
                    '&gt;' => '>'
                );
                $sentence = strip_tags($sentence);
                foreach ($special_chars as $from => $to) {
                    str_replace($from, $to, $sentence);
                }
                
                $sentence = htmlspecialchars($sentence);
                
                $sentence = preg_quote($sentence, '/');
                $replace_array = array();
                if (preg_match_all('/(&[#a-zA-Z0-9]{2,6};)/isU', $sentence, $out)) {
                    for ($i = 0; $i < count($out[1]); $i++) {
                        $unspec = $special_chars[$out[1][$i]];
                        $real = $out[1][$i];
                        $replace_array[$unspec] = $real;
                    }
                }
                
                foreach ($replace_array as $unspec => $real) {
                    $sentence = str_replace($real, '((' . $real . ')|(' . $unspec . '))', $sentence);
                }
                
                $source_sentences[$n] = str_replace(' ', '((\s)|(&nbsp;))+', $sentence);

                if ($this->_debug) {
                    $debug .= $source_sentences[$n] . "\r\n\r\n";
                }
            }

            if ($this->_debug) {
                $debug .= '-->';
            }

            
            $first_part = true;
            

            if (count($source_sentences) > 0) {

                $content = '';
                $open_tags = array(); 
                $close_tag = '';

                
                $part = strtok(' ' . $text, '<');

                while ($part !== false) {
                    
                    if (preg_match('/(?si)^(\/?[a-z0-9]+)/', $part, $matches)) {
                        
                        $tag_name = strtolower($matches[1]);
                        
                        if (substr($tag_name, 0, 1) == '/') {
                            $close_tag = substr($tag_name, 1);
                            if ($this->_debug) {
                                $debug .= '<!-- close_tag: ' . $close_tag . ' -->';
                            }
                        } else {
                            $close_tag = '';
                            if ($this->_debug) {
                                $debug .= '<!-- open_tag: ' . $tag_name . ' -->';
                            }
                        }
                        $cnt_tags = count($open_tags);
                       
                        if (($cnt_tags > 0) && ($open_tags[$cnt_tags - 1] == $close_tag)) {
                            array_pop($open_tags);
                            if ($this->_debug) {
                                $debug .= '<!-- ' . $tag_name . ' - deleted from open_tags -->';
                            }
                            if ($cnt_tags - 1 == 0) {
                                if ($this->_debug) {
                                    $debug .= '<!-- start replacement -->';
                                }
                            }
                        }

                        
                        if (count($open_tags) == 0) {
                            
                            if (!in_array($tag_name, $this->_filter_tags)) {
                                $split_parts = explode('>', $part, 2);
                                
                                if (count($split_parts) == 2) {
                                    
                                    foreach ($source_sentences as $n => $sentence) {
                                        if (preg_match('/' . $sentence . '/', $split_parts[1]) == 1) {
                                            $split_parts[1] = preg_replace('/' . $sentence . '/', str_replace('$', '\$', $this->_words_page[$n]), $split_parts[1], 1);
                                            if ($this->_debug) {
                                                $debug .= '<!-- ' . $sentence . ' --- ' . $this->_words_page[$n] . ' replaced -->';
                                            }

                                            
                                            unset($source_sentences[$n]);
                                            unset($this->_words_page[$n]);
                                        }
                                    }
                                    $part = $split_parts[0] . '>' . $split_parts[1];
                                    unset($split_parts);
                                }
                            } else {
                                
                                $open_tags[] = $tag_name;
                                if ($this->_debug) {
                                    $debug .= '<!-- ' . $tag_name . ' - added to open_tags, stop replacement -->';
                                }
                            }
                        }
                    } else {
                        
                        foreach ($source_sentences as $n => $sentence) {
                            if (preg_match('/' . $sentence . '/', $part) == 1) {
                                $part = preg_replace('/' . $sentence . '/', str_replace('$', '\$', $this->_words_page[$n]), $part, 1);

                                if ($this->_debug) {
                                    $debug .= '<!-- ' . $sentence . ' --- ' . $this->_words_page[$n] . ' replaced -->';
                                }

                                
                                
                                unset($source_sentences[$n]);
                                unset($this->_words_page[$n]);
                            }
                        }
                    }

                    
                    if ($this->_debug) {
                        $content .= $debug;
                        $debug = '';
                    }
                    
                    if ($first_part) {
                        $content .= $part;
                        $first_part = false;
                    } else {
                        $content .= $debug . '<' . $part;
                    }
                    
                    unset($part);
                    $part = strtok('<');
                }
                $text = ltrim($content);
                unset($content);
            }
        } else {
            if ($this->_debug) {
                $debug .= '<!-- No word`s for page -->';
            }
        }

        if ($this->_debug) {
            $debug .= '<!-- END: work of replace_in_text_segment() -->';
        }

        if ($this->_is_our_bot || $this->_force_show_code || $this->_debug) {
            $text = '<sape_index>' . $text . '</sape_index>';
            if (isset($this->_words['__sape_new_url__']) && strlen($this->_words['__sape_new_url__'])) {
                $text .= $this->_words['__sape_new_url__'];
            }
        }

        if ($this->_debug) {
            if (count($this->_words_page) > 0) {
                $text .= '<!-- Not replaced: ' . "\r\n";
                foreach ($this->_words_page as $n => $value) {
                    $text .= $value . "\r\n\r\n";
                }
                $text .= '-->';
            }

            $text .= $debug;
        }
        return $text;
    }

    /**
     * Замена слов
     */
    function replace_in_page(&$buffer) {

        if (count($this->_words_page) > 0) {
            
            
            $split_content = preg_split('/(?smi)(<\/?sape_index>)/', $buffer, -1);
            $cnt_parts = count($split_content);
            if ($cnt_parts > 1) {
               
                if ($cnt_parts >= 3) {
                    for ($i = 1; $i < $cnt_parts; $i = $i + 2) {
                        $split_content[$i] = $this->replace_in_text_segment($split_content[$i]);
                    }
                }
                $buffer = implode('', $split_content);
                if ($this->_debug) {
                    $buffer .= '<!-- Split by Sape_index cnt_parts=' . $cnt_parts . '-->';
                }
            } else {
                
                $split_content = preg_split('/(?smi)(<\/?body[^>]*>)/', $buffer, -1, PREG_SPLIT_DELIM_CAPTURE);
                
                if (count($split_content) == 5) {
                    $split_content[0] = $split_content[0] . $split_content[1];
                    $split_content[1] = $this->replace_in_text_segment($split_content[2]);
                    $split_content[2] = $split_content[3] . $split_content[4];
                    unset($split_content[3]);
                    unset($split_content[4]);
                    $buffer = $split_content[0] . $split_content[1] . $split_content[2];
                    if ($this->_debug) {
                        $buffer .= '<!-- Split by BODY -->';
                    }
                } else {
                    
                    if ($this->_debug) {
                        $buffer .= '<!-- Can`t split by BODY -->';
                    }
                }
            }

        } else {
            if (!$this->_is_our_bot && !$this->_force_show_code && !$this->_debug) {
                $buffer = preg_replace('/(?smi)(<\/?sape_index>)/', '', $buffer);
            } else {
                if (isset($this->_words['__sape_new_url__']) && strlen($this->_words['__sape_new_url__'])) {
                    $buffer .= $this->_words['__sape_new_url__'];
                }
            }
            if ($this->_debug) {
                $buffer .= '<!-- No word`s for page -->';
            }
        }
        return $buffer;
    }

    function _get_db_file() {
        if ($this->_multi_site) {
            return dirname(__FILE__) . '/' . $this->_host . '.words.db';
        } else {
            return dirname(__FILE__) . '/words.db';
        }
    }

    function _get_dispenser_path() {
        return '/code_context.php?user=' . _SAPE_USER . '&host=' . $this->_host;
    }

    function set_data($data) {
        $this->_words = $data;
        if (@array_key_exists($this->_request_uri, $this->_words) && is_array($this->_words[$this->_request_uri])) {
            $this->_words_page = $this->_words[$this->_request_uri];
        }
    }
}

/**
 * Класс для работы со статьями articles.sape.ru показывает анонсы и статьи
 */
class SAPE_articles extends SAPE_base {

    var $_request_mode;

    var $_server_list             = array('dispenser.articles.sape.ru');

    var $_data                    = array();

    var $_article_id;

    var $_save_file_name;

    var $_announcements_delimiter = '';

    var $_images_path;

    var $_template_error = false;

    var $_noindex_code = '<!--sape_noindex-->';

    var $_headers_enabled = false;

    var $_mask_code;

    var $_real_host;
    
    var $_user_agent = 'SAPE_Articles_Client PHP';

    function SAPE_articles($options = null){
        parent::SAPE_base($options);
        if (is_array($options) && isset($options['headers_enabled'])) {
            $this->_headers_enabled = $options['headers_enabled'];
        }
        
        if (isset($options['charset']) && strlen($options['charset'])) {
            $this->_charset = $options['charset'];
        } else {
            $this->_charset = '';
        }
        $this->_get_index();
        if (!empty($this->_data['index']['announcements_delimiter'])) {
            $this->_announcements_delimiter = $this->_data['index']['announcements_delimiter'];
        }
        if (!empty($this->_data['index']['charset'])
            and !(isset($options['charset']) && strlen($options['charset']))) {
            $this->_charset = $this->_data['index']['charset'];
        }
        if (is_array($options)) {
            if (isset($options['host'])) {
                $host = $options['host'];
            }
        } elseif (strlen($options)) {
            $host = $options;
            $options = array();
        }
        if (isset($host) && strlen($host)) {
             $this->_real_host = $host;
        } else {
             $this->_real_host = $_SERVER['HTTP_HOST'];
        }
        if (!isset($this->_data['index']['announcements'][$this->_request_uri])) {
            $this->_correct_uri();
        }
    }

    function _correct_uri() {
        if(substr($this->_request_uri, -1) == '/') {
            $new_uri = substr($this->_request_uri, 0, -1);
        } else {
            $new_uri = $this->_request_uri . '/';
        }
        if (isset($this->_data['index']['announcements'][$new_uri])) {
            $this->_request_uri = $new_uri;
        }
    }

    /**
     * Возвращает анонсы для вывода
     * @param int $n      Сколько анонсов вывести, либо не задано - вывести все
     * @param int $offset C какого анонса начинаем вывод(нумерация с 0), либо не задано - с нулевого
     * @return string
     */
    function return_announcements($n = null, $offset = 0){
        $output = '';
        if ($this->_force_show_code || $this->_is_our_bot) {
            if (isset($this->_data['index']['checkCode'])) {
                $output .= $this->_data['index']['checkCode'];
            }
        }

        if (isset($this->_data['index']['announcements'][$this->_request_uri])) {

            $total_page_links = count($this->_data['index']['announcements'][$this->_request_uri]);

            if (!is_numeric($n) || $n > $total_page_links) {
                $n = $total_page_links;
            }

            $links = array();

            for ($i = 1; $i <= $n; $i++) {
                if ($offset > 0 && $i <= $offset) {
                    array_shift($this->_data['index']['announcements'][$this->_request_uri]);
                } else {
                    $links[] = array_shift($this->_data['index']['announcements'][$this->_request_uri]);
                }
            }

            $html = join($this->_announcements_delimiter, $links);

            if ($this->_is_our_bot) {
                $html = '<sape_noindex>' . $html . '</sape_noindex>';
            }

            $output .= $html;

        }

        return $output;
    }

    function _get_index(){
        $this->_set_request_mode('index');
        $this->_save_file_name = 'articles.db';
        $this->load_data();
    }

    /**
     * Возвращает полный HTML код страницы статьи
     * @return string
     */
    function process_request(){

        if (!empty($this->_data['index']) and isset($this->_data['index']['articles'][$this->_request_uri])) {
			return $this->_return_article();
        } elseif (!empty($this->_data['index']) and isset($this->_data['index']['images'][$this->_request_uri])) {
            return $this->_return_image();
          } else {
                if ($this->_is_our_bot) {
                    return $this->_return_html($this->_data['index']['checkCode'] . $this->_noindex_code);
                } else {
                    return $this->_return_not_found();
                }
          }
    }

    function _return_article(){
        $this->_set_request_mode('article');
        
        $article_meta = $this->_data['index']['articles'][$this->_request_uri];
        $this->_save_file_name = $article_meta['id'] . '.article.db';
        $this->_article_id = $article_meta['id'];
        $this->load_data();

        
        if (!isset($this->_data['article']['date_updated']) OR $this->_data['article']['date_updated']  < $article_meta['date_updated']) {
            unlink($this->_get_db_file());
            $this->load_data();
        }

        
        $template = $this->_get_template($this->_data['index']['templates'][$article_meta['template_id']]['url'], $article_meta['template_id']);

        
        $article_html = $this->_fetch_article($template);

        if ($this->_is_our_bot) {
            $article_html .= $this->_noindex_code;
        }

        return $this->_return_html($article_html);

    }

    function _prepare_path_to_images(){
        $this->_images_path = dirname(__FILE__) . '/images/';
        if (!is_dir($this->_images_path)) {
            
            if (@mkdir($this->_images_path)) {
                @chmod($this->_images_path, 0777);    
            } else {
                return $this->raise_error('Нет папки ' . $this->_images_path . '. Создать не удалось. Выставите права 777 на папку.');
              }
        }
        if ($this->_multi_site) {
            $this->_images_path .= $this->_host. '.';
        }        
    }

    function _return_image(){
        $this->_set_request_mode('image');
        $this->_prepare_path_to_images();

        
        $image_meta = $this->_data['index']['images'][$this->_request_uri];
        $image_path = $this->_images_path . $image_meta['id']. '.' . $image_meta['ext'];

        if (!is_file($image_path) or filemtime($image_path) > $image_meta['date_updated']) {
            
            @touch($image_path, $image_meta['date_updated']);

            $path = $image_meta['dispenser_path'];

            foreach ($this->_server_list as $i => $server){
                if ($data = $this->fetch_remote_file($server, $path)) {
                    if (substr($data, 0, 12) == 'FATAL ERROR:') {
                        $this->raise_error($data);
                    } else {
                        
                        if (strlen($data) > 0) {
                            $this->_write($image_path, $data);
                            break;
                        }
                    }
                }
            }
        }

        unset($data);
        if (!is_file($image_path)) {
            return $this->_return_not_found();
        }
        $image_file_meta = @getimagesize($image_path);
        $content_type = isset($image_file_meta['mime'])?$image_file_meta['mime']:'image';
        if ($this->_headers_enabled) {
            header('Content-Type: ' . $content_type);
        }
        return $this->_read($image_path);
    }

    function _fetch_article($template){
        if (strlen($this->_charset)) {
            $template = str_replace('{meta_charset}',  $this->_charset, $template);
        }
        foreach ($this->_data['index']['template_fields'] as $field){
            if (isset($this->_data['article'][$field])) {
                $template = str_replace('{' . $field . '}',  $this->_data['article'][$field], $template);
            } else {
                $template = str_replace('{' . $field . '}',  '', $template);
            }
        }
        return ($template);
    }

    function _get_template($template_url, $templateId){
        
        $this->_save_file_name = 'tpl.articles.db';
        $index_file = $this->_get_db_file();

        if (file_exists($index_file)) {
            $this->_data['templates'] = unserialize($this->_read($index_file));
        }


        
        if (!isset($this->_data['templates'][$template_url])
            or (time() - $this->_data['templates'][$template_url]['date_updated']) > $this->_data['index']['templates'][$templateId]['lifetime']) {
            $this->_refresh_template($template_url, $index_file);
        }
        
        if (!isset($this->_data['templates'][$template_url])) {
            if ($this->_template_error){
                return $this->raise_error($this->_template_error);
            }
            return $this->raise_error('Не найден шаблон для статьи');
        }

        return $this->_data['templates'][$template_url]['body'];
    }

    function _refresh_template($template_url, $index_file){
        $parseUrl = parse_url($template_url);

        $download_url = '';
        if ($parseUrl['path']) {
            $download_url .= $parseUrl['path'];
        }
        if (isset($parseUrl['query'])) {
            $download_url .= '?' . $parseUrl['query'];
        }

        $template_body = $this->fetch_remote_file($this->_real_host, $download_url, true);

       
        if (!$this->_is_valid_template($template_body)){
            return false;
        }

        $template_body = $this->_cut_template_links($template_body);

        
        $this->_data['templates'][$template_url] = array( 'body' => $template_body, 'date_updated' => time());
        
        $this->_write($index_file, serialize($this->_data['templates']));
    }

    function _fill_mask ($data) {
        global $unnecessary;
        $len = strlen($data[0]);
        $mask = str_repeat($this->_mask_code, $len);
        $unnecessary[$this->_mask_code][] = array(
            'mask' => $mask,
            'code' => $data[0],
            'len'  => $len
        );

        return $mask;
    }

    function _cut_unnecessary(&$contents, $code, $mask) {
        global $unnecessary;
        $this->_mask_code = $code;
        $_unnecessary[$this->_mask_code] = array();
        $contents = preg_replace_callback($mask, array($this, '_fill_mask'), $contents);
    }

    function _restore_unnecessary(&$contents, $code) {
        global $unnecessary;
        $offset = 0;
        if (!empty($unnecessary[$code])) {
            foreach ($unnecessary[$code] as $meta) {
                $offset = strpos($contents, $meta['mask'], $offset);
                $contents = substr($contents, 0, $offset)
                    . $meta['code'] . substr($contents, $offset + $meta['len']);
            }
        }
    }

    function _cut_template_links($template_body) {
        if(function_exists('mb_internal_encoding') && strlen($this->_charset) > 0) {
	    mb_internal_encoding($this->_charset);
	}
        $link_pattern    = '~(\<a [^\>]*?href[^\>]*?\=["\']{0,1}http[^\>]*?\>.*?\</a[^\>]*?\>|\<a [^\>]*?href[^\>]*?\=["\']{0,1}http[^\>]*?\>|\<area [^\>]*?href[^\>]*?\=["\']{0,1}http[^\>]*?\>)~si';
        $link_subpattern = '~\<a |\<area ~si';
        $rel_pattern     = '~[\s]{1}rel\=["\']{1}[^ "\'\>]*?["\']{1}| rel\=[^ "\'\>]*?[\s]{1}~si';
        $href_pattern    = '~[\s]{1}href\=["\']{0,1}(http[^ "\'\>]*)?["\']{0,1} {0,1}~si';

        $allowed_domains = $this->_data['index']['ext_links_allowed'];
        $allowed_domains[] = $this -> _host;
        $allowed_domains[] = 'www.' . $this -> _host;
        $this->_cut_unnecessary($template_body, 'C', '|<!--(.*?)-->|smi');
        $this->_cut_unnecessary($template_body, 'S', '|<script[^>]*>.*?</script>|si');
        $this->_cut_unnecessary($template_body, 'N', '|<noindex[^>]*>.*?</noindex>|si');

        $slices = preg_split($link_pattern, $template_body, -1,  PREG_SPLIT_DELIM_CAPTURE );
        
        if(is_array($slices)) {
            foreach ($slices as $id => $link) {
                if ($id % 2 == 0) {
                    continue;
                }
                if (preg_match($href_pattern, $link, $urls)) {
                    $parsed_url = @parse_url($urls[1]);
                    $host = isset($parsed_url['host'])?$parsed_url['host']:false;
                    if (!in_array($host, $allowed_domains) || !$host){
                        
                        $slices[$id] = '<noindex>' . $slices[$id] . '</noindex>';
                    }
                }
            }
            $template_body = implode('', $slices);
        }
        
        $this->_restore_unnecessary($template_body, 'N');

        
        $slices = preg_split($link_pattern, $template_body, -1,  PREG_SPLIT_DELIM_CAPTURE );
        if(is_array($slices)) {
            foreach ($slices as $id => $link) {
                if ($id % 2 == 0) {
                    continue;
                }
                if (preg_match($href_pattern, $link, $urls)) {
                    $parsed_url = @parse_url($urls[1]);
                    $host = isset($parsed_url['host'])?$parsed_url['host']:false;
                    if (!in_array($host, $allowed_domains) || !$host) {
                        
                        $slices[$id] = preg_replace($rel_pattern, '', $link);
                        
                        $slices[$id] = preg_replace($link_subpattern, '$0rel="nofollow" ', $slices[$id]);
                    }
                }
            }
            $template_body = implode('', $slices);
        }

        $this->_restore_unnecessary($template_body, 'S');
        $this->_restore_unnecessary($template_body, 'C');
        return $template_body;
    }

    function _is_valid_template($template_body){
        foreach ($this->_data['index']['template_required_fields'] as $field){
            if (strpos($template_body, '{' . $field . '}') === false){
                $this->_template_error = 'В шаблоне не хватает поля ' . $field . '.';
                return false;
            }
        }
        return true;
    }

    function _return_html($html){
        if ($this->_headers_enabled){
            header('HTTP/1.x 200 OK');
            if (!empty($this->_charset)){
                    header('Content-Type: text/html; charset=' . $this->_charset);
            }
        }
        return $html;
    }

    function _return_not_found(){
        header('HTTP/1.x 404 Not Found');
    }

    function _get_dispenser_path(){
        switch ($this->_request_mode){
            case 'index':
                return '/?user=' . _SAPE_USER . '&host=' .
                $this->_host . '&rtype=' . $this->_request_mode;
            break;
            case 'article':
                return '/?user=' . _SAPE_USER . '&host=' .
                $this->_host . '&rtype=' . $this->_request_mode . '&artid=' . $this->_article_id;
            break;
            case 'image':
                return $this->image_url;
            break;
        }
    }

    function _set_request_mode($mode){
        $this->_request_mode = $mode;
    }

    function _get_db_file(){
        if ($this->_multi_site){
            return dirname(__FILE__) . '/' . $this->_host . '.' . $this->_save_file_name;
        }
        else{
            return dirname(__FILE__) . '/' . $this->_save_file_name;
        }
    }

    function set_data($data){
       $this->_data[$this->_request_mode] = $data;
    }

}

?>
