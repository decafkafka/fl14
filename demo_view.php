<?php
/**
 * demo_view.php along with demo_list.php provides a sample web application
 *
 * this app is contingent upon the  installation and proper 
 * configuration of the nmMini package (config-mini.php) or equivalent  
 * 
 * @package nmListView
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 3.0 2012/11/14
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_list.php
 * @todo none
 */
 
require 'includes/config.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{#send the user to a safe location!
	header("Location:demo_list.php");
}

//sql statement to select individual item
$sql = "select MuffinName,Description,MetaDescription,MetaKeywords,Price from test_Muffins where MuffinID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!
   
# connection comes first in mysqli (improved) function
$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;	
	   while ($row = mysqli_fetch_assoc($result))
	   {
			$MuffinName = dbOut($row['MuffinName']);
			$Description = dbOut($row['Description']);
			$Price = (float)$row['Price'];
			$MetaDescription = dbOut($row['MetaDescription']);
			$MetaKeywords = dbOut($row['MetaKeywords']);
	   }
}

@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	$title = $MuffinName . " muffins made with PHP & love!"; #overwrite title with Muffin info!
}
# END CONFIG AREA ---------------------------------------------------------- 

include 'includes/header.php'; #header must appear before any HTML is printed by PHP
?>
<h3 align="center"><?=THIS_PAGE;?></h3>

<p>This page, along with <b>demo_list.php</b>, demonstrate a List/View web application.</p>
<p>This page is to be used only with <b>demo_list.php</b>, and is <b>NOT</b> the entry point of the application, meaning this page gets <b>NO</b> link on your web site.</p>
<p>Use <b>demo_list.php</b> and <b>demo_view.php</b> as a starting point for building your own List/View web application!</p> 
<?php
if($foundRecord)
{#records exist - show muffin!
?>
	<h3 align="center">A Yummy <?=$MuffinName;?> Muffin!</h3>
	<div align="center"><a href="demo_list.php">More Muffins?!?</a></div>
	<table align="center">
		<tr>
			<td><img src="upload/m<?=$myID;?>.jpg" /></td>
			<td>We make fresh <?=$MuffinName;?> muffins daily!</td>
		</tr>
		<tr>
			<td colspan="2">
				<blockquote><?=$Description;?></blockquote>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<h3><i>ONLY!!:</i> <font color="red">$<?=number_format($Price,2);?></font></h3>
			</td>
		</tr>
	</table>
<?php
}else{//no such muffin!
    echo '<div align="center">What! No such muffin? There must be a mistake!!</div>';
    echo '<div align="center"><a href="demo_list.php">Another Muffin?</a></div>';
}

include 'includes/footer.php'; #header must appear before any HTML is printed by PHP
?>
