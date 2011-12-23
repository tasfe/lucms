<?php
class PHPLicense extends Think{
	public $HASH_KEY = '80dSbqylf4Cu5e5OYdAoAVkzpsdA51P9w8p27sYDU52ZBJprdRL1KE0qa8W66qE0yHS0ZXQCceil8KQU60wohX2gd7uVhjxbS8g4y874Ht8L12W54Q6T4R4a';
	public $HASH_WRAP = 'ant9pbc3OK28Li36MiwcM9z0v4tRDWAt7J1VXuKCK3QSN4a9Z2IlG7R7ct4d3fsWJjwzDmN7YT06mVFbljsOmBuc9J4wa2Bh6j8KB3vbEXB18i6gfby62T';
	public $HASH_ORDER = 'H|I|O|M|B|F|G|E|R|C|S|X'; //字母不可重复
	public $BEGINSTR = 'BEGIN LICENSE KEY';
	public $ENDSTR = 'END LICENSE KEY';
	public $_WRAPTO = 80;
	public $_PAD = "-";
	public $msg = '';
	protected $_LICENSEPATH = '';
	/**
	* init the linebreak var
	*/
	protected $_SERVER_INFO = array (
		'LISENSE_DOMAIN' => '-',
		'LISENSE_IP' => '-',
		'LISENSE_MAC' => '-',
		'LISENSE_STARTDATE' => '-',
		'LISENSE_ENDDATE' => '-',
		'LISENSE_USER' => '-',
	);
	public $_LINEBREAK;
	function PHPLicense() {
		$this->_LINEBREAK = $this->_get_os_linebreak();
		$this->_SERVER_INFO['LISENSE_DOMAIN'] = C('LISENSE_DOMAIN');
		$this->_SERVER_INFO['LISENSE_IP'] = C('LISENSE_IP');
		$this->_SERVER_INFO['LISENSE_MAC'] = C('LISENSE_MAC');
		$this->_SERVER_INFO['LISENSE_STARTDATE'] = C('LISENSE_STARTDATE');
		$this->_SERVER_INFO['LISENSE_ENDDATE'] = C('LISENSE_ENDDATE');
		$this->_SERVER_INFO['LISENSE_USER'] = C('LISENSE_USER');
		$this->_LICENSEPATH = C('LISENSE_PATH').'/License.dat';
	}
	/*
	 * 检测License合法性;
	 * 
	 * 
	 */
	public function checkLicense($checkmac = false,$checkdomain = false, $checkdate  = false, $checkip = false) {
		$filename = $this->_LICENSEPATH;
		$dat_str =  @file_get_contents($filename);
		if(strlen($dat_str)>0)
		{
			$decode = $this->_unwrap_encrypt($dat_str);
			$allmark = 0;
			foreach($decode as $acode){
				if($acode != '-') $allmark = 1;
			}
			if(!$allmark) {
				$this->msg = 'License 参数错误！';
				return false;
			}
			if(strtolower($decode['LISENSE_DOMAIN']) != strtolower($this->_SERVER_INFO['LISENSE_DOMAIN'])) {
					$this->msg = 'License 域名不匹配1';
					return false;
			}
			if($decode['LISENSE_IP'] != $this->_SERVER_INFO['LISENSE_IP']) {
					$this->msg = 'License IP不匹配1';
					return false;
			}
			if(strtolower($decode['LISENSE_MAC']) != strtolower($this->_SERVER_INFO['LISENSE_MAC'])){
					$this->msg = 'License MAC不匹配1';
					return false;
				}
			if($decode['LISENSE_STARTDATE'] != $this->_SERVER_INFO['LISENSE_STARTDATE']) {
						$this->msg = 'License 开始日期不匹配1';
						return false;
			} 
			if($decode['LISENSE_ENDDATE'] != $this->_SERVER_INFO['LISENSE_ENDDATE']) {
						$this->msg = 'License 过期日期不匹配1';
						return false;
					} 
			if($decode['LISENSE_USER'] != $this->_SERVER_INFO['LISENSE_USER'])  {
						$this->msg = 'License 用户名不匹配1';
						return false;
			} 
			if($checkmac){
				$localmac = $this->get_mac_address();
				if(count($localmac) == 1){
					if(strtolower($localmac[0]) != strtolower($decode['LISENSE_MAC']) ){
					$this->msg = 'License MAC不匹配2';
					return false;
					}
				}else{
					if(array_search(strtolower($decode['LISENSE_MAC']),$localmac) == null) {
						$this->msg = 'License MAC不匹配2';
						return false;
					}
				}
			}
			if($checkdomain){
				$localdomain = $this->get_domain_name();
				if($decode['LISENSE_DOMAIN']!='-'){
					if($localdomain != $decode['LISENSE_DOMAIN']){
						$this->msg = 'License 域名不匹配2';
						return false;
					} 
				}
				
			}
			if($checkdate){
				$nowtime = time();
				if($decode['LISENSE_STARTDATE'] != '-') {
					$tarr =explode("-",$decode['LISENSE_STARTDATE']);
					$starttime = mktime(0,0,0,$tarr[1],$tarr[2],$tarr[0]);
					if($nowtime < $starttime){
						$this->msg = 'License 未到使用日期2';
						return false;
					} 
				}
				if($decode['LISENSE_ENDDATE'] != '-') {
					$tarr =explode("-",$decode['LISENSE_ENDDATE']);
					$endtime = mktime(0,0,0,$tarr[1],$tarr[2],$tarr[0]);
					if($nowtime > $endtime) {
						$this->msg = 'License 已经过期2';
						return false;
					} 
				}
			}
			if($checkip){
				
			}
			return true;
		}
		return false;
	}
	public function generateLicense($serverinfo = array()) {
		if(empty($serverinfo)) $serverinfo = $this->_SERVER_INFO;
		$filename = $this->_LICENSEPATH;
		$code = $this->_wrap_encrypt($serverinfo);
	    header("Content-disposition:filename=License.dat");//所保存的文件名
	    header("Content-type:application/octetstream");
	    header("Pragma:no-cache");
	    header("Expires:0");
	    print $code;
		//$h = fopen($filename, 'w');
		# if write fails return error
		//if(fwrite($h, $code) === false) return false;
		//fclose($h);
		//return true;
	}

