<?php session_start(); ?>

<?php
require_once('_head.php');
require_once('_nav.php');
require_once('_header2.php');
require_once('bdd.php');
$bdd = bdd();
?>

<?php
// echo '<pre>';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '</pre>';
?>


<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="btn btn-secondary btn-block mr-3 ml-3 mb-5">
            <h2>Connexion au backoffice du Club Vosgien Mulhouse & Crêtes</h2>
        </div>

<?php
   if (isset($_POST['submit'])) {
        $captcha = htmlspecialchars(trim($_POST['g-recaptcha-response']));
        if (!$captcha) {
          ?>
          <div class="alert alert-danger" role="alert"><strong>Attention !</strong> Vous êtes obligé de valider le captcha ...</div>
         <?php
          } else {
          $reponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfZ7ysUAAAAADUZvHNLwR3NVkU-jV2XhovbjINH&response=" . $captcha . "");
          $data = json_decode($reponse);
          if (($data->success == 1) || !empty($_POST['user_pwd']) || !empty($_POST['user_email'])) {
            $user_email    = $_POST['user_email'];
            $user_pwd      = $_POST['user_pwd'];
            $verif = $bdd->prepare('SELECT * FROM users WHERE user_email= :user_email AND user_pwd= :user_pwd');
            $verif->execute(array('user_email' => $user_email, 'user_pwd' => $user_pwd));
            $cpte = $verif->rowCount();
            if ($cpte == 0) {
                echo '<div class="container mt-4">';
                echo '<div class="row">';
                echo '<div class="col-lg-12 pb-4">';
                echo '<div class="alert alert-danger text-center mt-4"';
                echo '<h1>Votre identifiant et/ou votre mot de passe est incorrect</h1>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                $user_pwd_valide = $user_pwd;
                $user_email_valide = $user_email;
                if ($user_email == $user_email_valide && $user_pwd == $user_pwd_valide) {
                    $_SESSION['user_email'] = $user_email;
                    echo "<script> window.location.replace('admin/backoffice.php')</script>";
                    }
                }
            }
        }
    }
?>

        <div class="col-lg-12 mb-4">
            <form id="admin-form" data-toggle="validator" method="post" action="" role="form">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="user_email">Votre identifiant <abbr class="text-success" title="Saisie obligatoire"> *</abbr></label>
                        <input id="user_email" type="text" name="user_email" class="form-control" placeholder="Votre identifiant">
                    </div>
                    <div class="col-lg-6">
                        <label for="user_pwd">Votre mot de passe <abbr class="text-success" title="Saisie obligatoire"> *</abbr></label>
                        <input id="user_pwd" type="password" name="user_pwd" class="form-control" placeholder="Votre mot de passe">
                    </div>
                    <div class="col-lg-12 mb-5">
                        <p><strong>* Ces informations sont requises.</strong></p>
                    </div>
                    
                    <div class="mb-4 g-recaptcha" data-sitekey="6LfM-mIkAAAAAAK3toqtm5RkDw4VrJ51HyUl6H6S"></div>

                    <input type="submit" name="submit" class="btn btn-success btn-block mr-3 ml-3" value="Connexion">
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('_footer.php'); ?>