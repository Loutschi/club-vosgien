<?php session_start();
$_SESSION['SpouseID'] = $_POST['SpouseID'];
?>

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
if (!empty($_SESSION['SpouseID'])) {
    $SpouseID = ($_SESSION['SpouseID']);
    $statement = $bdd->prepare("SELECT * FROM spouses WHERE SpouseID = ?");
    $statement->execute(array($SpouseID));
    $item = $statement->fetch();
    $SpouseID = $item['SpouseID'];
}
?>

<?php
if (isset($_POST['modifier'])) {
    $SpouseID                   = $_POST['SpouseID'];
    $FunctionID                 = $_POST['FunctionID'];
    $spouse_cvnum               = $_POST['spouse_cvnum'];
    $civ_name                   = $_POST['civ_name'];
    $spouse_lastname            = $_POST['spouse_lastname'];
    $spouse_firstname           = $_POST['spouse_firstname'];
    $spouse_dob                 = $_POST['spouse_dob'];
    $spouse_profession          = $_POST['spouse_profession'];
    $spouse_address             = $_POST['spouse_address'];
    $spouse_zip                 = $_POST['spouse_zip'];
    $spouse_city                = $_POST['spouse_city'];
    $spouse_country             = $_POST['spouse_country'];
    $spouse_phone               = $_POST['spouse_phone'];
    $spouse_mobile              = $_POST['spouse_mobile'];
    $spouse_email               = $_POST['spouse_email'];
    $spouse_med_certif_date     = $_POST['spouse_med_certif_date'];
    $spouse_diploma_year        = $_POST['spouse_diploma_year'];
    $spouse_sylver_holly_year   = $_POST['spouse_sylver_holly_year'];
    $spouse_gold_holly_year     = $_POST['spouse_gold_holly_year'];
    $spouse_varius              = $_POST['spouse_varius'];

    $statement = $bdd->prepare("UPDATE spouses SET spouse_cvnum = ?, civ_name = ?, spouse_firstname = ?, spouse_lastname = ?, spouse_profession = ?, spouse_dob = ?, spouse_address = ?, spouse_zip = ?, spouse_city = ?, spouse_country = ?, spouse_phone = ?, spouse_mobile = ?, spouse_email = ?, spouse_med_certif_date = ?, FunctionID = ?, spouse_diploma_year = ?, spouse_sylver_holly_year = ?, spouse_gold_holly_year = ?, spouse_varius = ? WHERE SpouseID = ?");
    $statement->execute(array($spouse_cvnum, $civ_name, $spouse_firstname, $spouse_lastname, $spouse_profession, $spouse_dob, $spouse_address, $spouse_zip, $spouse_city, $spouse_country, $spouse_phone, $spouse_mobile, $spouse_email, $spouse_med_certif_date, $FunctionID, $spouse_diploma_year, $spouse_sylver_holly_year, $spouse_gold_holly_year, $spouse_varius, $SpouseID));

    echo '<script type="text/javascript">document.location.replace("spouses_list.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Modifier le profil du conjoint <?php echo ucfirst($item['spouse_firstname']) . " " . strtoupper($item['spouse_lastname']); ?></h2>
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

    </div>

    <?php
    if (!empty($_SESSION['SpouseID'])) {
        $SpouseID = $_SESSION['SpouseID'];
        $statement = $bdd->prepare("SELECT * FROM spouses WHERE SpouseID = ?");
        $statement->execute(array($SpouseID));
    }
    while ($item = $statement->fetch()) {
    ?>

        <div class="row justify-content-center">

            <div class="col-lg-12 bg-secondary text-white mb-4">

                <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                    <input style="width:250px" type="hidden" class="form-control" id="SpouseID" name="SpouseID" value="<?php echo $item['SpouseID']; ?>">

                    <div class="mb-4 mt-4 form-group">
                        <label style="width: 1100px" class="bg-primary text-white d-inline pl-4">Informations saisies par l'adhérent lors de la souscription</label>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:150px" class="d-inline pl-4" for="civ_name">Civilités</label>
                        <select style="width:150px" class="form-control" name="civ_name">
                            <?php
                            if (!empty($item['civ_name'])) {
                                $civ_name = ($item['civ_name']);
                                foreach ($bdd->query('SELECT * FROM civ') as $row) {
                                    if ($row['civ_name'] == $civ_name)
                                        echo '<option selected="selected" value="' . $row['civ_name'] . '">' . $row['civ_name'] . ' </option>';
                                    else
                                        echo '<option value="' . $row['civ_name'] . '">' . $row['civ_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:200px" class="d-inline pl-4" for="spouse_firstname">Prénom du conjoint</label>
                        <input style="width:200px" type="text" class="form-control" id="spouse_firstname" name="spouse_firstname" value="<?php echo $item['spouse_firstname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:200px" class="d-inline pl-4" for="spouse_lastname">Nom du conjoint</label>
                        <input style="width:200px" type="text" class="form-control" id="spouse_lastname" name="spouse_lastname" value="<?php echo $item['spouse_lastname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_profession">Profession</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_profession" name="spouse_profession" value="<?php echo $item['spouse_profession']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_dob">Date de naissance (format jj/mm/aaaa)</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_dob" name="spouse_dob" value="<?php echo $item['spouse_dob']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_address">Adresse</label>
                        <input style="width:850px" type="text" class="form-control" id="spouse_address" name="spouse_address" value="<?php echo $item['spouse_address']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_zip">Code Postal</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_zip" name="spouse_zip" value="<?php echo $item['spouse_zip']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_city">Ville</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_city" name="spouse_city" value="<?php echo $item['spouse_city']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_country">Pays</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_country" name="spouse_country" value="<?php echo $item['spouse_country']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_phone">N° de téléphone fixe</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_phone" name="spouse_phone" value="<?php echo wordwrap(($item['spouse_phone']), 2, ' ', true); ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_mobile">N° de téléphone mobile</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_mobile" name="spouse_mobile" value="<?php echo wordwrap(($item['spouse_mobile']), 2, ' ', true); ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_email">Adresse email</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_email" name="spouse_email" value="<?php echo $item['spouse_email']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width: 1100px" class="bg-primary text-white d-inline pl-4">Informations à mettre à jour par l'administrateur(trice)</label>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width: 250px" class="d-inline pl-4">Modifier la fonction</label>
                        <select style="width:300px" class="form-control" name="FunctionID">
                            <?php

                            if (!empty($item['FunctionID'])) {
                                $FunctionID = ($item['FunctionID']);
                                foreach ($bdd->query('SELECT * FROM functions') as $row) {
                                    if ($row['FunctionID'] == $FunctionID)
                                        echo '<option selected="selected" value="' . $row['FunctionID'] . '">' . $row['function_name'] . ' </option>';
                                    else
                                        echo '<option value="' . $row['FunctionID'] . '">' . $row['function_name'] . ' </option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_cvnum">N° CV conjoint</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_cvnum" name="spouse_cvnum" value="<?php echo $item['spouse_cvnum']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_accession_date">Membre depuis le</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_accession_date" name="spouse_accession_date" value="<?php echo $item['spouse_accession_date']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_med_certif_date">Date du certificat médical</label>
                        <input style="width:300px" type="text" class="form-control" id="spouse_med_certif_date" name="spouse_med_certif_date" value="<?php echo $item['spouse_med_certif_date']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_diploma_year">Année du diplôme</label>
                        <input style="width:120px" type="text" class="form-control" id="spouse_diploma_year" name="spouse_diploma_year" value="<?php echo $item['spouse_diploma_year']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:240px" class="d-inline pl-4" for="spouse_sylver_holly_year">Année houx d'argent</label>
                        <input style="width:120px" type="text" class="form-control" id="spouse_sylver_holly_year" name="spouse_sylver_holly_year" value="<?php echo $item['spouse_sylver_holly_year']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="spouse_gold_holly_year">Année houx d'or</label>
                        <input style="width:120px" type="text" class="form-control" id="spouse_gold_holly_year" name="spouse_gold_holly_year" value="<?php echo $item['spouse_gold_holly_year']; ?>">
                    </div>

        

                    <div class="mb-4 form-group text-dark">
                        <label style="width:250px" class="d-inline pl-4 text-white" for="spouse_varius">Notes, observation</label>
                        <textarea class="form-control" id="summernote" name="spouse_varius"><?php echo $item['spouse_varius']; ?></textarea>
                        <script>
                            $('#summernote').summernote({
                                placeholder: 'Saississez votre message',
                                tabsize: 2,
                                height: 200,
                                width: 855
                            });
                        </script>
                    </div>

                <?php } ?>

                <div class="pl-4 mb-4 form-group">
                    <button style="width:1080px" type="submit" name="modifier" class="btn btn-lg btn-block btn-success text-uppercase">Modifier le profil du/de la conjoint(e)</button>
                </div>

                </form>

            </div>
        </div>
</div>

<?php require_once('_footer.php'); ?>