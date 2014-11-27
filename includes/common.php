<?php
//common.php

/**
 * Automatically loads classes by name when called.  This saves resources, as  
 * only pages that need to reference the class actually load it.
 *
 * The autoload function allows us to name a file after the class, and customize it to 
 * meet our needs, but load the file requiring the class by assuming the file name based on 
 * the name of the class.  In our case, we'll add '.php', which follows our pattern. 
 *
 *<code>
 *$myObject = new myClass();
 *</code>
 *  
 * @param str $class_name Class to be loaded as needed
 * @return void
 */

function __autoload($class_name) 
{
    if(file_exists(INCLUDE_PATH . $class_name . '.php'))
    {
    	include INCLUDE_PATH . $class_name . '.php';
	}
}#end __autoload()

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