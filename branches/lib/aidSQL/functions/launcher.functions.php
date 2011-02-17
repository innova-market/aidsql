<?php

	function usageShort(aidSQL\core\Logger &$log){

		$info = $log->getX11Info();
		$log->setPrepend("");
		$log->setX11Info(FALSE);
		$log->log("--url\t\t\t\t<url>\t\t\tUse this URL to perform injection tests",0,"white");
		$log->log("--google\t\t\t<search term>\t\tJust Google it!",0,"white");
		$log->log("--help\t\t\t\tExtended help",0,"white");
		$log->setX11Info($info);
		
	}

	function hasAcceptedDisclaimer(\aidSQL\core\Logger &$log){

		if(!file_exists("DISCLAIMER.txt")){
			$log->log("DISCLAIMER FILE NOT FOUND, CANNOT CONTINUE!",1,"red");
			return FALSE;
		}

		if(!file_exists(".aidSQL_disclaimer_accepted")){

			$log->log(file_get_contents("DISCLAIMER.txt"));
			$log->log("DO YOU ACCEPT THIS DISCLAIMER?",0,"yellow");
			$selection	=	interactive($log,array("YES I ACCEPT THIS DISCLAIMER", "NO I DONT ACCEPT THIS DISCLAIMER"));

			if($selection[0]===0){

				$fp	=	fopen(".aidSQL_disclaimer_accepted",'w');
				fwrite($fp,'1');
				fclose($fp);

			}else{

				return FALSE;

			}

		}

		return TRUE;

	}

	function start(){

		if(defined("__START")){
			return;
		}

		define("__START",time());

	}

	function finish(aidSQL\core\Logger &$log,$totalVulnerableLinks=0){

		$total	=	time() - __START;
		$color	=	($totalVulnerableLinks > 0)	?	"light_green"	:	"yellow";
		$log->log("VULNERABLE LINKS FOUND\t: $totalVulnerableLinks",0,$color,TRUE);
		$log->log("TOTAL TIME\t\t\t: $total seconds",0,"light_cyan",TRUE);

	}

	function usageLong(aidSQL\core\Logger &$log){

		$log->setX11Info(FALSE);
		$log->setPrepend("");
	
		$log->log("\nGENERAL\n",0,"light_cyan");	
		$log->log("--url\t\t\t\t<url> Use this URL to perform injection tests",0,"white");
		$log->log("--immediate-mode\t\tQuit as soon as it finds a vulnerable spot (default yes)",0,"white");
		$log->log("--ignore-variables\t\tComma delimited list of variables to be ignored",0,"white");
		$log->log("--verbose\t\t\t0 => normal, 1 => verbose, 2 => more verbose",0,"white");
		$log->log("--list-links\t\t\tWill cause aidSQL only to list found links on the given page (combinable with interactive)",0,"white");
		$log->log("--no-shell\t\t\tDont attempt to get a shell",0,"white");
		$log->log("--shell-code\t\t\tSpecify your own shell code",0,"white");
		$log->log("--shell-name\t\t\tSpecify your own shell name",0,"white");
		$log->log("--no-schema\t\t\tDont get database schemas",0,"white");
		$log->log("--partial-schema\t\tDont get fields from all tables in the database schema",0,"white");
		$log->log("--decode-requests\t\tShow decoded requests",0,"white");
		$log->log("--wanted-schemas\t\t{current} = Get the current schema, {all} = get All, db1,db2,db3 your own choices",0,"white");
		$log->log("--makedb\t\t\tPath to aidSQL XML generated file (combinable with interactive)",0,"white");

		$log->log("\nGOOGLING\n",0,"light_cyan");	
		$log->log("--google\t\t\t<search term> Just Google it!",0,"white");
		$log->log("--google-language\t\tsearch in this language (default \"en\") accepts <es,de,it> amongst others",0,"white");
		$log->log("--google-max-results\t\tLimit the search to a maximum of results others",0,"white");
		$log->log("--google-offset\t\tOffset results (Use with care you can end with no sites)",0,"white");
		$log->log("--google-shuffle\t\tShuffle search results (default yes)",0,"white");

		$log->log("\nLOGGING\n",0,"light_cyan");	
		$log->log("--save-log\t\t\tFile where to dump results",0,"white");
		$log->log("--save-xml\t\t\tSave obtained schemas in XML format",0,"white");
		$log->log("--log-prepend-date\t\tPrepend date to log (default 0)",0,"white");
		$log->log("--colors\t\t\tActivate / Deactivate colors (default 1)",0,"white");

		$log->log("\nPLUGINS\n",0,"light_cyan");	
		$log->log("--list-plugins\t\t\tReturn a list of available plugins and their types",0,"white");
		$log->log("--sqli-plugins\t\t\tUse these plugins for sqli (default all)",0,"white");
		$log->log("--help-<type>-<name>\t\tIf you need help about a certain plugin",0,"white");

		$log->log("\nHTTP RELATED\n",0,"light_cyan");	
		$log->log("--http-method\t\t\tPOST or GET (default GET)",0,"white");
		$log->log("--http-adapter\t\t\tSwitch http adapter (default Ecurl) ",0,"white");
		$log->log("--connect-timeout\t\tConnect timeout for A ",0,"white");
		$log->log("--url-query-char\t\t(default ?)",0,"white");
		$log->log("--url-var-char\t\t\t(default &)",0,"white");
		$log->log("--url-equality-char\t\t(default =)",0,"white");
		$log->log("--url-path-char\t\t(default /)",0,"white");
		$log->log("--request-interval\t\tHTTP Request Interval (in microseconds)",0,"white");
		$log->log("--follow-redirects\t\tFollow HTTP 302 (default yes)",0,"white");
		$log->log("--proxy-server\t\t\tHost or IP of the proxy server",0,"white");
		$log->log("--proxy-user\t\t\tUsername for the proxy server (if requires authentication)",0,"white");
		$log->log("--proxy-password\t\tPassword for the proxy server (if requires authentication)",0,"white");
		$log->log("--proxy-port\t\t\tProxy port",0,"white");
		$log->log("--proxy-type\t\t\tProxy type [BASIC | NTLM] (default basic) ",0,"white");
		$log->log("--proxy-tunnel\t\t\tUse CONNECT method (default 0) ",0,"white");

		$log->log("\nSITE CRAWL\n",0,"light_cyan");
		$log->log("--crawl\t\t\t<depth> How many levels do you want the crawler to go (default 0)",0,"white");
		$log->log("--no-crawl\t\t\tDont crawl hrefs (default yes)",0,"white");
		$log->log("--omit-sites\t\t\tRegex for omitting certain sites when googling",0,"white");
		$log->log("--omit-paths\t\t\tcomma delimited list of paths to be ommited",0,"white");
		$log->log("--omit-pages\t\t\tcomma delimited list of pages to be ommited",0,"white");
		$log->log("--page-types\t\t\tPage types that should be taken in account when crawling a site",0,"white");
		$log->log("--lpp\t\t\t\tAmount of links to get per page when crawling (default all)",0,"white");
		$log->log("--max-links\t\t\tAmount of links to consume per site",0,"white");
		$log->log("--classpath\t\t\tDirectory where aidSQL classes reside",0,"white");
		$log->log("--help\t\t\t\tThis help",0,"white");
		$log->log("\n",0,"white");
		
	}

	function mergeConfig($var,$file){

		if(is_null($file)||!file_exists($file)){
			return $var;
		}

		//parse_ini_file if an option in the ini file is set to yes is automatically translated into a 1 ...
		//PHP 5.3.2

		$config	= parse_ini_file($file);
		$cmdLine	= array();

		foreach($config as $configParam=>$configValue){
			$cfgFile[] = "--".$configParam."=".$configValue;
		}

		if(!sizeof($var)){
			return $cfgFile;
		}

		$cmdLineArgs	= array();

		for($i=1;isset($var[$i]);$i++){

			$found = FALSE;

			$temp1 = substr($var[$i],0,strpos($var[$i],"="));

			if(empty($temp1)){
				$temp1 = $var[$i];
			}

			for($x=0;isset($cfgFile[$x]);$x++){

				$temp2  = substr($cfgFile[$x],0,strpos($cfgFile[$x],"="));

				if($temp1==$temp2){
					$found = TRUE;
					$cfgFile[$x]=$var[$i];
				}

			}

			if(!$found){
				$cfgFile[] = $var[$i];
			}

		}

		return $cfgFile;

	}


	function banner(aidSQL\core\Logger &$log){

		$log->setX11Info(FALSE);

		$banner="               _     _           _ ";
		$log->log($banner,0,"red");
		$banner="   _          (_)   | |         | |";
		$log->log($banner,0,"red");
		$banner=" _| |_    __ _ _  __| |___  __ _| |";
		$log->log($banner,0,"red");
		$banner="|_   _|  / _` | |/ _` / __|/ _` | |";
		$log->log($banner,0,"red");
		$banner="  |_|   | (_| | | (_| \__ \ (_| | |";
		$log->log($banner,0,"red");
		$banner="         \__,_|_|\__,_|___/\__, |_|";
		$log->log($banner,0,"red");
		$banner="                              | |  ";
		$log->log($banner,0,"red");
		$banner="                              |_|  ";
		$log->log($banner,0,"red");
		$banner="\n\tSQL INJECTION DETECTION TOOL\n";
		$log->log($banner,0,"white");
		$banner="\tBy Juan Stange <lynxsec@gmail.com>\n\n\n";
		$log->log($banner,0,"light_green");

		$log->setX11Info(TRUE);

	}

	function createLogDirectory(Array $options,$domain=NULL,\aidSQL\core\Logger &$log,$logType=NULL){

		if(!is_dir($options["log-path"])){

			if(!@mkdir($options["log-path"],0700,TRUE)){

				$log->log("COULDNT CREATE LOGS DIRECTORY ".$options["log-path"]."! CHECK THAT YOU HAVE PERMISSION TO DO SO!",1,"red");
				return FALSE;

			}

		}

		if(!is_null($logType)){

			$logDir	=	$options["log-path"].DIRECTORY_SEPARATOR.$domain.DIRECTORY_SEPARATOR.$logType;

		}else{

			$logDir	=	$options["log-path"].DIRECTORY_SEPARATOR.$url->getHost();

		}

		if(!is_dir($logDir)){

			if(!@mkdir($logDir,0700,TRUE)){
				$log->log("COULDNT CREATE LOG DIRECTORY $logDir! CHECK THAT YOU HAVE PERMISSION TO DO SO!",1,"red");
				return FALSE;
			}

		}

		return $logDir;

	}

	function isVulnerableToSQLInjection(&$cmdParser,&$httpAdapter,&$crawler,&$log,&$pLoader){
		
		$aidSQL	=	new \aidSQL\core\Runner($cmdParser,$httpAdapter,$crawler,$log,$pLoader);
		$plugin	=	$aidSQL->isVulnerableToSQLInjection();
		$options	=	$cmdParser->getParsedOptions();

		$url		=	$httpAdapter->getUrl();

		if($plugin==FALSE){
			return FALSE;
		}

		$log->log("Site is vulnerable to sql injection!",0,"light_cyan");

		$shellLocation	=	NULL;

		if(!array_key_exists("no-shell",$options)){

			$shellName	=	array_key_exists("shell-name",$options) ? $options["shell-name"] : "";
			$shellCode	=	array_key_exists("shell-code",$options) ? $options["shell-code"] : "";

			$plugin->setShellName($shellName);
			$plugin->setShellCode($shellCode);

			if($plugin->isRoot()){

				$shellLocation	=	$plugin->getShell($pLoader,$crawler);

				if($shellLocation){
					$log->log("Got shell! $shellLocation",0,"light_green");
				}

			}


		}else{

			$log->log("Skipping calling plugin's get shell method",0,"green");

		}

		$log->log("PLUGIN\t\t:".$plugin->getPluginName(),0,"light_purple");
		$log->log("AUTHOR\t\t:".$plugin->getPluginAuthor(),0,"light_purple");

		if($options["schema"]!=="none"){

			$schemas		=	$plugin->getAllSchemas();

			if(array_key_exists("save-xml",$options)){

				if($logDirectory=createLogDirectory($options,$url->getHost(),$log,"xml")){

					$xml	=	makeXML($plugin,$schemas);
					file_put_contents($logDirectory.DIRECTORY_SEPARATOR.$url->getPage()."_db-schemas.xml",$xml);

				}

			}

			if(array_key_exists("save-log",$options)){

				if($logDirectory=createLogDirectory($options,$url->getHost(),$log,"log")){

					$txtLog	=	makeLog($plugin,$schemas,$shellLocation,$log);
					file_put_contents($logDirectory.DIRECTORY_SEPARATOR.$url->getPage()."_console.log",$txtLog);

				}

			}

			if(isset($options["save-html"])){

				if(empty($options["save-html"])){
					$options["save-html"]	=	'.';
				}

			}

		}

		return TRUE;

	}

	function filterSites (Array &$sites,aidSQL\core\Logger &$log,$regex=NULL){

		$regex	=	trim($regex,"/");
		$doRegex	=	!empty($regex);

		foreach($sites as $key=>$site){

			if($doRegex){

				if(preg_match("/$regex/",$site->getHost())){

					$log->log("SITE OMITTED ".$site->getHost(),2,"yellow",FALSE);
					unset($sites[$key]);
					continue;

				}

			}

			$log->setPrepend('[aidSQL]');
			$log->log("Site added ".$site->getHost(),0,"green",FALSE);

		}

	}

	function interactive(\aidSQL\core\Logger &$log,Array $options,$key=NULL){

		do{

			$count	=	1;


			foreach($options as $opt){

				if(!is_null($key)){

					$log->log($count++.'. {'.$opt[$key].'}',0,"light_cyan");

				}else{

					$log->log($count++.'. {'.$opt.'}',0,"light_cyan");

				}

			}

			echo "SELECT>";

			$handle	=	fopen ("php://stdin","r");
			$selectedIndexes	=	fgets($handle);
			$selectedIndexes	=	preg_replace("/[\r\n]/",'',$selectedIndexes);
			$selectedIndexes	=	explode(',',$selectedIndexes);

			foreach($selectedIndexes as &$selected){

				$selected	 =	(int)$selected-1;

				if(!isset($options[$selected])){

					echo "Please enter a valid option\n";
					$selectedIndexes	=	'';
					break;

				}

			}	

		}while(empty($selectedIndexes));

		fclose($handle);

		return $selectedIndexes;

	}

?>
