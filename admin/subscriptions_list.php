<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (isset($_POST['supprimer'])) {
  $SubscriptionID    = ($_POST['SubscriptionID']);
  $statement = $bdd->prepare("DELETE FROM subscriptions WHERE SubscriptionID = ? ");
  $statement->execute(array($SubscriptionID));
}
?>

<div class="container">

  <div class="row justify-content-center mt-4">

    <div class="btn btn-secondary btn-block mr-3 ml-3 mb-4">
      <h2>
        <?php
        if (empty($_SESSION['user_email'])) {
          echo 'Veuillez vous connecter au <a class="text-light" href="login_backoffice.php">back office</a> SVPL <br>';
          echo '</h2>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          require_once('_footer.php');
          die;
        }
        ?>
        Liste des adhésions
    </div>

    <div class="col-auto mb-4">
      <table class="table-responsive">
        <tr>
          <td>
            <?php
            echo '<form method="post" action="subscription_insert.php" role="form">';
            echo '<input type="submit" name="insert" class="btn btn-warning" value="Ajouter une adhésion">';
            echo '</form>';
            ?>
          </td>
          <td>
            <?php
            echo '<form method="post" action="backoffice.php" role="form">';
            echo '<input type="submit" class="btn btn-danger" value="Retour backoffice">';
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
            <th class="font-weight-normal">Nom de l'adhésion</th>
            <th class="font-weight-normal">Prix</th>
            <th colspan="2" class="font-weight-normal">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $statement = $bdd->prepare('SELECT * FROM subscriptions');
          $statement->execute();
          while ($item = $statement->fetch()) {
            echo '<tr>';
            echo '<td>' . $item['subscription_name'] . '</td>';
            echo '<td>' . $item['subscription_price'] . ' €</td>';

            echo '<td>';
            echo '<form method="post" action="subscription_update.php" role="form">';
            echo '<input id"SubscriptionID" type="hidden" name="SubscriptionID" value="' . $item['SubscriptionID'] . '"> ';
            echo '<input type="submit" class="btn btn-primary" value="Modifier">';
            echo '</form>';
            echo '</td>';

            echo ' ';

            echo '<td>';
            echo '<form method="post" action="" role="form">';
            echo '<input id="SubscriptionID" type="hidden" name="SubscriptionID" value="' . $item['SubscriptionID'] . '"> ';
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