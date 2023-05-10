<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (!empty($_SESSION['user_email'])) {
  $user_email = ($_SESSION['user_email']);
  $statement = $bdd->prepare("SELECT * FROM users WHERE user_email = ?");
  $statement->execute(array($user_email));
  $item = $statement->fetch();
  $UserID          = $item['UserID'];
  $user_pwd        = $item['user_pwd'];
  $user_firstname  = $item['user_firstname'];
  $user_lastname   = $item['user_lastname'];
}

if (isset($_POST['supprimer'])) {
  $MemberID    = ($_POST['MemberID']);
  $statement = $bdd->prepare("DELETE FROM members WHERE MemberID = ? ");
  $statement->execute(array($MemberID));
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
      <h2>Liste des adhérents classée chronologique</h2>
      <?php
      $stmt = $bdd->prepare("SELECT COUNT(*) FROM members");
      $stmt->execute();
      $count = $stmt->fetchColumn();
      echo "Il y a " . $count . " adhérents au Club Vosgien Mulhouse & Crêtes" ;
      ?>
    </div>

    <div class="col-auto mb-4">
      <table class="table-responsive">
        <tr>
          <td>
            <?php
            echo '<form method="post" action="member_insert.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Ajouter un adhérents">';
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
            echo '<form method="post" action="spouses_list.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Conjoints">';
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
            echo '<form method="post" action="" role="form">';
            echo'<a href="export_excel.php" class="btn btn-warning"><span style="color:#212529">Exporter au format Excel</span></a>';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="backoffice.php" role="form">';
            echo '<input type="submit" class="btn btn-danger" value="Backoffice">';
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
        <input class="text-center" type="text" id="myInput" onkeyup="filterTable()" placeholder=" Nom du membre recherché">
      </div>

      <table id="membres" class="table table-hover">
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
            <th class="font-weight-normal">Revue</th>
            <th class="font-weight-normal">Cotisation</th>
            <th colspan="5" class="font-weight-normal text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $statement = $bdd->prepare('SELECT * FROM members ORDER BY MemberID desc');
          $statement->execute();
          while ($item = $statement->fetch()) {
            echo '<tr>';

            // echo '<td>' . $item['MemberID'] . '</td>';
            echo '<td>' . $item['member_cvnum'] . '</td>';
            echo '<td>' . ucfirst($item['civ_name']) . '</td>';
            echo '<td>' . ucfirst($item['member_firstname']) . '</td>';
            echo '<td>' . strtoupper($item['member_lastname']) . '</td>';
            echo '<td>' . wordwrap(($item['member_phone']), 2, ' ', true) . '</td>';
            echo '<td>' . wordwrap(($item['member_mobile']), 2, ' ', true) . '</td>';
            echo '<td>' . $item['member_email'] . '</td>';
            echo '<td>' . $item['magazine'] . '</td>';
            echo '<td>' . $item['accession_payment'] . '</td>';

            echo '<td>';
            echo '<form method="post" action="member_update.php" role="form">';
            echo '<input id"MemberID" type="hidden" name="MemberID" value="' . $item['MemberID'] . '"> ';
            echo '<input type="submit" class="btn btn-success" value="Editer">';
            echo '</form>';
            echo '</td>';

            echo '<td>';
            echo '<form method="post" action="" role="form">';
            echo '<input id="MemberID" type="hidden" name="MemberID" value="' . $item['MemberID'] . '"> ';
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
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("membres");
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