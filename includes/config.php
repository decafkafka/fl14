<?php
//config.php

include 'credentials.php';

define('THIS_PAGE',basename($_SERVER['PHP_SELF']));
define('DEBUG',TRUE); #we want to see all errors

date_default_timezone_set('America/Los_Angeles'); #sets default date/timezone for this website

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

function makeLinks($nav)
{
	$myReturn = '';
	foreach($nav AS $url => $label)
	{
		if($url == THIS_PAGE)
		{//current page, add class
		$myReturn .= '<li class="current"><a href="' . $url . '">' . $label . '</a></li>';
		}
		else
		{//no class
		$myReturn .= '<li><a href="' . $url . '">' . $label . '</a></li>';	
		}
	}
	return $myReturn;
}

/*
#builds and sends a safe email, using Reply-To properly!
$today = date("Y-m-d H:i:s");
$to = 'yhan0010@seattlecentral.edu';
$replyTo = 'yhan.ccs@gmail.com';
$subject = 'Test Email, includes ReplyTo: ' . $today;
$message = 'Test Message Here.';

safeEmail($to, $subject, $message, $replyTo='');
*/

function safeEmail($to, $subject, $message, $replyTo='')
{#builds and sends a safe email, using Reply-To properly!
$fromDomain = $_SERVER["SERVER_NAME"];
$fromAddress = "noreply@" . $fromDomain; //form always submits from domain where form resides
if($replyTo==''){$replyTo='';}
$headers = 'From: ' . $fromAddress . PHP_EOL .
'Reply-To: ' . $replyTo . PHP_EOL .
'X-Mailer: PHP/' . phpversion();
return mail($to, $subject, $message, $headers);
}

function process_post()
{//loop through POST vars and return a single string
    $myReturn = ''; //set to initial empty value

    foreach($_POST as $varName=> $value)
    {#loop POST vars to create JS array on the current page - include email
         $strippedVarName = str_replace("_"," ",$varName);#remove underscores
        if(is_array($_POST[$varName]))
         {#checkboxes are arrays, and we need to collapse the array to comma separated string!
             $myReturn .= $strippedVarName . ": " . implode(",",$_POST[$varName]) . PHP_EOL;
         }else{//not an array, create line
             $myReturn .= $strippedVarName . ": " . $value . PHP_EOL;
         }
    }
    return $myReturn;
} 

function myerror($myFile, $myLine, $errorMsg)
{
    if(defined('DEBUG') && DEBUG)
    {
       echo "Error in file: <b>" . $myFile . "</b> on line: <b>" . $myLine . "</b><br />";
       echo "Error Message: <b>" . $errorMsg . "</b><br />";
       die();
    }else{
        echo "I'm sorry, we have encountered an error.  Would you like to buy some socks?";
        die();
    }
}
 
/**
 * Wrapper function for processing data pulled from db
 *
 * Forward slashes are added to MySQL data upon entry to prevent SQL errors.  
 * Using our dbOut() function allows us to encapsulate the most common functions for removing  
 * slashes with the PHP stripslashes() function, plus the trim() function to remove spaces.
 *
 * Later, we can add to this function sitewide, as new requirements or vulnerabilities develop.
 *
 * @param string $str data as pulled from MySQL
 * @return $str data cleaned of slashes, spaces around string, etc.
 * @see dbIn()
 * @todo none
 */
function dbOut($str)
{
	if($str!=""){$str = stripslashes(trim($str));}//strip out slashes entered for SQL safety
	return $str;
} #End dbOut()