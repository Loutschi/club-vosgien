<?php SESSION_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (!empty($_POST['FunctionID'])) {
    $FunctionID = ($_POST['FunctionID']);
    $statement = $bdd->prepare("SELECT * FROM functions WHERE FunctionID = ?");
    $statement->execute(array($FunctionID));
    $item = $statement->fetch();
}

if (isset($_POST['modifier'])) {
    $FunctionID         = $_POST['FunctionID'];
    $function_name      = $_POST['function_name'];

    $statement = $bdd->prepare("UPDATE functions SET function_name = ? WHERE FunctionID = ?");
    $statement->execute(array($function_name, $FunctionID));
    echo '<script type="text/javascript">document.location.replace("functions_list.php");</script>';
    exit();

}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Mise à jour du prix de la fonction <br>
                <?php echo $item['function_name'] ; ?> </h2>
        </div>

        <div class="col-auto mb-4">
            <table class="table-responsive">
                <tr>
                    <td>
                        <?php
                        echo '<form method="post" action="functions_list.php" role="form">';
                        echo '<input type="submit" name="insert" class="btn btn-warning" value="Liste des fonctions">';
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
                        echo ' <a href="../logout.php" type="text" class="btn btn-danger text-white">Déconnexion</a> ';
                        echo '</form>';
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        if (!empty($_POST['FunctionID'])) {
            $FunctionID = $_POST['FunctionID'];
            $statement = $bdd->prepare("SELECT * FROM functions WHERE FunctionID = ?");
            $statement->execute(array($FunctionID));
        }
        while ($item = $statement->fetch()) {
        ?>
            <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                <input type="hidden" name="FunctionID" value="<?php echo $FunctionID; ?> ">

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="function_name">Nom de la fonction</label>
                    <input style="width:620px" type="text" class="form-control" id="function_name" name="function_name" value="<?php echo $item['function_name']; ?>">
                </div>

            <?php
        }
            ?>

            <div class="col-lg-12">
                <section class="jumbotron text-center">
                    <div class="mb-4">
                        <button type="submit" name="modifier" class="btn btn-lg btn-block btn-success text-uppercase">Modifier nom de la fonction</button>
                    </div>
                </section>
            </div>
            </form>

    </div>
</div>

<?php require_once('_footer.php'); ?>