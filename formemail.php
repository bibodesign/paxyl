<?php




if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.

  echo "error; you need to submit the form!";
}
$visistor_send=$_POST['submit'];


$name = $_POST['Name'];
$visitor_email = $_POST['Email'];
$visitor_mobile = $_POST['Mobile'];
$visitor_business = $_POST['Business'];
$visitor_subject = $_POST['Subject'];


$message = $_POST['Message'];

//Validate first
if(empty($name)||empty($visitor_email))
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'info@paxyl.ca';//<== update the email address
$email_subject = "Nouvelle demande de contact";
$email_body = "You have received a new message from the user $name.\n".
    "Mobile number: $visitor_mobile.\n".
    "Business: $visitor_email\n".
    "Email: $visitor_business\n".
    "Subject: $visitor_subject\n".
    "Here is the message:\n $message\n".

$to = "info@paxyl.ca";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.

if ($visistor_send=="ENVOYER"){
  header('Location: http://www.paxyl.ca/merci.html');
}else {
  header('Location: http://www.paxyl.ca/thank-you.html');  
}


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
