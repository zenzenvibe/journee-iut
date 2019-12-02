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




<?php 
        require_once('flags.php');
        $f = "Flag_".md5($flags[1] . $_COOKIE["uit_ctf_uid"]);
        echo "<!-----
        -------
        ------- ".$f."
        -------
        ------>";
?>

<body>
    <?php require_once('header.php'); ?>
    
    <?php

//
// POST Data ?
//
if ($_POST['etablissement']) {
    if (!file_exists('conf/ctf_iut.sqlite')) {
        $db = new SQLite3('conf/ctf_iut.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $result = $db->query('CREATE TABLE IF NOT EXISTS participants (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                etablissement VARCHAR,
                nom1 VARCHAR,
                prenom1 VARCHAR,
                email1 VARCHAR,
                nom2 VARCHAR,
                prenom2 VARCHAR,
                email2 VARCHAR,
                uid VARCHAR
            );');
    }
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
        //print("DB ok");
        $etablissement = $_POST['etablissement'];
        $nom1 = $_POST['nom1'];
        $prenom1 = $_POST['prenom1'];
        $email1 = $_POST['email1'];
        $nom2 = $_POST['nom2'];
        $prenom2 = $_POST['prenom2'];
        $email2 = $_POST['email2'];
        $uid = uniqid();
        $_SESSION["uid"] = $uid;

        setcookie('uit_ctf_uid', $uid, time() + (86400 * 30), "/"); // 86400 = 1 day

        $statement = $db->prepare('INSERT INTO participants (etablissement, nom1, prenom1, email1,
             nom2, prenom2, email2, uid)
            VALUES (:etablissement, :nom1, :prenom1, :email1, :nom2, :prenom2, :email2, :uid)');

        $statement->execute([
            'etablissement' => $etablissement,
            'nom1' => $nom1,
            'prenom1' => $prenom1,
            'email1' => $email1,
            'nom2' => $nom2,
            'prenom2' => $prenom2,
            'email2' => $email2,
            'uid' => $uid,
        ]);
        //print("YOLO".$etablissement);
    } else {
        print("DB ko");
    }
}

if ($_POST['flag']) {
    //echo "Flag :" . $_POST['flag'];
    //echo "uit_ctf_uid :" . $_COOKIE["uit_ctf_uid"];
    if ($_COOKIE["uit_ctf_uid"]) {
        // Is Flag valid ?
        $isflagValif = false;
        $validatedFlag="";
        require_once('flags.php');
        foreach ($flags as $flag) {
            $f = "Flag_".md5($flag . $_COOKIE["uit_ctf_uid"]);
            if ($f === $_POST['flag']) {
                $isflagValif = true;
                $validatedFlag =  $flag;
            }
        }
        if ($isflagValif) {
            $msg =  "Flag validé : Félicitation !";
            include 'msg.php';
            if (!file_exists('conf/ctf_iut_flags.sqlite')) {
                $db = new SQLite3('conf/ctf_iut_flags.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
                $result = $db->query('CREATE TABLE IF NOT EXISTS flags (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    uid VARCHAR,
                    flag VARCHAR
                );');
            }
            $db = new PDO('sqlite:conf/ctf_iut_flags.sqlite');
            if ($db) {
                $uid = $_COOKIE["uit_ctf_uid"];

                $statement = $db->prepare('INSERT INTO flags (uid, flag)
                VALUES (:uid, :flag)');

                $statement->execute([
                    'uid' => $uid,
                    'flag' => $validatedFlag
                ]);
                //print("YOLO".$etablissement);
            } else {
                print("DB ko");
            }
        } else {
            $msg =  "Flag non valide";
            include 'msg.php';
        }
    } else {
        $msg = "Veuillez vous enregister";
        include 'msg.php';
    }
}

?>


    <section class="section">

        <form action='' method="post">
            <div class="container">
                <label class="label">Votre équipe est enregistrée.</label>
                </br>
                <label class="label">Pour marquer des points, cherchez les Flags sur le site et saisissez les ci-dessous.</br></br></label>
                <div class="field">
                    <label class="label">Flag</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" placeholder="nom" name="flag">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Submit</button>
                    </div>

                </div>
            </div>
        </form>


    </section>
 <a href='/flag.php' hidden=true>Test flag</a>


</body>

</html>