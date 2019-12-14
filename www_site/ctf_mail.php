<?php

require_once('ctf_mailer.php');


function ctf_send_registered_mail($uid, $uidmail, $to) {
    //echo "Send mail to ".$to;
    $url = "https://".$_SERVER['HTTP_HOST']."/register.php?uid=".$uid."uidm=".$uidmail;
    
    $subject = "[Day CTF RT] Confirmation d enregistrement";
    $html = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>[Day CTF RT] Confirmation d enregistrement</title>
    </head>
    <body>
    <div style="font-family: Arial, Helvetica, sans-serif; ">
        <h1>Confirmation d inscription</h1>
        
        <p>Vous êtes inscrit pour la journée CTF RT. Vous pouvez commencer à chercher des Flags en cliquant sur le lien  <a href="{{URL}}">{{URL}}</a></p>
    </div>
    </body>
    </html>';
    $htmlbody = $html; 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}


?>