	/**
	* _encrypt
	*
	* 加密
	*
	* @access private 
	* @param $src_array array The data array that contains the key data
	* @return string Returns the encrypted string
	**/
	protected function _encrypt($src_array) {
		$rand_add_on = $this->_generate_random_string(8);
		# get the key
		$key = $this->HASH_KEY;
		$key = $rand_add_on . $key;
		# init the vars
		$crypt = '';
		$str = serialize($src_array);
		# loop through the str and encrypt it
		for ($i = 1; $i <= strlen($str); $i++) {
			$char = substr($str, $i -1, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char = chr(ord($char) + ord($keychar));
			$crypt .= $char;
		}

		//第一次加密base64
		$fstr = base64_encode(trim($crypt));
		//echo '1:'.$fstr.'<br/>';
		//第二次加密md5
		$key_order = explode('|', $this->HASH_ORDER);
		foreach ($key_order as $aorder) {
			$fstr = str_replace($aorder, '<|' . $aorder . '|>', $fstr);
		}
		foreach ($key_order as $aorder) {
			$md5str = substr(md5(md5($aorder)), 0, 12);
			$fstr = str_replace('<|' . $aorder . '|>', $md5str, $fstr);
		}
		//echo '2:'.$fstr.'<br/>';
		//第三次加密base64
		$fstr = base64_encode(base64_encode(trim($fstr)));
		# return the key
		//echo '3:'.$fstr.'<br/>';
		return $rand_add_on . $fstr;
	}
	/**
	* _decrypt
	*
	* 解密
	*
	* @access private 
	* @param $enc_string string The key string that contains the data
		* @return array Returns decrypted array
	**/
	public function _decrypt($str) {
		$rand_add_on = substr($str, 0, 8);
		//初始解密第三次base64
		$str = base64_decode(base64_decode(substr($str, 8)));
		//初始解密第二次md5
		$key_order = explode('|', $this->HASH_ORDER);
		foreach ($key_order as $aorder) {
			$md5str = substr(md5(md5($aorder)), 0, 12);
			$str = str_replace($md5str, $aorder, $str);
		}
		//初始解密第二次base64
		$str = base64_decode(trim($str));
		# get the key
		$key = $rand_add_on . $this->HASH_KEY;
		$decrypt = '';
		# loop through the text and decode the string
		for ($i = 1; $i <= strlen($str); $i++) {
			$char = substr($str, $i -1, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char = chr(ord($char) - ord($keychar));
			$decrypt .= $char;
		}
		# return the key
		return unserialize($decrypt);
	}
	/**
	* _pad
	*
	* pad out the begin and end seperators
	*
	* @access private 
	* @param $str string The string to be padded
	* @return string Returns the padded string
	**/
	public function _pad($str) {
		$str_len = strlen($str);
		$spaces = ($this->_WRAPTO - $str_len) / 2;
		$str1 = '';
		for ($i = 0; $i < $spaces; $i++) {
			$str1 = $str1 . $this->_PAD;
		}
		if ($spaces / 2 != round($spaces / 2)) {
			$str = substr($str1, 0, strlen($str1) - 1) . $str;
		} else {
			$str = $str1 . $str;
		}
		$str = $str . $str1;
		return $str;
	}
	protected function _wrap_encrypt($src_array) {
			# sort the variables
			$begin 	= $this->_pad($this->BEGINSTR);
			$end 	= $this->_pad($this->ENDSTR);
			# encrypt the data
			$str = $this->_encrypt($src_array);
			# return the wrap
			return $begin.$this->_LINEBREAK.wordwrap($str, $this->_WRAPTO, $this->_LINEBREAK, 1).$this->_LINEBREAK.$end;
	}
	protected function _unwrap_encrypt($enc_str) {
			# sort the variables
			$begin 	= $this->_pad($this->BEGINSTR);
			$end 	= $this->_pad($this->ENDSTR);
			
			# get string without seperators
			$str 	= trim(str_replace(array($begin, $end, "\r", "\n", "\t"), '', $enc_str));

			# decrypt and return the key
			return $this->_decrypt($str);
	}
	/**
	* _get_os_linebreak
	*
	* get's the os linebreak
	*
	* @access private 
	* @param $true_val boolean If the true value is needed for writing files, make true
	*							defaults to false
		* @return string Returns the os linebreak
	**/
	public function _get_os_linebreak($true_val = false) {
		$os = strtolower(PHP_OS);
		switch ($os) {
			# not sure if the string is correct for FreeBSD
			# not tested
			case 'freebsd' :
				# not sure if the string is correct for NetBSD
				# not tested
			case 'netbsd' :
				# not sure if the string is correct for Solaris
				# not tested
			case 'solaris' :
				# not sure if the string is correct for SunOS
				# not tested
			case 'sunos' :
				# linux variation
				# tested on server
			case 'linux' :
				$nl = "\n";
				break;
				# darwin is mac os x
				# tested only on the client os
			case 'darwin' :
				# note os x has \r line returns however it appears that the ifcofig
				# file used to source much data uses \n. let me know if this is
				# just my setup and i will attempt to fix.
				if ($true_val)
					$nl = "\r";
				else
					$nl = "\n";
				break;
				# defaults to a win system format;
			default :
				$nl = "\r\n";
		}
		return $nl;
	}
	/**
	* _get_os_var
	*
	* gets various vars depending on the os type 
	*
	* @access private 
		* @return string various values
	**/
	function _get_os_var($var_name, $os) {
		$var_name = strtolower($var_name);
		# switch between the os's
		switch ($os) {
			# not sure if the string is correct for FreeBSD
			# not tested
			case 'freebsd' :
				# not sure if the string is correct for NetBSD
				# not tested
			case 'netbsd' :
				# not sure if the string is correct for Solaris
				# not tested
			case 'solaris' :
				# not sure if the string is correct for SunOS
				# not tested
			case 'sunos' :
				# darwin is mac os x
				# tested only on the client os
			case 'darwin' :
				# switch the var name
				switch ($var_name) {
					case 'conf' :
						$var = '/sbin/ifconfig';
						break;
					case 'mac' :
						$var = 'ether';
						break;
					case 'ip' :
						$var = 'inet ';
						break;
				}
				break;
				# linux variation
				# tested on server
			case 'linux' :
				# switch the var name
				switch ($var_name) {
					case 'conf' :
						$var = '/sbin/ifconfig';
						break;
					case 'mac' :
						$var = 'HWaddr';
						break;
					case 'ip' :
						$var = 'inet addr:';
						break;
				}
				break;
		}
		return $var;
	}

	/**
	* _get_config
	*
	* gets the server config file and returns it. tested on Linux, 
	* Darwin (Mac OS X), and Win XP. It may work with others as some other
	* os's have similar ifconfigs to Darwin but they haven't been tested
	*
	* @access private 
		* @return string config file data
	**/
	public function _get_config() {
		if (ini_get('safe_mode')) {
			# returns invalid because server is in safe mode thus not allowing 
			# sbin reads but will still allow it to open. a bit weird that one.
			return 'SAFE_MODE';
		}
		# if anyone has any clues for windows environments
		# or other server types let me know
		$os = strtolower(PHP_OS);
		if (substr($os, 0, 3) == 'win') {
			# this windows version works on xp running apache 
			# based server. it has not been tested with anything
			# else, however it should work with NT, and 2000 also

			# execute the ipconfig
			@ exec('ipconfig/all', $lines);
			# count number of lines, if none returned return MAC_404
			# thanks go to Gert-Rainer Bitterlich <bitterlich -at- ima-dresden -dot- de>
			if (count($lines) == 0)
				return 'ERROR_OPEN';
			# $path the lines together
			$conf = implode($this->_LINEBREAK, $lines);
		} else {
			# get the conf file name
			$os_file = $this->_get_os_var('conf', $os);
			# open the ipconfig
			$fp = @ popen($os_file, "rb");
			# returns invalid, cannot open ifconfig
			if (!$fp)
				return 'ERROR_OPEN';
			# read the config
			$conf = @ fread($fp, 4096);
			@ pclose($fp);
		}
		return $conf;
	}

	/**
	* _get_ip_address
	*
	* Used to get the MAC address of the host server. It works with Linux,
	* Darwin (Mac OS X), and Win XP. It may work with others as some other
	* os's have similar ifconfigs to Darwin but they haven't been tested
	*
	* @access private 
		* @return array IP Address(s) if found (Note one machine may have more than one ip)
		* @return string ERROR_OPEN means config can't be found and thus not opened
		* @return string IP_404 means ip adress doesn't exist in the config file and can't be found in the $_SERVER
		* @return string SAFE_MODE means server is in safe mode so config can't be read
	**/
	public function get_ip_address() {
		$ips = array ();
		# get the cofig file
		$conf = $this->_get_config();
		# if the conf has returned and error return it
		if ($conf != 'SAFE_MODE' && $conf != 'ERROR_OPEN') {
			# if anyone has any clues for windows environments
			# or other server types let me know
			$os = strtolower(PHP_OS);
			if (substr($os, 0, 3) == 'win') {
				return 'get_ip_on_win';
			} else {
				# explode the conf into seperate lines for searching
				$lines = explode($this->_LINEBREAK, $conf);
				print_r($lines);
				# get the ip delim
				$ip_delim = $this->_get_os_var('ip', $os);

				# ip pregmatch 
				$num = "(\\d|[1-9]\\d|1\\d\\d|2[0-4]\\d|25[0-5])";
				# seperate the lines
				foreach ($lines as $key => $line) {
					# check for the ip signature in the line
					if (!preg_match("/^$num\\.$num\\.$num\\.$num$/", $line) && strpos($line, $ip_delim)) {
						# seperate out the ip
						$ip = substr($line, strpos($line, $ip_delim) + strlen($ip_delim));
						$ip = trim(substr($ip, 0, strpos($ip, " ")));
						# add the ip to the collection
						if (!isset ($ips[$ip]))
							$ips[$ip] = $ip;
					}
				}
			}
		}
		# count return ips and return if found
		if (count($ips) > 0)
			return $ips;
		# failed to find an ip check for conf error or return 404
		if ($conf == 'SAFE_MODE' || $conf == 'ERROR_OPEN')
			return $conf;
		return 'IP_404';
	}

	/**
	* _get_mac_address
	*
	* Used to get the MAC address of the host server. It works with Linux,
	* Darwin (Mac OS X), and Win XP. It may work with others as some other
	* os's have similar ifconfigs to Darwin but they haven't been tested
	*
	* @access private 
		* @return string Mac address if found
		* @return string ERROR_OPEN means config can't be found and thus not opened
		* @return string MAC_404 means mac adress doesn't exist in the config file
		* @return string SAFE_MODE means server is in safe mode so config can't be read
	**/
	public function get_mac_address() {
		$sysos = 'win';
		$temp_array = array ();
		$mac_array = array ();
		$mac_addr = array ();
		if (PATH_SEPARATOR == ':')
			$sysos = 'linux';
		if ($sysos == 'win') {
			$temp_array = $this->_get_mac_forWindows();
		} else {
			$temp_array = $this->_get_mac_forLinux();
		}
		foreach ($temp_array as $value) {
			if (preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" .
				"[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $value, $mac_array)) {
				$mac_addr[] = strtolower($mac_array[0]);
				$mac_array = array ();
			}
		}
		return $mac_addr;
	}
	public function get_domain_name(){
		return $_SERVER['SERVER_NAME'];;
	}
	protected function _get_mac_forWindows() {
		$return_array = array ();
		@ exec("ipconfig /all", $return_array);

		if ($return_array) {
			return $return_array;
		} else {
			$ipconfig = $_SERVER["SystemRoot"] . "\system32\ipconfig.exe";
			if (is_file($ipconfig)) {
				@ exec($ipconfig . " /all", $return_array);
			} else {
				@ exec($_SERVER["WINDIR"] . "\system\ipconfig.exe /all", $return_array);
			}
			return $return_array;
		}
	}
	protected function _get_mac_forLinux() {
		$return_array = array ();
		@ exec("ifconfig  -a", $return_array);
		return $return_array;
	}

	/**
	* _generate_random_string
	*
	* 生成定长随即字符窜
	*
	* @access private 
	* @param $length number The length of the random string
	* @param $seeds string The string to pluck the characters from
	* @return string Returns random string
	**/
	public function _generate_random_string($length = 10, $seeds = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890123456789') {
		$str = '';
		$seeds_count = strlen($seeds);

		list ($usec, $sec) = explode(' ', microtime());
		$seed = (float) $sec + ((float) $usec * 100000);
		mt_srand($seed);

		for ($i = 0; $length > $i; $i++) {
			$str .= $seeds {
				mt_rand(0, $seeds_count -1)
				};
		}
		return $str;
	}
}
?>