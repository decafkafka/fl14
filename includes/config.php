<?php
//config.php

include 'credentials.php'; #database credentials
include 'common.php'; #common functions

define('THIS_PAGE',basename($_SERVER['PHP_SELF']));
define('DEBUG',TRUE); #we want to see all errors

date_default_timezone_set('America/Los_Angeles'); #sets default date/timezone for this website

/* automatic path settings - use the following 4 path settings for placing all code in one application folder */ 
define('VIRTUAL_PATH', 'http://www.younghan.org/itc240/fl14/'); # Virtual (web) 'root' of application for images, JS & CSS files
define('PHYSICAL_PATH', '/home/youhan3/younghan.org/itc240/fl14/'); # Physical (PHP) 'root' of application for file & upload reference
define('INCLUDE_PATH', PHYSICAL_PATH . 'includes/'); # Path to PHP include files - INSIDE APPLICATION ROOT


# End Config area --------------------------------
ob_start();  #buffers our page to be prevent header errors. Call before INC files or ANY html!
header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching

$title = THIS_PAGE; //fallback unique title - see title tag in header.php
if(DEBUG)
{# When debugging, show all errors & warnings
	ini_set('error_reporting', E_ALL | E_STRICT);  
}else{# zero will hide everything except fatal errors
	ini_set('error_reporting', 0);  
}

$nav1['index.php'] = "Home";
$nav1['kiribati.php'] = "Kiribati";
$nav1['nauru.php'] = "Nauru";
$nav1['tuvalu.php'] = "Tuvalu";
$nav1['maldives.php'] = "Maldives";
$nav1['contact.php'] = "Contact";
$nav1['join.php'] = "Join";
$nav1['data.php'] = "Data";

switch(THIS_PAGE)
{
	case 'index.php':
		$title = 'Islands Under Threat | Home';
		$banner = 'Under Threat';
		$image = 'index.jpg';
		$pageH1 = 'Global Warming';
		break;
	case 'kiribati.php':
		$title = 'Islands Under Threat | Kiribati';
		$banner = 'Kiribati';
		$image = 'kiribati.jpg';
		$pageH1 = 'Highest Point: 81 m (266 ft)';
		break;
	case 'nauru.php':
		$title = 'Islands Under Threat | Nauru';
		$banner = 'Nauru';
		$image = 'nauru.jpg';
		$pageH1 = 'Highest Point: 71 m (233 ft)';
		break;
	case 'tuvalu.php':
		$title = 'Islands Under Threat | Tuvalu';
		$banner = 'Tuvalu';
		$image = 'tuvalu.jpg';
		$pageH1 = 'Highest Point: 5 m (16 ft)';
		break;
	case 'maldives.php':
		$title = 'Islands Under Threat | Maldives';
		$banner = 'Maldives';
		$image = 'maldives.jpg';
		$pageH1 = 'Highest Point: 2.4 m (8 ft)';
		break;
	case 'contact.php':
		$title = 'Islands Under Threat | Contact';
		$banner = 'Contact';
		$image = 'index.jpg';
		$pageH1 = 'Send Us Your Feedback';
		break;
	case 'join.php':
		$title = 'Islands Under Threat | Join';
		$banner = 'Join';
		$image = 'index.jpg';
		$pageH1 = 'Become a Member of Our Organization';
		break;	
	case 'data.php':
		$title = 'Islands Under Threat | Data';
		$banner = 'Data';
		$image = 'index.jpg';
		$pageH1 = 'Population Statistics';
		break;
	default:
		$title = 'This is default title tag';
		$banner = 'Site Banner';
		$image = 'index.jpg';
		$pageH1 = 'Global Warming';
	}