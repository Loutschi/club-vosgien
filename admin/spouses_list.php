<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (!empty($_SESSION['SpouseID'])) {
  $SpouseID = ($_SESSION['SpouseID']);
  $statement = $bdd->prepare("SELECT * FROM spouses WHERE SpouseID = ?");
  $statement->execute(array($SpouseID));
  $item = $statement->fetch();
  // $SpouseID = $item['SpouseID'];
}
?>

<?php
if (isset($_POST['supprimer'])) {
  $SpouseID    = ($_POST['SpouseID']);
  $statement = $bdd->prepare("DELETE FROM spouses WHERE SpouseID = ? ");
  $statement->execute(array($SpouseID));
}
?>


<style>
  #scrollUp {
    position: fixed;
    bottom: 10px;
    right: -100px;
    opacity: 0.5;
  }
</style>
 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
 
<script>
  jQuery(function() {
    $(function() {
      $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
          $('#scrollUp').css('right', '10px');
        } else {
          $('#scrollUp').removeAttr('style');
        }

      });
    });
  });
</script>

<div class="container-fluid">

  <div class="row justify-content-center mt-4">

    <div class="btn btn-secondary btn-block mr-3 ml-3 mb-4">
      <h2>Liste des conjoints</h2>
      <?php
      $stmt = $bdd->prepare("SELECT COUNT(*) FROM spouses");
      $stmt->execute();
      $count = $stmt->fetchColumn();
      echo "Il y a " . $count . " conjoints d'adhérents au Club Vosgien Mulhouse & Crêtes" ;
      ?>
    </div>

    <div class="col-auto mb-4">

      <table class="table-responsive">
        <tr>
          <td>
            <?php
            echo '<form method="post" action="spouse_insert_admin.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Ajouter un conjoint">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="members_list_alpha.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Adhérents alpha">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="members_list_chrono.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Adhérents chrono">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="children_list.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Enfants">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="backoffice.php" role="form">';
            echo '<input type="submit" class="btn btn-danger text-white" value="Backoffice">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="" role="form">';
            echo '<a href="../logout.php" type="text" class="btn btn-danger text-white">Déconnexion</a> ';
            echo '</form>';
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row justify-content-center">

    <div class="col-auto">
      <div class="bg-warning btn-block text-center mb-2 pt-2 pb-1" >
        <label for="">Recherche par nom de membre : </label>
        <input class="text-center" type="text" id="monInput" onkeyup="filterTable()" placeholder=" Nom du membre recherché">
      </div>

      <table id="spouses" class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <!-- <th class="font-weight-normal">ID</th> -->
            <th class="font-weight-normal">N° CV</th>
            <th class="font-weight-normal">Civ</th>
            <th class="font-weight-normal">Prénom</th>
            <th class="font-weight-normal">Nom</th>
            <th class="font-weight-normal">Fixe</th>
            <th class="font-weight-normal">Mobile</th>
            <th class="font-weight-normal">Email</th>
            <th colspan="2" class="font-weight-normal text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $statement = $bdd->prepare('SELECT * FROM spouses ORDER BY spouse_lastname');
          $statement->execute();
          while ($item = $statement->fetch()) {
            echo '<tr>';
            // echo '<td>' . $item['SpouseID'] . '</td>';
            echo '<td>' . $item['spouse_cvnum'] . '</td>';
            echo '<td>' . $item['civ_name'] . '</td>';
            echo '<td>' . $item['spouse_firstname'] . '</td>';
            echo '<td>' . strtoupper($item['spouse_lastname']) . '</td>';
            echo '<td>' . $item['spouse_phone'] . '</td>';
            echo '<td>' . $item['spouse_mobile'] . '</td>';
            echo '<td>' . $item['spouse_email'] . '</td>';

            echo '<td>';
            echo '<form method="post" action="spouse_update.php" role="form">';
            echo '<input id"SpouseID" type="hidden" name="SpouseID" value="' . $item['SpouseID'] . '"> ';
            echo '<input type="submit" class="btn btn-success" value="Editer">';
            echo '</form>';
            echo '</td>';

            echo ' ';

            echo '<td>';
            echo '<form method="post" action="" role="form">';
            echo '<input id="SpouseID" type="hidden" name="SpouseID" value="' . $item['SpouseID'] . '"> ';
            echo '<input type="submit" class="btn btn-danger" name="supprimer" value="Supprimer">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>

        <script>
          function filterTable() {
              var input, filter, table, tr, td, i, txtValue;
              input = document.getElementById("monInput");
              filter = input.value.toUpperCase();
              table = document.getElementById("spouses");
              tr = table.getElementsByTagName("tr");

              for (i = 0; i < tr.length; i++) {
                  td = tr[i].getElementsByTagName("td")[3];
                  if (td) {
                      txtValue = td.textContent || td.innerText;
                      if (txtValue.toUpperCase().indexOf(filter) > -1) {
                          tr[i].style.display = "";
                      } else {
                          tr[i].style.display = "none";
                      }
                  }
              }
          }
        </script>

    </div>
  </div>
</div>

<div id="scrollUp">
  <a href="#top"><img src="../img/to_top.png" /></a>
</div>

<?php require_once('_footer.php'); ?>