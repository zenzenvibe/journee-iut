<?php 
////////////////////////////////////////////////////////////////////////////
// Session Id is UID
//
if (isset($_GET['uid'])) {
    setcookie('uit_ctf_uid', $_GET['uid'], time() + (86400 * 30), "/"); // 86400 = 1 day
}


////////////////////////////////////////////////////////////////////////////
// Register Form ?
//
if (isset($_POST['etablissement'])) {
    //
    // Create DB ???
    //
    $test=true;
    if (!file_exists('conf/ctf_iut.sqlite')) {
        $db = new SQLite3('conf/ctf_iut.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $result = $db->query('CREATE TABLE IF NOT EXISTS participants (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                lycee VARCHAR,
                etablissement VARCHAR,
                nom1 VARCHAR,
                prenom1 VARCHAR,
                email1 VARCHAR,
                uid1 VARCHAR,
                ismail1confirmed boolean,
                nom2 VARCHAR,
                prenom2 VARCHAR,
                email2 VARCHAR,
                uid2 VARCHAR,
                ismail2confirmed boolean,
                uid VARCHAR,
                teamname VARCHAR,
                state INTEGER
            );');
        if ($test) $resultf = $db->query('INSERT INTO participants (
                lycee, etablissement,
                nom1, prenom1, email1, uid1, ismail1confirmed,
                nom2, prenom2, email2, uid2, ismail2confirmed,
                uid , state) 
            VALUES ("lycee1","iut1",
                "nom11","prenom11","email11@mail.com","ID11",false,
                "nom12","prenom12","email12@mail.com","ID12",false,
                "UID1",0);');
        $resultf = $db->query('CREATE TABLE IF NOT EXISTS flags (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            uid VARCHAR,
            flag VARCHAR
        );');
        if ($test) $resultf = $db->query('INSERT INTO flags (uid, flag) VALUES ("","");');
    }
    //
    // Save Form
    //
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
        $lycee = filter_var($_POST['lycee'], FILTER_SANITIZE_STRING);
        $etablissement = filter_var($_POST['etablissement'], FILTER_SANITIZE_STRING);
        $nom1 = filter_var($_POST['nom1'], FILTER_SANITIZE_STRING);
        $prenom1 = filter_var($_POST['prenom1'], FILTER_SANITIZE_STRING);
        $email1 = filter_var($_POST['email1'], FILTER_VALIDATE_EMAIL);
        $uid1 =uniqid();
        $nom2 = filter_var($_POST['nom2'], FILTER_SANITIZE_STRING);
        $prenom2 = filter_var($_POST['prenom2'], FILTER_SANITIZE_STRING);
        $email2 = filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL);
        $uid2 =uniqid();
        $uid = uniqid();
        $_SESSION["uid"] = $uid;

        setcookie('uit_ctf_uid', $uid, time() + (86400 * 30), "/"); // 86400 = 1 day

        $statement = $db->prepare('INSERT INTO participants (
            lycee, etablissement, 
            nom1, prenom1, email1, uid1, ismail1confirmed,
            nom2, prenom2, email2, uid2, ismail2confirmed,  
            uid, teamname, state)
            VALUES (:lycee, :etablissement, 
            :nom1, :prenom1, :email1, :uid1, false,
            :nom2, :prenom2, :email2, :uid2, false,
            :uid, "no_name_yet", 0)');

        $statement->execute([
            'lycee' => $lycee,
            'etablissement' => $etablissement,
            'nom1' => $nom1,
            'prenom1' => $prenom1,
            'email1' => $email1,
            'uid1' => $uid1,
            'nom2' => $nom2,
            'prenom2' => $prenom2,
            'email2' => $email2,
            'uid2' => $uid2,
            'uid' => $uid,
        ]);

        require_once('var_env.php');
        if ($ctf_mail_enabled){
            require_once('ctf_mail.php');
            //echo "Register: Send mail to ".$email1;
            ctf_send_registered_mail($uid, $uid1, $email1);  
            ctf_send_registered_mail($uid, $uid2, $email2);  
        } else {
            //echo "Mail not enabled";
        }
    } else {
        print("DB ko");
    }
}

?>

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
        if (isset($_COOKIE["uit_ctf_uid"])) {
            $f = "Flag_".md5($flags[1] . $_COOKIE["uit_ctf_uid"]);
            echo "<!-----
            -------
            ------- ".$f."
            -------
            ------>";
        }
?>

<body>
    <?php require_once('header.php'); ?>
    
    <?php


////////////////////////////////////////////////////////////////////////////
// Validate a mail
//

function getNewTeamName() {
    $names_file = file_get_contents('hacker_name.txt');
    $names = $pieces = explode("\n", $names_file);
    $index = rand(0, count($names)-1);
    return $names[$index];


}

if (isset($_GET['uid']) && isset($_GET['uidm'])) {
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    $statement = $db->prepare('UPDATE participants
        SET ismail1confirmed=true
        WHERE ( uid=:uid and uid1=:uidm)');
    $statement->execute([
            'uid' => $_GET['uid'] ,
            'uidm' => $_GET['uidm']
        ]);
    $statement = $db->prepare('UPDATE participants
        SET ismail2confirmed=true
        WHERE ( uid=:uid and uid2=:uidm)');
    $statement->execute([
            'uid' => $_GET['uid'] ,
            'uidm' => $_GET['uidm']
        ]);
    // 2 mails validated ?
    // Set team name
    $statement = $db->prepare('SELECT * from participants WHERE ( uid=:uid and ismail1confirmed=true and ismail2confirmed=true )');
    $statement->execute([
            'uid' => $_GET['uid'] 
    ]);
    if ($row = $statement->fetch()){
        $teamname = getNewTeamName();
        $statement = $db->prepare('UPDATE participants
        SET teamname=:teamname
        WHERE ( uid=:uid )');
        $statement->execute([            
            'teamname' => $teamname,
            'uid' => $_GET['uid'] 
        ]);
    }

    // Send mail with team name
}




///////////////////////////////////////////////////////////////////////////////////
// Validate FLag
//
if (isset($_POST['flag'])) {
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
            $db = new PDO('sqlite:conf/ctf_iut.sqlite');
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

<?php 
    if (isset($_SESSION["uid"]) || isset($_GET['uid']) || isset($_COOKIE['uit_ctf_uid']) ) {
    if (isset($_COOKIE['uit_ctf_uid'])) $id = $_COOKIE['uit_ctf_uid'];
    if (isset($_SESSION["uid"])) $id = $_SESSION["uid"];
    if (isset($_GET['uid'])) $id = $_GET['uid'];
    

    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    $statement = $db->prepare('SELECT * FROM participants WHERE uid=:uid');
    $statement->execute([
        ':uid' => $id
    ]);
    $fullValidated = false;
    $partialValidated = false;
    if ($row = $statement->fetch()){
        $fullValidated = $row['ismail1confirmed']&&$row['ismail2confirmed'];
        $partialValidated = $row['ismail1confirmed']||$row['ismail2confirmed'];
    } 

    if ($partialValidated) {
    ?>

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
    <?php } else { ?>
        <div class="container">
        <label class="label">Votre équipe est enregistrée. Merci de valider les mails...</label>
        </br>

    </div>
        </section>
    <?php } ?>
<?php } else { ?>
    <div class="container">
        <label class="label">Merci de vous enregistrer avec le formulaire...</label>
        </br>

    </div>
<?php }  ?>

</body>

</html>