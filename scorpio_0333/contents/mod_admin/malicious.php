<?

	/* SCORPIO engine - index.php - v3.30		*/	
	/* created on 2006-12-31	 				*/
	/* updated on 2009-02-23	 				*/	
	/* YYY							43/29/0		*/

	//e(exec('whoami'));

	if (is_allowed(6)) {
		//name, pass, server
		$SITES['aubergeduzoo'] 		= array('auberge du zoo', 'Au8erGE');
		$SITES['agora'] 			= array('agora de la danse', 'D4N53d4n53');
		$SITES['apag'] 				= array('apag', '4pAgaP4G');
		$SITES['batteries'] 		= array('batteries', 'P1leF4ce');
		$SITES['bresee'] 			= array('bresee inc', '8Br3S331nc');
		$SITES['cab'] 				= array('cab cowansville', 'c0Wansv1llE');
		$SITES['cata'] 				= array('cata performance', 'V01les');
		$SITES['cata'] 				= array('colle-bebe', 'V01les');		
		$SITES['mperrier'] 			= array('centre michel perrier', '8774dent5');
		$SITES['cira'] 				= array('cira uniformes', 'uNif0rMe5');
		$SITES['infomatrix'] 		= array('consultation infomatrix', 'InFO34Tr1X');
		$SITES['epilepsiegranby'] 	= array('epilepsie granby', 'Epgr4nBY');
		$SITES['fermejanecek'] 		= array('fermejanecek', 'J4necek');	
		$SITES['gisa'] 				= array('gisa solutions', 'S0luT1on5');
		$SITES['oracle'] 			= array('gn-oracle', 'frosty2k7');
		$SITES['gperron'] 			= array('gperron', 'F155ure');	
		$SITES['grb-inc'] 			= array('grb-inc', 'Aut0mation');
		$SITES['josianne'] 			= array('josianne  fortier', 'NewL1fe');
		$SITES['lamaisonhatley'] 	= array('la maison hathley', 'Hh4aTtLl3eYy');
		$SITES['lavieilleforge'] 	= array('la vieille forge', 'fF0rgeE');
		$SITES['laundromat'] 		= array('laundromat', 'StufF');	
		$SITES['lebelart'] 			= array('lebel art', 'fUneR41re');	
		$SITES['lettradecor'] 		= array('lettra-decor', 'l3TdeC0R');
		$SITES['maisonronde'] 		= array('maison ronde sutton', '5uTt0N');
		$SITES['tanguay'] 			= array('meuble bernard tanguay', '3eu88Le');	
		$SITES['meubles'] 			= array('meubles du village', '3nB0i5');
		$SITES['mieuxetrespa'] 		= array('mieux etre spa', 'm455Ag3');		
		$SITES['miffinc'] 			= array('miffinc', '3M1iFfiNC');	
		$SITES['mobilium'] 			= array('mobilium', '3o81LiuMm');
		$SITES['portaillaitier'] 	= array('portaillaitier', '7L41tiEr');		
		$SITES['premium'] 			= array('premium', '1rRiGati0N');
		$SITES['chevaux'] 			= array('remorques a chevaux', 'cH4Vv0');		
		$SITES['sechoisir'] 		= array('se choisir sainement', 'sa1n3menT');	
		$SITES['sercodesign'] 		= array('serco design', '2s1GN');				
		$SITES['speedygym'] 		= array('speedy gym', 'N1nj4');		
		$SITES['sylvainalix'] 		= array('sylvain alix', '4l1xxx');	
		$SITES['yyy'] 				= array('yyy', 'H7mp9S6n60r5'); 	
		$SITES['voyages'] 			= array('voyages liquidation', '63r240Ep45O6');
		$SITES['voyagesprix'] 		= array('voyages prix', '59G693k39Q6c');		
		$SITES['zygomatyk'] 		= array('zygomatyk', 'H0tSh0w');

		$ftp_server = "67.222.142.190" ; 

		if (isset($_GET['s'])) {
			$site_start = $_GET['s'];
		} else {
			$site_start = 1;
		}

		if (isset($_GET['l'])) {
			$site_limit = $_GET['l'];
		} else {
			$site_limit = 40;
		}

		if (isset($_GET['d'])) {
			$depth = $_GET['d'];
		} else {
			$depth = 3;
		}

		if (isset($_GET['v'])) {
			$valid_date = $_GET['v'];
		} else {
			$valid_date = time() - 60*60*24*7;//1241150400  1242792000  1243051200
		}

		global $NOW;

		$NOW = getdate(TIME);
		$now_month 	= $NOW['mon'];
		$now_day 	= $NOW['day'];
	
		$VALID = getdate($valid_date);
		$valid_month 	= $VALID['mon'];
		$valid_day 		= $VALID['day'];	
		
		$EXT_HIDDEN = array('jpg', 'gif', 'png', 'JPG', 'pdf', 'css', 'swf', 'xls', 'xml', 'txt');
		$PROTECTED = array('files', 'httpdocs');
		
		global $DIR;	
		
		if (isset($_GET['remove'])) {		
			$conn_id = ftp_connect($ftp_server) /* or (die("Couldn't connect to $ftp_server"))*/;
			$login_result = ftp_login($conn_id, $_GET['site'], $SITES[$_GET['site']][1]);
			
			if (ftp_delete($conn_id, $_GET['remove'])) {
				//echo "ok";
			} else {
			 	echo "prout";
			}			
		}
		
		if (isset($_GET['rename'])) {	
			$conn_id = ftp_connect($ftp_server) /* or (die("Couldn't connect to $ftp_server"))*/;
			$login_result = ftp_login($conn_id, $_GET['site'], $SITES[$_GET['site']][1]);
			ftp_chdir($conn_id, $_GET['path']);
			
			if (ftp_rename($conn_id, $_GET['rename'], '_' . $_GET['rename'])) {
				//echo "ok, renamed to " . '_' . $_GET['rename'];
			} else {
			 	echo "prout";
			}			
		}		
		
		//} else {		
			foreach($SITES as $name => $SITE) {
				$site_count++;
	
				if ($site_count >= $site_start && $site_count < ($site_start + $site_limit)) {
					$ftp_user_name = trim($name);
					$ftp_user_pass = trim($SITE[1]);
					
					$conn_id = ftp_connect($ftp_server) /* or (die("Couldn't connect to $ftp_server"))*/;
					$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
					
					if ($login_result) {
						ftp_dir($conn_id, $depth);
								
						$dir_count = count($DIR);		
								
						foreach ($DIR as $filepath => $FILE) {
										
							if ($FILE['date'] >= $valid_date && !in_array(substr($filepath,-3), $EXT_HIDDEN)) {
								$POTENTIAL[$filepath] = $FILE;
	//e($FILE);
								if (!in_array($FILE['name'], $PROTECTED)) {
									$remove_url = url('remove ', '?p=malicious&site=' . $name .'&remove=' . urlencode($filepath));
									$rename_url = url('rename ', '?p=malicious&site=' . $name .'&rename=' . urlencode($FILE['name']) .'&path=' . urlencode($FILE['path']));
								} else {
									$remove_url = '<font color="red">PROTECTED</font>';
								}
				
								$rows .= tr(td(spacer($FILE['level']) . $filepath) . td($FILE['day']) . td($FILE['month']) . td($FILE['year']) . td($FILE['time']) . ' ' . td($remove_url) . td($rename_url));
							
								$remove_url = '';
								$rename_url = '';
							}
						}
						
						$DIR = '';
					} else {
						$message = ' <font color="red"> failed</font> with : ' . $ftp_user_name;
						 
						$FAILED = $ftp_user_name;
					}
					
					ftp_close($conn_id);
					
					$head_row = tr(td($id . ' <b>' . $SITE[0] . '</b> (' . $dir_count . ') ' . $message));
					$final .= $head_row . $rows;
					$rows = '';
					$message = '';
				}
			}
			
			$html .= table($final);	
			$return = $html;
		//}
	} else {
		$return .= 'must be admin';
	}

	function ftp_dir($conn_id, $depth, $dir='/', $lev=1) {
		$lev++;
		
		global $DIR;
		global $NOW;
		
		$now_month 	= $NOW['mon'];
		$now_day 	= $NOW['day'];	
			
		$RAW = ftp_rawlist($conn_id, $dir);
		$FILES = parse_ftp_rawlist($RAW);	
 
		foreach ($FILES as $FILE) {
			if(strstr($FILE['time/year'], ':')) {//hour (last year)
				$MONTH = getdate(strtotime($FILE['month'] . ' ' . $FILE['day'] . ' + 1 day'));
				$file_month = $MONTH['mon'];
				$file_day = $MONTH['day'];

				if($file_month <= $now_month && $file_day <= $now_day) {
					$FILE['year'] = 2009;
					$FILE['time'] = $FILE['time/year'];					
				} else {
					$FILE['year'] = 2008;
					$FILE['time'] = $FILE['time/year'];					
				}	
			} else {
				$FILE['year'] = $FILE['time/year'];
				$FILE['time'] = '';
			}
			
			$FILE['path'] = $dir;
			$FILE['level'] = $lev;
			$FILE['date'] = strtotime($FILE['day'] . $FILE['month'] . $FILE['year']);
			
			$DIR[$FILE['path'] . $FILE['name']] = $FILE;	
					
			if($FILE['isdir'] && $lev <= $depth) {
				$path = $FILE['path'] . $FILE['name'] . '/';
				$CHILDS = ftp_dir($conn_id, $depth, $path, $lev);
			}		
		}
		
		return $DIR;
	}



	function directoryToArray($directory, $extension="", $full_path = true) {
		$array_items = array();
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($directory. "/" . $file)) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $extension, $full_path)); 
					}
					else { 
						if(!$extension || (ereg("." . $extension, $file)))
						{
							if($full_path) {
								$filepath = $directory . "/" . $file;
								
								//$array_items[$filepath] = $filepath;
								$array_items[$filepath]['filename'] = $file;
								$array_items[$filepath]['filedate'] = fileatime($filepath);
								$array_items[$filepath]['fileext'] = substr($filepath, -3);
							}
							else {
								$array_items[] = $file;
							}
						}
					}
				}
			}
			closedir($handle);
		}
		return $array_items;
	}




	function parse_ftp_rawlist($List, $Win = false)
	{
	  $Output = array();
	  $i = 0;
	  if ($Win) {
	    foreach ($List as $Current) {
	      ereg('([0-9]{2})-([0-9]{2})-([0-9]{2}) +([0-9]{2}):([0-9]{2})(AM|PM) +([0-9]+|) +(.+)', $Current, $Split);
	      if (is_array($Split)) {
	        if ($Split[3] < 70) {
	          $Split[3] += 2000;
	        }
	        else {
	          $Split[3] += 1900;
	        }
	        $Output[$i]['isdir']     = ($Split[7] == '');
	        $Output[$i]['size']      = $Split[7];
	        $Output[$i]['month']     = $Split[1];
	        $Output[$i]['day']       = $Split[2];
	        $Output[$i]['time/year'] = $Split[3];
	        $Output[$i]['name']      = $Split[8];
	        $i++;
	      }
	    }
	    return !empty($Output) ? $Output : false;
	  }
	  else {
	    foreach ($List as $Current) {
	      $Split = preg_split('[ ]', $Current, 9, PREG_SPLIT_NO_EMPTY);
	      if ($Split[0] != 'total') {
	        $Output[$i]['isdir']     = ($Split[0] {0} === 'd');
	        $Output[$i]['perms']     = $Split[0];
	        $Output[$i]['number']    = $Split[1];
	        $Output[$i]['owner']     = $Split[2];
	        $Output[$i]['group']     = $Split[3];
	        $Output[$i]['size']      = $Split[4];
	        $Output[$i]['month']     = $Split[5];
	        $Output[$i]['day']       = $Split[6];
	        $Output[$i]['time/year'] = $Split[7];
	        $Output[$i]['name']      = $Split[8];
			
	        $i++;
	      }
	    }
	    return !empty($Output) ? $Output : false;
	  }
	}	


	
?>