<?php SESSION_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (!empty($_POST['SubscriptionID'])) {
    $SubscriptionID = ($_POST['SubscriptionID']);
    $statement = $bdd->prepare("SELECT * FROM subscriptions WHERE SubscriptionID = ?");
    $statement->execute(array($SubscriptionID));
    $item = $statement->fetch();
}

if (isset($_POST['modifier'])) {
    $SubscriptionID         = $_POST['SubscriptionID'];
    $subscription_name      = $_POST['subscription_name'];
    $subscription_price     = $_POST['subscription_price'];

    $statement = $bdd->prepare("UPDATE subscriptions SET subscription_name = ?, subscription_price = ? WHERE SubscriptionID = ?");
    $statement->execute(array($subscription_name, $subscription_price, $SubscriptionID));
    echo '<script type="text/javascript">document.location.replace("subscriptions_list.php");</script>';
    exit();

}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Mise à jour du prix de l'abonnement <br>
                <?php echo $item['subscription_name'] . ' <br>
                au prix de ' . $item['subscription_price'] . '€'; ?> </h2>
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
                    <td>
                        <?php
                        echo '<form method="post" action="" role="form">';
                        echo ' <a href="../logout.php" type="text" class="btn btn-danger">Déconnexion</a> ';
                        echo '</form>';
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        if (!empty($_POST['SubscriptionID'])) {
            $SubscriptionID = $_POST['SubscriptionID'];
            $statement = $bdd->prepare("SELECT * FROM subscriptions WHERE SubscriptionID = ?");
            $statement->execute(array($SubscriptionID));
        }
        while ($item = $statement->fetch()) {
        ?>
            <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                <input type="hidden" name="SubscriptionID" value="<?php echo $SubscriptionID; ?> ">

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="subscription_name">Nom de l'abonnement</label>
                    <input style="width:620px" type="text" class="form-control" id="subscription_name" name="subscription_name" value="<?php echo $item['subscription_name']; ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="subscription_price">Prix de l'abonnement</label>
                    <input style="width:100px" type="text" class="form-control" id="subscription_price" name="subscription_price" value="<?php echo $item['subscription_price']; ?>">
                </div>

            <?php } ?>

            <div class="col-lg-12">
                <section class="jumbotron text-center">
                    <div class="mb-4">
                        <button type="submit" name="modifier" class="btn btn-lg btn-block btn-success text-uppercase">Modifier le prix de l'abonnement</button>
                    </div>
                </section>
            </div>
            </form>

    </div>
</div>

<?php require_once('_footer.php'); ?>