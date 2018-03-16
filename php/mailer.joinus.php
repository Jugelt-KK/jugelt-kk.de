<?php

     
    // EDIT THE BELOW TWO LINES AS REQUIRED
    $email_to = "thorben.nolte@snc-it.com";
    $email_subject = "Test Jkk_homepage - join us";
     
     
    function errorMesg() {
        // Error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['joinus_email'])) {
        errorMesg();       
    }

    $email_from = $_POST['joinus_email']; // required
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Email: ".clean_string($email_from)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>

<?php

?>