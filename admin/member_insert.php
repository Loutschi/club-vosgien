<?php session_start(); ?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once('../bdd.php');
$bdd = bdd();
?>

<?php
if (!empty($_SESSION['MemberID'])) {
    $MemberID = ($_SESSION['MemberID']);
    $statement = $bdd->prepare("SELECT * FROM members WHERE MemberID = ?");
    $statement->execute(array($MemberID));
    $item = $statement->fetch();
}
?>

<?php
// echo '<pre>';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '</pre>';
?>


<?php
if (isset($_POST['ajouter'])) {
    $member_cvnum               = $_POST['member_cvnum'];
    $civ_name                   = $_POST['civ_name'];
    $member_firstname           = $_POST['member_firstname'];
    $member_lastname            = $_POST['member_lastname'];
    $member_dob                 = $_POST['member_dob'];
    $member_profession          = $_POST['member_profession'];
    $member_address             = $_POST['member_address'];
    $member_zip                 = $_POST['member_zip'];
    $member_city                = $_POST['member_city'];
    $member_country             = $_POST['member_country'];
    $member_phone               = $_POST['member_phone'];
    $member_mobile              = $_POST['member_mobile'];
    $member_email               = $_POST['member_email'];
    $SpouseID                   = $_POST['SpouseID'];
    $member_accession_date      = $_POST['member_accession_date'];
    $member_med_certif_date     = $_POST['member_med_certif_date'];
    $member_diploma_year        = $_POST['member_diploma_year'];
    $member_silver_holly_year   = $_POST['member_silver_holly_year'];
    $member_gold_holly_year     = $_POST['member_gold_holly_year'];
    $accession_payment          = $_POST['accession_payment'];
    $magazine                   = $_POST['magazine'];
    $SubscriptionID             = $_POST['SubscriptionID'];
    $FunctionID                 = $_POST['FunctionID'];
    $member_varius              = $_POST['member_varius'];

    $statement = $bdd->prepare("INSERT INTO members (member_cvnum, civ_name, member_firstname, member_lastname, member_dob, member_profession, member_address, member_zip, member_city, member_country, member_phone, member_mobile, member_email, SpouseID, member_accession_date, member_med_certif_date, member_diploma_year, member_silver_holly_year, member_gold_holly_year, accession_payment, magazine, SubscriptionID, FunctionID, member_varius) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($member_cvnum, $civ_name, $member_firstname, $member_lastname, $member_dob, $member_profession, $member_address, $member_zip, $member_city, $member_country, $member_phone, $member_mobile, $member_email, $SpouseID, $member_accession_date, $member_med_certif_date, $member_diploma_year, $member_silver_holly_year, $member_gold_holly_year, $accession_payment, $magazine, $SubscriptionID, $FunctionID, $member_varius));

    echo '<script type="text/javascript">document.location.replace("members_list_alpha.php");</script>';
    exit();
}
?>

<div class="container">


    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Ajouter un nouvel adhérent</h2>
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

        <form class="pt-4 pb-4 bg-secondary text-white form-inline" action="" role="form" method="post" enctype="multipart/form-data">

            <input style="width:230px" type="hidden" class="form-control" id="SpouseID" name="SpouseID" value="1">

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_cvnum">N° Club Vosgien</label>
                <input style="width:300px" type="text" class="form-control" id="member_cvnum" name="member_cvnum">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="civ_name">Civilités</label>
                <select style="width:300px" class="form-control" name="civ_name">
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
                <label style="width:250px" class="d-inline pl-4" for="member_firstname">Prénom du membre</label>
                <input style="width:300px" type="text" class="form-control" id="member_firstname" name="member_firstname">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_lastname">Nom du membre</label>
                <input style="width:300px" type="text" class="form-control" id="member_lastname" name="member_lastname">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_dob">Date de naissance (format jj/mm/aaaa)</label>
                <input style="width:300px" type="text" class="form-control" id="member_dob" name="member_dob">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_profession">Profession</label>
                <input style="width:300px" type="text" class="form-control" id="member_profession" name="member_profession">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_address">Adresse</label>
                <input style="width:850px" type="text" class="form-control" id="member_address" name="member_address">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_zip">Code Postal</label>
                <input style="width:300px" type="text" class="form-control" id="member_zip" name="member_zip">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_city">Ville</label>
                <input style="width:300px" type="text" class="form-control" id="member_city" name="member_city">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_country">Pays</label>
                <input style="width:300px" type="text" class="form-control" id="member_country" name="member_country">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_phone">N° de téléphone fixe</label>
                <input style="width:300px" type="text" class="form-control" id="member_phone" name="member_phone">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_mobile">N° de téléphone mobile</label>
                <input style="width:300px" type="text" class="form-control" id="member_mobile" name="member_mobile">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_email">Adresse email</label>
                <input style="width:300px" type="text" class="form-control" id="member_email" name="member_email">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_accession_date">Date de souscription</label>
                <input style="width:300px" type="text" class="form-control" id="member_accession_date" name="member_accession_date">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_med_certif_date">Date du certificat médical</label>
                <input style="width:300px" type="text" class="form-control" id="member_med_certif_date" name="member_med_certif_date">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_diploma_year">Année du diplôme</label>
                <input style="width:120px" type="text" class="form-control" id="member_diploma_year" name="member_diploma_year">
            </div>

            <div class="mb-4 form-group">
                <label style="width:240px" class="d-inline pl-4" for="member_silver_holly_year">Année houx d'argent</label>
                <input style="width:120px" type="text" class="form-control" id="member_silver_holly_year" name="member_silver_holly_year">
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_gold_holly_year">Année houx d'or</label>
                <input style="width:120px" type="text" class="form-control" id="member_gold_holly_year" name="member_gold_holly_year">
            </div>


            <div class="mb-4 form-group">
                <label style="width:200px" class="d-inline ml-4" for="accession_payment">Paiement de la cotisation</label>
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

            <div class="mb-4 form-group">
                <label style="width:500px" class="d-inline ml-4 text-right pr-4" for="magazine">Revue</label>
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

            <div class="mb-4 form-group">
                <label style="width: 250px" class="d-inline pl-4" for="SubscriptionID">Abonnement</label>
                <select style="width:850px" class="form-control" id="SubscriptionID" name="SubscriptionID">
                    <?php
                    $SubscriptionID = ($item['SubscriptionID']);
                    foreach ($bdd->query('SELECT * FROM subscriptions') as $row) {
                        if ($row['SubscriptionID'] == $SubscriptionID)
                            echo '<option selected="selected" value="' . $row['SubscriptionID'] . '">' . $row['subscription_name'] . 'au prix de ' . $row['subscription_price'] . ' €</option>';
                        else
                            echo '<option value="' . $row['SubscriptionID'] . '">' . $row['subscription_name'] . ' au prix de ' . $row['subscription_price'] . ' €</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4 form-group">
                <label style="width: 250px" class="d-inline pl-4" for="FunctionID">Modifier la fonction</label>
                <select style="width:850px" class="form-control" id="FunctionID" name="FunctionID">
                    <?php
                    foreach ($bdd->query('SELECT * FROM functions') as $row) {
                        if ($row['FunctionID'] == $FunctionID)
                            echo '<option selected="selected" value="' . $row['FunctionID'] . '">' . $row['function_name'] . '</option>';
                        else
                            echo '<option value="' . $row['FunctionID'] . '">' . $row['function_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4 form-group">
                <label style="width:250px" class="d-inline pl-4" for="member_varius">Notes, observation</label>
                <textarea class="form-control" id="summernote" name="member_varius"></textarea>
                <script>
                    $('#summernote').summernote({
                        placeholder: 'Saississez votre message',
                        tabsize: 2,
                        height: 150,
                        width: 850
                    });
                </script>
            </div>

            <div class="col-lg-12">
                <section class="jumbotron text-center">
                    <div class="mb-4">
                        <button type="submit" name="ajouter" class="btn btn-lg btn-block btn-success text-uppercase">Ajouter le nouveau membre</button>
                    </div>
                </section>
            </div>

        </form>

    </div>
</div>

<?php require_once('_footer.php'); ?>