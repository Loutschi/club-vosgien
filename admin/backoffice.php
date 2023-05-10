<?php session_start();  ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
// echo '<pre>';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '</pre>';
?>


<?php
if (isset($_SESSION['user_email'])) {
  $user_email = ($_SESSION['user_email']);
  $statement = $bdd->prepare("SELECT * FROM users WHERE user_email = ?");
  $statement->execute(array($user_email));
  $item = $statement->fetch();
  $user_email = $item['user_email'];
  $user_firstname = $item['user_firstname'];
  $user_lastname = $item['user_lastname'];
}
?>

<div class="container">

  <div class="row justify-content-center mt-4">


    <div class="btn btn-secondary btn-block mr-3 ml-3 mb-4">
      <h2>Bonjour <?php echo $item['user_firstname']; ?>, bienvenue dans le Back Office <br>du Club Vosgien Mulhouse & Crêtes</h2>
      <h4>Cet espace vous permet de gérer les membres, les conjoints, les enfants, les adhésions et les fonctions au sein du club.</h4>
      <a href="../logout.php" class="btn btn-danger text-white">Déconnexion</a>
    </div>

    <div class="col-lg-12">

      <div class="card-deck mb-4">

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/membre.png">
          <div class="card-header text-center">
            <h4>Adhérents Alpha</h4>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer les adhérents.</p>
            <a href="members_list_alpha.php" class="btn btn-white btn-block"><span class="h5">Gestion des adhérents alpha</span> </a>
          </div>
        </div>

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/membre.png">
          <div class="card-header text-center">
            <h5>Adhérents Chrono</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer les adhérents.</p>
            <a href="members_list_chrono.php" class="btn btn-white btn-block"><span class="h5">Gestion des adhérents chrono</span> </a>
          </div>
        </div>

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/spouse.png">
          <div class="card-header text-center">
            <h5>Conjoints</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer les conjoints.</p>
            <a href="spouses_list.php" class="btn btn-white btn-block"><span class="h5">Gestion des conjoints</span> </a>
          </div>
        </div>

      </div>

      <div class="card-deck mb-4">

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/chd.png">
          <div class="card-header text-center">
            <h5>Enfants</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer les enfants.</p>
            <a href="children_list.php" class="btn btn-white btn-block"><span class="h5">Gestion des enfants</span> </a>
          </div>
        </div>

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/prix.png">
          <div class="card-header text-center">
            <h5>Adhésions</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer les adhésions.</p>
            <a href="subscriptions_list.php " class="btn btn-white btn-block"><span class="h5">Gestion des adhésions</span> </a>
          </div>
        </div>

        <div class="card border border-secondary">
          <img class="card-img-top" src="../img/guide.png">
          <div class="card-header text-center">
            <h5>Fonctions</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Visualiser, modifier, ajouter, supprimer lesfonctions</p>
            <a href="functions_list.php " class="btn btn-white btn-block"><span class="h5">Gesion des fonctions</span> </a>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<?php require_once('_footer.php'); ?>