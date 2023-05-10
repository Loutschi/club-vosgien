<?php session_start(); ?>

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
// echo '/<pre>';
?>

<?php
if (isset($_POST['ajouter'])) {
    $civ_name               = $_POST['civ_name'];
    $FunctionID             = $_POST['FunctionID'];
    $spouse_firstname       = $_POST['spouse_firstname'];
    $spouse_lastname        = $_POST['spouse_lastname'];
    $spouse_dob             = $_POST['spouse_dob'];
    $spouse_profession      = $_POST['spouse_profession'];
    $spouse_address         = $_POST['spouse_address'];
    $spouse_zip             = $_POST['spouse_zip'];
    $spouse_city            = $_POST['spouse_city'];
    $spouse_country         = $_POST['spouse_country'];
    $spouse_phone           = $_POST['spouse_phone'];
    $spouse_mobile          = $_POST['spouse_mobile'];
    $spouse_email           = $_POST['spouse_email'];

    $statement = $bdd->prepare("INSERT INTO spouses (civ_name, FunctionID, spouse_firstname, spouse_lastname, spouse_dob, spouse_profession, spouse_address, spouse_zip, spouse_city, spouse_country, spouse_phone, spouse_mobile, spouse_email) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($civ_name, $FunctionID, $spouse_firstname, $spouse_lastname, $spouse_dob, $spouse_profession, $spouse_address, $spouse_zip, $spouse_city, $spouse_country, $spouse_phone, $spouse_mobile, $spouse_email));

    echo '<script type="text/javascript">document.location.replace("spouses_list.php");</script>';
    exit();
}

?>


<div class="container">

    <div class="row justify-content-center mt-4">


        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Ajoutez un conjoint</h2>
        </div>

        <div class="col-auto">
            <table class="table-responsive">
                <tr>
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
                        echo '<form method="post" action="children_list.php" role="form">';
                        echo '<input type="submit" name="insert" class="btn btn-warning" value="Enfants">';
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

        <form class="pt-4 pb-4 bg-secondary text-white form-inline" action="" id="form" role="form" method="post" enctype="multipart/form-data">

            <input style="width:230px" type="hidden" class="form-control" id="FunctionID" name="FunctionID" value="4">

            <div class="mb-4 form-group">
                <label style="width:100px" class="d-inline pl-4" for="civ_name">Civilités</label>
                <select style="width:160px" class="form-control" name="civ_name">
                    <?php
                    $civ_name = ($item['civ_name']);
                    foreach ($bdd->query('SELECT * FROM civ') as $row) {
                        if ($row['civ_name'] == $civ_name)
                            echo '<option selected="selected" value="' . $row['civ_name'] . '">' . $row['civ_name'] . ' </option>';
                        else
                            echo '<option value="' . $row['civ_name'] . '">' . $row['civ_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4 form-group">
                <label style="width:200px" class="d-inline pl-4" for="spouse_firstname">Prénom du conjoint</label>
                <input style="width:220px" type="text" class="form-control" id="spouse_firstname" name="spouse_firstname" value="<?php if (isset($_POST['spouse_firstname'])) {
                                                                                                                                        echo htmlentities($_POST['spouse_firstname']);
                                                                                                                                    } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:200px" class="d-inline pl-4" for="spouse_lastname">Nom du conjoint</label>
                <input style="width:220px" type="text" class="form-control" id="spouse_lastname" name="spouse_lastname" value="<?php if (isset($_POST['spouse_lastname'])) {
                                                                                                                                    echo htmlentities($_POST['spouse_lastname']);
                                                                                                                                } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_dob">Date de naissance (format jj/mm/aaaa)</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_dob" name="spouse_dob" value="<?php if (isset($_POST['spouse_dob'])) {
                                                                                                                            echo htmlentities($_POST['spouse_dob']);
                                                                                                                        } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_profession">Profession</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_profession" name="spouse_profession" value="<?php if (isset($_POST['spouse_profession'])) {
                                                                                                                                        echo htmlentities($_POST['spouse_profession']);
                                                                                                                                    } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_address">Adresse</label>
                <input style="width:850px" type="text" class="form-control" id="spouse_address" name="spouse_address" value="<?php if (isset($_POST['spouse_address'])) {
                                                                                                                                    echo htmlentities($_POST['spouse_address']);
                                                                                                                                } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_zip">Code Postal</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_zip" name="spouse_zip" value="<?php if (isset($_POST['spouse_zip'])) {
                                                                                                                            echo htmlentities($_POST['spouse_zip']);
                                                                                                                        } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_city">Ville</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_city" name="spouse_city" value="<?php if (isset($_POST['spouse_city'])) {
                                                                                                                            echo htmlentities($_POST['spouse_city']);
                                                                                                                        } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_country">Pays</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_country" name="spouse_country" value="<?php if (isset($_POST['spouse_country'])) {
                                                                                                                                    echo htmlentities($_POST['spouse_country']);
                                                                                                                                } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_phone">N° de téléphone fixe</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_phone" name="spouse_phone" value="<?php if (isset($_POST['spouse_phone'])) {
                                                                                                                                echo htmlentities($_POST['spouse_phone']);
                                                                                                                            } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_mobile">N° de téléphone mobile</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_mobile" name="spouse_mobile" value="<?php if (isset($_POST['spouse_mobile'])) {
                                                                                                                                echo htmlentities($_POST['spouse_mobile']);
                                                                                                                            } ?>">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="spouse_email">Adresse email</label>
                <input style="width:300px" type="text" class="form-control" id="spouse_email" name="spouse_email" value="<?php if (isset($_POST['spouse_email'])) {
                                                                                                                                echo htmlentities($_POST['spouse_email']);
                                                                                                                            } ?>">
            </div>

            <input class="btn btn-block btn-success text-uppercase" name="ajouter" type="submit" value="Ajouter le conjoint">

        </form>

    </div>
</div>

<?php require_once('_footer.php'); ?>