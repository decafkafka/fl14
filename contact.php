<?php require 'includes/config.php';?>
<?php include 'includes/header.php';?>
<h1><?=$pageH1?></h1>
<?php
if(isset($_POST['submit']))
{//if there's data, show it
//echo $_POST['FirstName'];

$message = process_post();

safeEmail('yhan0010@seattlecentral.edu','test subject',$message);
echo 'Thank you for your email!';
}
else
{//show the form
echo '
<form action ="contact.php" method="post">
First Name: <input type="text" name="first_name" required="required"/>
<br />
Email: <input type="email" name="email" placeholder="email" required="required" />
<br />
Comments: <textarea name="comments"></textarea>
<input type="submit" value"Click me!" name="submit" /!>
</form>
';
}
?>
<?php include 'includes/footer.php';?>