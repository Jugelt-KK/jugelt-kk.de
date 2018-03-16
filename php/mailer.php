<?php
if(isset($_POST['email'])) {
     
    // EDIT THE BELOW TWO LINES AS REQUIRED
    $email_to = "info@jugelt-kk.de";
    $email_subject = "Jkk-Homepage";
     
     
    function errorMesg() {
        // Error code can go here
        echo "Es tut uns Leid, es gab einen Fehler mit ihrem Kontaktformular";
        echo "<br /><br />";
        echo "Bitte beheben Sie folgende Fehler.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        errorMesg();       
    }
     
    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['comments']; // required
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>

<?php
}
?>