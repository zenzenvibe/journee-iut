<?php

    $ctf_mail_enabled  = getenv('CTF_MAIL_ENABLED')?getenv('CTF_MAIL_ENABLED'):'true';
    $ctf_mail_username = getenv('CTF_MAIL_USERNAME')?getenv('CTF_MAIL_USERNAME'):'dayctfrt';
    $ctf_mail_passwd   = getenv('CTF_MAIL_PASSWD')?getenv('CTF_MAIL_PASSWD'):'MOTDEPASSE';
    $ctf_mail_frommail = getenv('CTF_MAIL_FROMMAIL')?getenv('CTF_MAIL_FROMMAIL'):'dayctfrt@gmail.com';
    $ctf_mail_fromname = getenv('CTF_MAIL_FROMNAME')?getenv('CTF_MAIL_FROMNAME'):'Day CTF RT';

?>