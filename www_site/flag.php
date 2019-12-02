<!DOCTYPE html>
<html lang="fr">

<head>
    <title>IUT Réseaux & Télécom - CTF 2020</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

    Votre Flag est : 
    <?php
    require_once('flags.php');
    if ($_COOKIE["uit_ctf_uid"]) {
        print "Flag_".md5($flags[0].$_COOKIE["uit_ctf_uid"]);
    }
    

    ?>
    </br>
    Vous pouvez le valider en : <a href="/register.php">Register flag</a>



</body>

</html>