<!DOCTYPE html>
<html lang="fr">

<head>
  <title>IUT Réseaux & Télécom - CTF 2020</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <link rel="stylesheet" href="/style.css">
  <script defer src="lycees_details.js"></script>
</head>

<body>
  <script>
    function selectDept() {
      var e = document.getElementById("departement");
      var value = e.options[e.selectedIndex].value;
      var text = e.options[e.selectedIndex].text;
      document.getElementById("lycee").innerHTML = "";
      lycees.forEach(updateLyceeList);

      function updateLyceeList(item, index) {
        var title = item[0] + " " + item[1];

        if (value == title) {

          document.getElementById("lycee").innerHTML += "<option>" + item + "</option><br>";
        }

      }
    }
  </script>

  <?php

  require_once('header.php');
  require_once('lycees.php');
  ?>
  <section class="section">

    <div class="container">



      <div class="field">
        <label class="label">Departement</label>
        <div class="control">
          <div class="select">
            <select name="departement" id="departement" onchange="selectDept()">
              <?php
              foreach ($lycees as $entry) { ?>
                <option><?php echo $entry; ?></option>
              <?php
            } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="field">
        <label class="label">Lycées</label>
        <div class="control">
          <div class="select">
            <select name="lycee" id="lycee">
            </select>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>