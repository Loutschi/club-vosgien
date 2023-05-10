<?php session_start();
$_SESSION['MemberID'] = $_POST['MemberID'];
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
// echo '/<pre>';
?>

<?php
if (!empty($_SESSION['MemberID'])) {
    $MemberID = ($_SESSION['MemberID']);
    $statement = $bdd->prepare("SELECT * FROM members WHERE MemberID = ?");
    $statement->execute(array($MemberID));
    $item = $statement->fetch();
    $MemberID = $item['MemberID'];
}
?>

<?php
if (isset($_POST['modifier'])) {
    $MemberID                   = $_POST['MemberID'];
    $SpouseID                   = $_POST['SpouseID'];
    $civ_name                   = $_POST['civ_name'];
    $member_cvnum               = $_POST['member_cvnum'];
    $member_firstname           = $_POST['member_firstname'];
    $member_lastname            = $_POST['member_lastname'];
    $member_profession          = $_POST['member_profession'];
    $member_dob                 = $_POST['member_dob'];
    $member_address             = $_POST['member_address'];
    $member_zip                 = $_POST['member_zip'];
    $member_city                = $_POST['member_city'];
    $member_country             = $_POST['member_country'];
    $member_phone               = $_POST['member_phone'];
    $member_mobile              = $_POST['member_mobile'];
    $member_email               = $_POST['member_email'];
    $member_accession_date      = $_POST['member_accession_date'];
    $member_med_certif_date     = $_POST['member_med_certif_date'];
    $member_diploma_year        = $_POST['member_diploma_year'];
    $member_silver_holly_year   = $_POST['member_silver_holly_year'];
    $member_gold_holly_year     = $_POST['member_gold_holly_year'];
    $magazine                   = $_POST['magazine'];
    $accession_payment          = $_POST['accession_payment'];
    $FunctionID                 = $_POST['FunctionID'];
    $SubscriptionID             = $_POST['SubscriptionID'];
    $member_varius              = $_POST['member_varius'];

    $statement = $bdd->prepare("UPDATE members SET SpouseID = ?, civ_name = ?, member_cvnum = ?, member_firstname = ?, member_lastname = ?, member_profession = ?, member_dob = ?, member_address = ?, member_zip = ?, member_city = ?, member_country = ?, member_phone = ?, member_mobile = ?, member_email = ?, member_accession_date = ?, member_med_certif_date = ?, member_diploma_year = ?, member_silver_holly_year = ?, member_gold_holly_year = ?, magazine = ?, accession_payment = ?, FunctionID = ?, SubscriptionID = ?, member_varius = ? WHERE MemberID = ?");
    $statement->execute(array($SpouseID, $civ_name, $member_cvnum, $member_firstname, $member_lastname, $member_profession, $member_dob, $member_address, $member_zip, $member_city, $member_country, $member_phone, $member_mobile, $member_email, $member_accession_date, $member_med_certif_date, $member_diploma_year, $member_silver_holly_year, $member_gold_holly_year, $magazine, $accession_payment, $FunctionID, $SubscriptionID, $member_varius, $MemberID));

    echo '<script type="text/javascript">document.location.replace("members_list_alpha.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Modifier le profil de l'adhérent <?php echo ucfirst($item['member_firstname']) . " " . strtoupper($item['member_lastname']); ?></h2>
        </div>

        <div class="col-auto">
            <table class="table-responsive">
                <tr>
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
                    <td>
                        <?php
                        echo '<form method="post" action="spouses_list.php" role="form">';
                        echo '<input type="submit" name="insert" class="btn btn-warning" value="Conjoints">';
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
                        echo '<input type="submit" class="btn btn-danger text-white" value="Backoffice">';
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
    if (!empty($_SESSION['MemberID'])) {
        $MemberID = $_SESSION['MemberID'];
        $statement = $bdd->prepare("SELECT * FROM members WHERE MemberID = ?");
        $statement->execute(array($MemberID));
    }
    while ($item = $statement->fetch()) {
    ?>
        <div class="row justify-content-center">

            <div class="col-lg-12 bg-secondary text-white mb-4">

                <form class="form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                    <input style="width:250px" type="hidden" class="form-control" id="MemberID" name="MemberID" value="<?php echo $item['MemberID']; ?>">


                    <div class="mb-4 mt-4 form-group">
                        <label style="width: 1100px" class="bg-primary text-white d-inline pl-4">Informations saisies par l'adhérent lors de la souscription</label>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:150px" class="d-inline pl-4" for="civ_name">Civilités</label>
                        <select style="width:150" class="form-control" name="civ_name">
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
                        <label style="width:200px" class="d-inline pl-4" for="member_firstname">Prénom de l'adhérent</label>
                        <input style="width:200px" type="text" class="form-control" id="member_firstname" name="member_firstname" value="<?php echo $item['member_firstname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:200px" class="d-inline pl-4" for="member_lastname">Nom de l'adhérent</label>
                        <input style="width:200px" type="text" class="form-control" id="member_lastname" name="member_lastname" value="<?php echo $item['member_lastname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_profession">Profession</label>
                        <input style="width:300px" type="text" class="form-control" id="member_profession" name="member_profession" value="<?php echo $item['member_profession']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_dob">Date de naissance (format jj/mm/aaaa)</label>
                        <input style="width:300px" type="text" class="form-control" id="member_dob" name="member_dob" value="<?php echo $item['member_dob']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_address">Adresse</label>
                        <input style="width:850px" type="text" class="form-control" id="member_address" name="member_address" value="<?php echo $item['member_address']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_zip">Code Postal</label>
                        <input style="width:300px" type="text" class="form-control" id="member_zip" name="member_zip" value="<?php echo $item['member_zip']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_city">Ville</label>
                        <input style="width:300px" type="text" class="form-control" id="member_city" name="member_city" value="<?php echo $item['member_city']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_country">Pays</label>
                        <input style="width:300px" type="text" class="form-control" id="member_country" name="member_country" value="<?php echo $item['member_country']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_phone">N° de téléphone fixe</label>
                        <input style="width:300px" type="text" class="form-control" id="member_phone" name="member_phone" value="<?php echo wordwrap(($item['member_phone']), 2, ' ', true); ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_mobile">N° de téléphone mobile</label>
                        <input style="width:300px" type="text" class="form-control" id="member_mobile" name="member_mobile" value="<?php echo wordwrap(($item['member_mobile']), 2, ' ', true); ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_email">Adresse email</label>
                        <input style="width:300px" type="text" class="form-control" id="member_email" name="member_email" value="<?php echo $item['member_email']; ?>">
                    </div>

                    <div class="mb-4 mt-4 form-group">
                        <label style="width: 1100px" class="bg-primary text-white d-inline pl-4">Informations à mettre à jour par l'administrateur(trice)</label>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_cvnum">N° CV Adhérent</label>
                        <input style="width:200px" type="text" class="form-control" id="member_cvnum" name="member_cvnum" value="<?php echo $item['member_cvnum']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width: 250px" class="d-inline pl-4">Nom du conjoint</label>
                        <select style="width: 400px" class="form-control" name="SpouseID">
                            <?php
                            if (!empty($item['SpouseID'])) {
                                $SpouseID = ($item['SpouseID']);
                                foreach ($bdd->query('SELECT * FROM spouses') as $row) {
                                    if ($row['SpouseID'] == $SpouseID)
                                        echo '<option selected="selected" value="' . $row['SpouseID'] . '">' . $row['civ_name'] . ' ' . $row['spouse_firstname'] . ' ' . $row['spouse_lastname'] . ' </option>';
                                    else
                                        echo '<option value="' . $row['SpouseID'] . '">' . $row['civ_name'] . ' ' . $row['spouse_firstname'] . ' ' . $row['spouse_lastname'] . ' </option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_accession_date">Membre depuis le</label>
                        <input style="width:250px" type="text" class="form-control" id="member_accession_date" name="member_accession_date" value="<?php echo $item['member_accession_date']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:300px" class="d-inline pl-4" for="member_med_certif_date">Date du certificat médical</label>
                        <input style="width:300px" type="text" class="form-control" id="member_med_certif_date" name="member_med_certif_date" value="<?php echo $item['member_med_certif_date']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_diploma_year">Année du diplôme</label>
                        <input style="width:120px" type="text" class="form-control" id="member_diploma_year" name="member_diploma_year" value="<?php echo $item['member_diploma_year']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:240px" class="d-inline pl-4" for="member_silver_holly_year">Année houx d'argent</label>
                        <input style="width:120px" type="text" class="form-control" id="member_silver_holly_year" name="member_silver_holly_year" value="<?php echo $item['member_silver_holly_year']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="member_gold_holly_year">Année houx d'or</label>
                        <input style="width:120px" type="text" class="form-control" id="member_gold_holly_year" name="member_gold_holly_year" value="<?php echo $item['member_gold_holly_year']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width: 250px" class="d-inline pl-4">Modifier la fonction</label>
                        <select style="width:850px" class="form-control" name="FunctionID">
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
                        <label style="width: 250px" class="d-inline pl-4">Modifier l'abonnement</label>
                        <select style="width:850px" class="form-control" name="SubscriptionID">
                            <?php
                            if (!empty($item['SubscriptionID'])) {
                                $SubscriptionID = ($item['SubscriptionID']);
                                foreach ($bdd->query('SELECT * FROM subscriptions') as $row) {
                                    if ($row['SubscriptionID'] == $SubscriptionID)
                                        echo '<option selected="selected" value="' . $row['SubscriptionID'] . '">' . $row['subscription_name'] . ' au prix de ' . $row['subscription_price'] . ' €</option>';
                                    else
                                        echo '<option value="' . $row['SubscriptionID'] . '">' . $row['subscription_name'] . ' au prix de ' . $row['subscription_price'] . ' €</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <fieldset>
                        <div class="mb-4 form-group">
                            <label style="width:250px" class="d-inline pl-4" for="magazine">Revue</label>
                            <input style="width:300px" type="text" class="form-control" id="magazine" name="magazine" value="<?php echo $item['magazine']; ?>">
                        </div>
                    </fieldset>
                    <div class="mb-4 form-group">
                        <label style="width:300px" class="d-inline ml-4" for="magazine">Modifier choix revue</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="oui" name="magazine" <?php if (isset($item['magazine']) && $item['magazine'] == "oui") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                            <label class="form-check-label">Oui</label>
                        </div>

                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" value="non" name="magazine" <?php if (isset($item['magazine']) && $item['magazine'] == "non") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                            <label class="form-check-label">Non</label>
                        </div>
                    </div>

                    <fieldset>
                        <div class="mb-4 form-group">
                            <label style="width:250px" class="d-inline pl-4 " for="accession_payment">Paiement cotisation</label>
                            <input style="width:300px" type="text" class="form-control" id="accession_payment" name="accession_payment" value="<?php echo $item['accession_payment']; ?>">
                        </div>
                    </fieldset>
                    <div class="mb-4 form-group">
                        <label style="width:300px" class="d-inline ml-4" for="accession_payment">Modifier état cotisation</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="A jour" name="accession_payment" <?php if (isset($item['accession_payment']) && $item['accession_payment'] == "A jour") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                            <label class="form-check-label" for="inlineRadio1">A jour</label>
                        </div>
                        <div class="form-check form-check-inline ml-4">
                            <input class="form-check-input" type="radio" value="Non à jour" name="accession_payment" <?php if (isset($item['accession_payment']) && $item['accession_payment'] == "Non à jour") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                            <label class="form-check-label" for="inlineRadio2">Non à jour</label>
                        </div>
                    </div>

                    <div class="mb-4 form-group text-dark">
                        <label style="width:250px" class="d-inline pl-4 text-white" for="member_varius">Notes, observation</label>
                        <textarea class="form-control" id="summernote" name="member_varius"><?php echo $item['member_varius']; ?></textarea>
                        <script>
                            $('#summernote').summernote({
                                placeholder: 'Saississez votre message',
                                tabsize: 2,
                                height: 150,
                                width: 850
                            });
                        </script>
                    </div>

                <?php } ?>

                <div class="pl-4 mb-4 form-group">
                    <button style="width:1080px" type="submit" name="modifier" class="btn btn-lg btn-block btn-success text-uppercase">Modifier le profil du membre</button>
                </div>

                </form>
            </div>
        </div>
</div>

<?php require_once('_footer.php'); ?>