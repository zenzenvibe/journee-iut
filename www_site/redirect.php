<?php
if ($_COOKIE["uit_ctf_uid"]) {
    require_once('flags.php');
    $f = "Flag_".md5($flags[2] . $_COOKIE["uit_ctf_uid"]);
    header('Location: register.php?flag='.$f);
} else {
    header('Location: index.php');
}


?>