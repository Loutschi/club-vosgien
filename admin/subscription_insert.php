<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
require_once '../vendor/autoload.php';
$bdd = bdd();
?>

<?php
if (isset($_POST['ajouter'])) {
    $subscription_name   = $_POST['subscription_name'];
    $subscription_price    = $_POST['subscription_price'];
    $statement = $bdd->prepare("INSERT INTO subscriptions (subscription_name, subscription_price) VALUE (?, ?)");
    $statement->execute(array($subscription_name, $subscription_price));

    echo '<script type="text/javascript">document.location.replace("subscriptions_list.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2 class="pl-3">Ajouter une adhésion</h2>
        </div>

        <div class="col-auto mb-4">
            <table class="table-responsive">
                <tr>
                    <td>
                        <?php
                        echo '<form method="post" action="subscriptions_list.php" role="form">';
                        echo '<input type="submit" name="insert" class="btn btn-warning" value="Liste des adhésions">';
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
                </tr>
            </table>
        </div>

        <div class="col-auto mb-4">
            <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="subscription_name">Nom de l'adhesion</label>
                    <input style="width:620px" type="text" class="form-control" id="subscription_name" name="subscription_name">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="subscription_price">Prix de l'enfant</label>
                    <input style="width:180px" type="text" class="form-control" id="subscription_price" name="subscription_price">
                </div>

                 <div class="col-lg-12">
                    <section class="jumbotron text-center">
                        <div>
                            <button type="submit" name="ajouter" class="btn btn-block btn-primary text-uppercase">Ajouter l'adhésion</button>
                        </div>
                    </section>
                </div>

            </form>
        </div>

    </div>

</div>

<?php require_once('_footer.php'); ?>