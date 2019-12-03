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

    <?php require_once('../header.php'); ?>

    <section class="hero is-link">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Utilisateurs</h1>
            </div>


            <div class="container">

                <?php
                if (file_exists('../conf/ctf_iut.sqlite')) {
                    $db = new SQLite3('../conf/ctf_iut.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
                    $results = $db->query("SELECT * FROM participants;");
                    while ($row = $results->fetchArray()) {


                        ?>
                        <div class="columns">
                            <label class="label column"><?php echo htmlspecialchars($row['id']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['etablissement']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['nom1']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['prenom1']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['email1']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['nom2']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['prenom2']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['email2']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['lycee']); ?></label>
                        </div>
                    <?php
                }
            } ?>

            </div>
    </section>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Flags</h1>
            </div>
            <div class="container">
                <?php
                if (file_exists('../conf/ctf_iut_flags.sqlite')) {
                    $db = new SQLite3('../conf/ctf_iut_flags.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
                    $results = $db->query("SELECT * FROM flags;");
                    while ($row = $results->fetchArray()) {


                        ?>
                        <div class="columns">
                            <label class="label column"><?php echo htmlspecialchars($row['id']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['uid']); ?></label>
                            <label class="label column"><?php echo htmlspecialchars($row['flag']); ?></label>
                        </div>
                    <?php
                }
            }
            ?>
            </div>
        </div>

    </section>



</body>

</html>