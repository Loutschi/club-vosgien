<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (isset($_POST['supprimer'])) {
  $ChildID    = ($_POST['ChildID']);
  $statement = $bdd->prepare("DELETE FROM children WHERE ChildID = ? ");
  $statement->execute(array($ChildID));
}
?>

<div class="container">

  <div class="row justify-content-center mt-4">

    <div class="btn btn-secondary btn-block mr-3 ml-3 mb-4">
      <h2>Liste des enfants d'adhérents</h2>
      <?php
      $stmt = $bdd->prepare("SELECT COUNT(*) FROM children");
      $stmt->execute();
      $count = $stmt->fetchColumn();
      echo "Il y a " . $count . " enfants d'adhérents au Club Vosgien Mulhouse & Crêtes" ;
      ?>
    </div>

    <div class="col-auto mb-4">
      <table class="table-responsive">
        <tr>
          <td>
            <?php
            echo '<form method="post" action="child_insert.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Ajouter un enfant">';
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
            echo '<form method="post" action="spouses_list.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Conjoints">';
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
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <!-- <th class="font-weight-normal">ID</th> -->
            <th class="font-weight-normal">Civilité</th>
            <th class="font-weight-normal">Prénom</th>
            <th class="font-weight-normal">Nom</th>
            <th class="font-weight-normal">Date de naissance</th>
            <th colspan="2" class="font-weight-normal text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $statement = $bdd->prepare('SELECT * FROM children ORDER BY child_lastname');
          $statement->execute();
          while ($item = $statement->fetch()) {
            echo '<tr>';
            // echo '<td>' . $item['ChildID'] . '</td>';
            echo '<td>' . ucfirst($item['civ_name']) . '</td>';
            echo '<td>' . ucfirst($item['child_firstname']) . '</td>';
            echo '<td>' . strtoupper($item['child_lastname']) . '</td>';
            echo '<td>' . $item['child_dob'] . '</td>';

            echo '<td>';
            echo '<form method="post" action="child_update.php" role="form">';
            echo '<input id"ChildID" type="hidden" name="ChildID" value="' . $item['ChildID'] . '"> ';
            echo '<input type="submit" class="btn btn-success" value="Editer">';
            echo '</form>';
            echo '</td>';

            echo ' ';

            echo '<td>';
            echo '<form method="post" action="" role="form">';
            echo '<input id="ChildID" type="hidden" name="ChildID" value="' . $item['ChildID'] . '"> ';
            echo '<input type="submit" class="btn btn-danger" name="supprimer" value="Supprimer">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>

      </table>
    </div>
  </div>
</div>

<?php require_once('_footer.php'); ?>