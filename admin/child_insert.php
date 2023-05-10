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
    $child_lastname     = $_POST['child_lastname'];
    $child_firstname    = $_POST['child_firstname'];
    $child_dob          = $_POST['child_dob'];

    $statement = $bdd->prepare("INSERT INTO children (child_firstname, child_lastname, child_dob) VALUE (?, ?, ?)");
    $statement->execute(array($child_firstname, $child_lastname, $child_dob));

    echo '<script type="text/javascript">document.location.replace("children_list.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2 class="pl-3">Ajouter un enfant</h2>
        </div>

        <div class="col-auto">
            <table class="table-responsive">
                <tr>
                    <td>
                        <?php
                        echo '<form method="post" action="children_list.php" role="form">';
                        echo '<input type="submit" name="insert" class="btn btn-warning" value="Enfants">';
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

        <form class="pt-4 pb-4 bg-secondary text-white form-inline" action="" role="form" method="post" enctype="multipart/form-data">

            <div class="mb-4 form-group">
                <label style="width: 180px" class="d-inline pl-4" for="child_firstname">Prénom de l'enfant</label>
                <input style="width: 180px" type="text" class="form-control" id="child_firstname" name="child_firstname">
            </div>
            
            <div class="mb-4 form-group">
                <label style="width: 180px" class="d-inline pl-4" for="child_lastname">Nom de l'enfant</label>
                <input style="width: 180px" type="text" class="form-control" id="child_lastname" name="child_lastname">
            </div>

            <div class="mb-4 form-group">
                <label style="width: 180px" class="d-inline pl-4" for="child_dob">Date de naissance</label>
                <input style="width: 180px" type="text" class="form-control" id="child_dob" name="child_dob">
            </div>

            <input class="btn btn-block btn-success text-uppercase" name="ajouter" type="submit" value="Ajouter l'enfant">

        </form>

    </div>

</div>

<?php require_once('_footer.php'); ?>