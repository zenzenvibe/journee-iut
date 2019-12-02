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


    <?php

    require_once('header.php');
    require_once('etablissements.php');
    ?>



    <section class="section">


        <form action='register.php' method="post">
            <div class="container">

                <div class="field">
                    <label class="label">IUT</label>
                    <div class="control">
                        <div class="select">
                            <select name="etablissement">
<?php
foreach ($etablissements as $entry) { ?>
                                <option><?php echo $entry; ?></option>
<?php
}
?>
                            </select>
                        </div>
                    </div>
                </div>


</br>
                <div class="field">
                    <label class="label">Equipe</label>
</div>
                <div class="columns">

                    <div class="column has-background-grey-lighter as-border">


                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="nom" name="nom1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Prenom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="prénom" value="" name="prenom1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email" placeholder="yolo@yoloctf.org" value="" name="email1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>



                    </div>

                    <div class="column has-background-grey-lighter">



                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="nom" name="nom2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Prenom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="prénom" value="" name="prenom2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email" placeholder="yolo@yoloctf.org" value="" name="email2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>



                    </div>


                </div>
                <div class="container">

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link">Valider</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </section>



</body>

</html>