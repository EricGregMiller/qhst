<?
  // Setup QHCC page object.
  require '../QHScript/QHCCPage.php';
  $r = new QHCCPage;
  
  // Send email with signup data.
  $date = $_REQUEST['Date'];
  $name = $_REQUEST['Name'];
  $phone = $_REQUEST['PhoneNumber'];
  $email = $_REQUEST['Email'];
  $to = "QHST Admin <administrator@theology.edu>";
  $subject = $name . " wants to clean the church on " . $date . ".";
  $message = "Hi Judy,\n\n" . 
             $subject . 
             "\n\nPhone: " . $phone . 
             "\nEmail: " . $email . 
             "\n\nQuartz Hill Community Church Website" . 
             "\nadministrator@theology.edu";
  $from = "From: Quartz Hill Community Church Website <administrator@theology.edu>";
  //if (strlen($email) > 0)
  //  $from = "From: " . $name . " <" . $email . ">";

  mail( $to, $subject, $message, $from );
?> 
<html>
<head>
  <title>QHCC Cleaning Thank You</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="./announcements.css" />
  <?$r->HeadEnd();?> 
</head>

<body>
  <?$r->PageBegin(0);?> 
    <img src="Cleaning.jpg" align="left" vspace="30" hspace="30" border="0">
    <h1>Thank You!</h1>
    <p>
      Thank you for signing up to clean the church.
      <ul>A message has been sent with the following information.
      <li>Date: <?echo $date;?></li>
      <li>Name: <?echo $name;?></li>
      <li>Phone number: <?echo $phone;?></li>
      <li>Email: <?echo $email;?></li></ul>
      Judy will be notified.<br/>
      <a href="Cleaning.html">Return to cleaning page</a>
    </p>
    <br/>
    <br/>
    <br/>
  <?$r->PageEnd();?> 
</body>
</html>
