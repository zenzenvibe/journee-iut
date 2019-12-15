<?php

require_once('ctf_mailer.php');


function getHTML($title, $content) {
    $html = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>'.htmlentities($title).'</title>
    </head>
    <body>
    <div style="font-family: Arial, Helvetica, sans-serif; ">
        <h1>'.htmlentities($title).'</h1>
        
        <p>'.htmlentities($content).'</a></p>
    </div>
    </body>
    </html>';
    return $html;
}

function ctf_send_registered_mail($uid, $uidmail, $to) {
    //echo "Send mail to ".$to;
    $url = "https://".$_SERVER['HTTP_HOST']."/register.php?uid=".$uid."uidm=".$uidmail;
    
    $subject = htmlentities("[Day CTF RT] Confirmation d'enregistrement");
    $title = "[Day CTF RT] Confirmation d'enregistrement";
    $content ="'Votre dossier d'inscription pour la journée CTF RT est créé. </br>
        Les deux email doivent être validés.</br>
        Pour valider votre email, cliquez sur le lien <a href='{{URL}}'>{{URL}}</br>
        ";
    $htmlbody = getHTML($title, $content); 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}


function ctf_send_team_validated_mail($uid, $uidmail, $to, $teamname) {
    //echo "Send mail to ".$to;
    $url = "https://".$_SERVER['HTTP_HOST']."/register.php?uid=".$uid."uidm=".$uidmail;
    
    $subject = htmlentities("[Day CTF RT] Team validé");
    $title = "[Day CTF RT] Team validé";
    $content ='Vos deux emails sont validés.</br>
    Le nom de votre team est : '.$teamname.'</br>
    Vous pouvez commencer à chercher des Flags en cliquant sur le lien  <a href="{{URL}}">{{URL}}';
    $htmlbody = getHTML($title, $content); 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}


?>