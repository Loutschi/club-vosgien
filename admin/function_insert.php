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
    $function_name   = $_POST['function_name'];

    $statement = $bdd->prepare("INSERT INTO functions (function_name) VALUE (?)");
    $statement->execute(array($function_name));
    
    echo '<script type="text/javascript">document.location.replace("functions_list.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2 class="pl-3">Ajouter une Fonction au sein du club</h2>
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
                        echo '<input type="submit" class="btn btn-danger text-white" value="Backoffice">';
                        echo '</form>';
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-auto mb-4">
            <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="function_name">Nom de la fonction</label>
                    <input style="width:620px" type="text" class="form-control" id="function_name" name="function_name">
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