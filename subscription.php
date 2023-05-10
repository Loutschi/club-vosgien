<?php session_start();
$_SESSION['SubscriptionID'] = $_POST['SubscriptionID'];
$_SESSION['paymod'] = $_POST['paymod'];
?>

<?php
require_once('_nav.php');
require_once('_head.php');
require_once '_header2.php';
require_once('bdd.php');
require_once 'vendor/autoload.php';
$bdd = bdd();
?>

<?php
// echo '<pre>';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '</pre>';
?>

<style>
    /* Définition de l'animation */
    @keyframes blink {
        0% { opacity: 1; } /* État initial */
        50% { opacity: 0; } /* Disparition */
        100% { opacity: 1; } /* Réapparition */
    }

    /* Application de l'animation au texte */
    .clignotant {
        animation: blink 1s infinite; /* Nom de l'animation, durée et répétition */
    }
</style>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if (!empty($_SESSION['SubscriptionID'])) {
    $SubscriptionID = ($_SESSION['SubscriptionID']);
    $statement = $bdd->prepare("SELECT * FROM subscriptions WHERE SubscriptionID = ?");
    $statement->execute(array($SubscriptionID));
    $item = $statement->fetch();
    $SubscriptionID       = $item['SubscriptionID'];
    $subscription_name    = $item['subscription_name'];
    $subscription_price   = $item['subscription_price'];
}
?>


<div class="container">

    <div class="row justify-content-center">

        <div class="bg-secondary text-white text-center mt-4 mb-4">
            <h2 class="pl-3">Formulaire d'adhésion au <b>Club Vosgien de Mulhouse & Crêtes</b> <br>
                <?php
                if (!empty($_SESSION['SubscriptionID'])) {
                    $SubscriptionID = ($_SESSION['SubscriptionID']);
                    $statement = $bdd->prepare("SELECT * FROM subscriptions WHERE SubscriptionID = ?");
                    $statement->execute(array($SubscriptionID));
                    $item = $statement->fetch();
                }
                echo $item['subscription_name']; ?> <br>
                au prix de <?php echo $item['subscription_price']
                            ?> €
        </div>

        <div class="col-auto mb-4">
            <table class="table-responsive">
                <tr>
                    <td>
                        <?php
                        echo '<form method="post" action="adherer-au-cvmc.php" role="form">';
                        echo '<input type="submit" class="btn btn-warning" value="Retour à la page adhésion">';
                        echo '</form>';
                        ?>
                    </td>
                </tr>
            </table>
        </div>

    </div>

<?php
    if (isset($_POST['envoyer'])) {
    if (($_SERVER["REQUEST_METHOD"] == "POST")) {
        $SubscriptionID         = $_POST['SubscriptionID'];
        $FunctionID             = $_POST['FunctionID'];
        $civ_name               = $_POST['civ_name'];
        $SpouseID               = $_POST['SpouseID'];
        $member_firstname       = $_POST['member_firstname'];
        $member_lastname        = $_POST['member_lastname'];
        $member_dob             = $_POST['member_dob'];
        $member_profession      = $_POST['member_profession'];
        $member_address         = $_POST['member_address'];
        $member_zip             = $_POST['member_zip'];
        $member_city            = $_POST['member_city'];
        $member_country         = $_POST['member_country'];
        $member_phone           = $_POST['member_phone'];
        $member_mobile          = $_POST['member_mobile'];
        $member_email           = $_POST['member_email'];
        $paymod                 = $_POST['paymod'];

        if (empty($member_firstname) || empty($member_lastname) || empty($member_dob) || empty($member_profession) || empty($member_address) || empty($member_zip) || empty($member_city) || empty($member_country) || empty($member_email)) {
            echo "<h3 class='alert-danger btn-block text-center'>Veuillez remplir tous les champs !</h3>";
           
        } elseif (empty($member_phone) && (empty($member_mobile))) {
            echo "<h3 class='alert-danger btn-block text-center'>Veuillez saisir un numéro de téléphone soit mobile soit fixe !</h3>";
            
         } elseif ( !preg_match('/^[0-9]{10}$/', $member_phone) && !empty($member_phone))  {
        echo "<h3 class='alert-danger btn-block text-center'>Votre numéro de téléphone fixe doit être composé de 10 chiffres sans espace !</h3>";
        
        } elseif ( !preg_match('/^[0-9]{10}$/', $member_mobile) && !empty($member_mobile))  {
        echo "<h3 class='alert-danger btn-block text-center'>Votre numéro de téléphone mobile doit être composé de 10 chiffres sans espace !</h3>";
        
        } elseif (!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
            echo "<h3 class='alert-danger btn-block text-center'>Veuillez saisir une adresse email valide !</h3>";            

        } elseif (empty($paymod)) {
            echo "<h3 class='clignotant alert-danger btn-block text-center'>Veuillez cocher votre mode de paiement !</h3>";

        } elseif ($_POST['SubscriptionID'] == 2 || $_POST['SubscriptionID'] == 4 || $_POST['SubscriptionID'] == 6) {
            $statement = $bdd->prepare("INSERT INTO members (SubscriptionID, FunctionID, civ_name, SpouseID, member_firstname, member_lastname, member_profession, member_dob, member_address, member_zip, member_city, member_country, member_phone, member_mobile, member_email, paymod) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($SubscriptionID, $FunctionID, $civ_name, $SpouseID, $member_firstname, $member_lastname, $member_profession, $member_dob, $member_address, $member_zip, $member_city, $member_country, $member_phone, $member_mobile, $member_email, $paymod));
            echo '<script type="text/javascript">document.location.replace("admin/spouse_insert.php"); </script>';
            if (isset($_POST['envoyer'])) {
            try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
            $mail->Host         = 'node28-eu.n0c.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contact@web-services.tech';
            $mail->Password     = 'asc123!321CSA';
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port         = 465;
            $mail->CharSet      = 'UTF-8';
            $mail->setFrom('noreply@club-vosgien-mulhouse.com', 'Nouvelle adhésion');
            $mail->addAddress('annemarie.schlawick@gmail.com', 'Anne-Marie SCHLAWICK');
            $mail->addBCC('ali@bouaouina.fr', 'Ali BOUAOUINA');
            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Adhésion de ' . ucfirst($_POST['civ_name']) . ' ' . ucfirst($_POST['member_firstname']) . ' ' . strtoupper($_POST['member_lastname']) . ' ');
            $mail->Body
                = "
                <!DOCTYPE html>
                <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                </head>
                <body style='font-family: Calibri, Arial, sans-serif'>
                    <p>
                        Bonjour Anne-Marie,  <br><br>
                        
                        Madame/Monsieur " . ucfirst($_POST['member_firstname']) . " " . strtoupper($_POST['member_lastname']) . " s'est inscrit(e) en ligne ce jour pour la formule : <br>
                        => <b>" . $subscription_name . "</b> <br>
                        => au prix de <b>" . $subscription_price . " € <b>. <br>
                        => Le paiement a été effectué par <b>" . $_POST['paymod'] . "</b>. <br><br>

                        Ce mail est généré automatiquement, veuillez SVPL ne pas y répondre. <br>
                        Nous vous remercions de votre compréhension.<br><br>

                        <hr style='width:30%;text-align:left;margin-left:0'>
                        <b>Le Club Vosgien Mulhouse & Crêtes</b> <br>
                        <b>Thierry SCHLAWICK Président</b> <br>
                        Pensez ENVIRONNEMENT, n'imprimer que si nécessaire !
                        </p>
                        <hr style='width:30%;text-align:left;margin-left:0'>
                    </body>

                    </html>
                    ";
            $mail->send();
                         } catch (Exception $e) {
                    echo '<h4 class="alert alert-danger" role="alert">Le mail n\'a pas été envoyé.</h4> Mailer Error: {$mail->ErrorInfo}</h4>';
                }
            }
            exit;

        } elseif ($_POST['paymod'] == 'cb') {
            $statement = $bdd->prepare("INSERT INTO members (SubscriptionID, FunctionID, civ_name, SpouseID, member_firstname, member_lastname, member_profession, member_dob, member_address, member_zip, member_city, member_country, member_phone, member_mobile, member_email, paymod) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($SubscriptionID, $FunctionID, $civ_name, $SpouseID, $member_firstname, $member_lastname, $member_profession, $member_dob, $member_address, $member_zip, $member_city, $member_country, $member_phone, $member_mobile, $member_email, $paymod));
            echo '<script type="text/javascript">document.location.replace("https://www.payasso.fr/cvmc/cotisations"); </script>';
            if (isset($_POST['envoyer'])) {
            try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
            $mail->Host         = 'node28-eu.n0c.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contact@web-services.tech';
            $mail->Password     = 'asc123!321CSA';
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port         = 465;
            $mail->CharSet      = 'UTF-8';
            $mail->setFrom('noreply@club-vosgien-mulhouse.com', 'Nouvelle adhésion');
            $mail->addAddress('annemarie.schlawick@gmail.com', 'Anne-Marie SCHLAWICK');
            $mail->addBCC('ali@bouaouina.fr', 'Ali BOUAOUINA');
            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Adhésion de ' . ucfirst($_POST['civ_name']) . ' ' . ucfirst($_POST['member_firstname']) . ' ' . strtoupper($_POST['member_lastname']) . ' ');
            $mail->Body
                = "
                <!DOCTYPE html>
                <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                </head>
                <body style='font-family: Calibri, Arial, sans-serif'>
                    <p>
                        Bonjour Anne-Marie,  <br><br>
                        
                        Madame/Monsieur " . ucfirst($_POST['member_firstname']) . " " . strtoupper($_POST['member_lastname']) . " s'est inscrit(e) en ligne ce jour pour la formule : <br>
                        => <b>" . $subscription_name . "</b> <br>
                        => au prix de <b>" . $subscription_price . " €. </b> <br>
                        => Le paiement a été effectué par <b>" . $_POST['paymod'] . "</b> <br><br>

                        Ce mail est généré automatiquement, veuillez SVPL ne pas y répondre. <br>
                        Nous vous remercions de votre compréhension.<br><br>

                        <hr style='width:30%;text-align:left;margin-left:0'>
                        <b>Le Club Vosgien Mulhouse & Crêtes</b> <br>
                        <b>Thierry SCHLAWICK Président</b> <br>
                        Pensez ENVIRONNEMENT, n'imprimer que si nécessaire !
                        </p>
                        <hr style='width:30%;text-align:left;margin-left:0'>
                    </body>

                    </html>
                    ";
            $mail->send();
             } catch (Exception $e) {
                    echo '<h4 class="alert alert-danger" role="alert">Le mail n\'a pas été envoyé.</h4> Mailer Error: {$mail->ErrorInfo}</h4>';
                }
            }
            exit;

        } else {
            $statement = $bdd->prepare("INSERT INTO members (SubscriptionID, FunctionID, civ_name, SpouseID, member_firstname, member_lastname, member_profession, member_dob, member_address, member_zip, member_city, member_country, member_phone, member_mobile, member_email, paymod) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($SubscriptionID, $FunctionID, $civ_name, $SpouseID, $member_firstname, $member_lastname, $member_profession, $member_dob, $member_address, $member_zip, $member_city, $member_country, $member_phone, $member_mobile, $member_email, $paymod));
            echo '<script type="text/javascript">document.location.replace("adherer-au-cvmc.php");</script>';
            $_SESSION['paychq'] = "Nous vous remercions de votre " . $item['subscription_name'] . " au prix de " . $item['subscription_price'] . " € . Vous avez choisi de la payer par chèque, veuillez l'établir à l’ordre du Club Vosgien de Mulhouse & Crêtes et l'envoyer à l’adresse du siège de l’association : 33 Grand'rue 68100 MULHOUSE.";
            if (isset($_POST['envoyer'])) {
            try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
            $mail->Host         = 'node28-eu.n0c.com';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'contact@web-services.tech';
            $mail->Password     = 'asc123!321CSA';
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port         = 465;
            $mail->CharSet      = 'UTF-8';
            $mail->setFrom('noreply@club-vosgien-mulhouse.com', 'Nouvelle adhésion');
            $mail->addAddress('annemarie.schlawick@gmail.com', 'Anne-Marie SCHLAWICK');
            $mail->addBCC('ali@bouaouina.fr', 'Ali BOUAOUINA');
            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Adhésion de ' . ucfirst($_POST['civ_name']) . ' ' . ucfirst($_POST['member_firstname']) . ' ' . strtoupper($_POST['member_lastname']) . ' ');
            $mail->Body
                = "
                <!DOCTYPE html>
                <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                </head>
                <body style='font-family: Calibri, Arial, sans-serif'>
                    <p>
                        Bonjour Anne-Marie,  <br><br>
                        
                        Madame/Monsieur " . ucfirst($_POST['member_firstname']) . " " . strtoupper($_POST['member_lastname']) . " s'est inscrit(e) en ligne ce jour pour la formule : <br>
                        => <b>" . $subscription_name . "</b> <br>
                        => au prix de <b>" . $subscription_price . " €. </b> <br>
                        => Le paiement a été effectué par <b>" . $_POST['paymod'] . "</b> <br><br>

                        Ce mail est généré automatiquement, veuillez SVPL ne pas y répondre.<br>
                        Nous vous remercions de votre compréhension.<br><br>

                        <hr style='width:30%;text-align:left;margin-left:0'>
                        <b>Le Club Vosgien Mulhouse & Crêtes</b> <br>
                        <b>Thierry SCHLAWICK Président</b> <br>
                        Pensez ENVIRONNEMENT, n'imprimer que si nécessaire !
                        </p>
                        <hr style='width:30%;text-align:left;margin-left:0'>
                    </body>

                    </html>
                    ";
            $mail->send();
             } catch (Exception $e) {
                    echo '<h4 class="alert alert-danger" role="alert">Le mail n\'a pas été envoyé.</h4> Mailer Error: {$mail->ErrorInfo}</h4>';
                }
            }
            exit;
            }
        }
    }
?>

    <div class="row justify-content-center">

        <div class="col-lg-12 bg-secondary text-white mb-4">

            <form name="beatport" class="pt-4 pb-4 form-inline" action="" role="form" id="form" method="post" enctype="multipart/form-data">

                <input style="width:230px" type="hidden" class="form-control" id="SubscriptionID" name="SubscriptionID" value=" <?php echo $_POST['SubscriptionID'] ?>  ">
                <input style="width:230px" type="hidden" class="form-control" id="FunctionID" name="FunctionID" value=" 4 ">
                <input style="width:230px" type="hidden" class="form-control" id="SpouseID" name="SpouseID" value="1">

                <div class="mb-4 form-group">
                    <label style="width:150px" class="d-inline pl-4" for="civ_name">Civilités</label>
                    <select style="width:150px" class="form-control" name="civ_name">
                        <?php
                        // if (!empty($item['civ_name'])) {
                        $civ_name = ($item['civ_name']);
                        foreach ($bdd->query('SELECT * FROM civ') as $row) {
                            if ($row['civ_name'] == $civ_name)
                                echo '<option selected="selected" value="' . $row['civ_name'] . '">' . $row['civ_name'] . ' </option>';
                            else
                                echo '<option value="' . $row['civ_name'] . '">' . $row['civ_name'] . '</option>';
                        }
                        // }
                        ?>
                    </select>
                </div>

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="member_firstname">Prénom</label>
                    <input style="width:200px" type="text" class="form-control" id="member_firstname" name="member_firstname" require
                    value="<?php if (isset($_POST['member_firstname'])) {
                        echo htmlentities($_POST['member_firstname']);
                        } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:200px" class="d-inline pl-4" for="member_lastname">Nom</label>
                    <input style="width:200px" type="text" class="form-control" id="member_lastname" name="member_lastname" require
                    value="<?php if (isset($_POST['member_lastname'])) {
                        echo $_POST['member_lastname'];
                        } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_profession">Profession<br></label>
                    <input style="width:300px" type="text" class="form-control" id="member_profession" name="member_profession" require
                    value="<?php if (isset($_POST['member_profession'])) {
                        echo htmlentities($_POST['member_profession']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_dob">Date de naissance <br> (format jj/mm/aaaa)</label>
                    <input style="width:300px" type="text" class="form-control" id="member_dob" name="member_dob" require
                    value="<?php if (isset($_POST['member_dob'])) {
                        echo htmlentities($_POST['member_dob']); } ?>">
                <!-- Ajout du code JavaScript pour ajouter les "/" automatiquement -->
                <script>
                    document.getElementById('member_dob').addEventListener('input', function (e) {
                        var input = e.target;
                        var inputValue = input.value;
                        if (inputValue.length === 2 || inputValue.length === 5) {
                            inputValue += '/';
                        }
                        input.value = inputValue;
                    });
                    </script>
                <?php 
                if (isset($_POST['member_dob']) && $member_dob = $_POST['member_dob']) {
                    $date = date_create_from_format('d/m/Y', $member_dob);
                    if (!$date || $date->format('d/m/Y') !== $member_dob) {
                        echo "<p class='alert-danger text-center'>Format de date invalide, veuillez saisir une date au format <strong> jj mm aaaa ! </p>";
                    }
                } ?>
                </div>


                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_address">Adresse</label>
                    <input style="width:850px" type="text" class="form-control" id="member_address" name="member_address" require
                    value="<?php if (isset($_POST['member_address'])) {
                        echo htmlentities($_POST['member_address']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_zip">Code postal</label>
                    <input style="width:300px" type="text" class="form-control" id="member_zip" name="member_zip" require 
                    value="<?php if (isset($_POST['member_zip'])) {
                        echo htmlentities($_POST['member_zip']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_city">Ville</label>
                    <input style="width:300px" type="text" class="form-control" id="member_city" name="member_city" require
                    value="<?php if (isset($_POST['member_city'])) {
                        echo htmlentities($_POST['member_city']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_country">Pays</label>
                    <input style="width:300px" type="text" class="form-control" id="member_country" name="member_country" require
                    value="<?php if (isset($_POST['member_country'])) {
                        echo htmlentities($_POST['member_country']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_phone">N° de téléphone fixe <br>10 chiffres sans espace</label>
                    <input style="width:300px" type="tel" class="form-control" id="member_phone" name="member_phone" 
                    value="<?php if (isset($_POST['member_phone'])) {
                        echo htmlentities($_POST['member_phone']); } ?>">
                </div>

                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_mobile">N° de téléphone mobile <br>10 chiffres sans epace</label>
                    <input style="width:300px" type="tel" class="form-control" id="member_mobile" name="member_mobile" 
                    value="<?php if (isset($_POST['member_mobile'])) {
                        echo htmlentities($_POST['member_mobile']); } ?>">
                </div>
                        
                <div class="mb-4 form-group">
                    <label style="width:250px" class="d-inline pl-4" for="member_email">Adresse email</label>
                    <input style="width:300px" type="text" class="form-control" id="member_email" name="member_email" require
                    value="<?php if (isset($_POST['member_email'])) {
                        echo htmlentities($_POST['member_email']); } ?>">
                </div>

                <p class="btn-block text-center alert-danger">Veuillez SVPL <b>sélectionner votre mode de paiement</b>, carte bancaire en ligne ou chèque <i>(N’envoyez surtout pas d’espèces !)</i> </p>

                <div class="mb-4 form-group">
                    <label style="width:450px" class="d-inline ml-4" for="paymod">Je paye le montant de mon abonnement de <?php echo $item['subscription_price'] ?> € par :</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="cb" name="paymod"> 
                        <?php if (isset($item['paymod']) && $item['paymod'] == "cb") {
                            echo "checked"; } ?>
                        <label class="form-check-label">Par carte bancaire en ligne</label>
                    </div>

                    <div class="form-check form-check-inline ml-5">
                        <input class="form-check-input" type="radio" value="chq" name="paymod"> 
                        <?php if (isset($item['paymod']) && $item['paymod'] == "chq") {
                            echo "checked"; } ?>
                        <label class="form-check-label">Par chèque que j'enverrai à la permanence du club</label>
                    </div>
                </div>

                <p class="text-center">Les données collectées sont enregistrées dans un fichier informatisé par notre DPO (Délégué à la Protection des Données). Elles sont strictement destinées à l’usage interne de l’Association. Pour en savoir plus sur la gestion de vos données personnelles et pour exercer vos droits, reportez-vous à nos <a href="https://club-vosgien-mulhouse.fr/mentions-legales/" target="_blank"><span class="text-white font-weight-bold">mentions légales</span></a>.</p>

                
                <?php
                if ($_POST['SubscriptionID'] == 2 || $_POST['SubscriptionID'] == 4 || $_POST['SubscriptionID'] == 6) {
                    echo '<p class="btn btn-block btn-danger">Vous avez souscrit un abonnement <b> couple</b>, veuillez SVPL saisir les informations de votre conjoint(e) sur la page suivante, après avoir cliqué sur <b> Envoyer</b></p>';
                }
                ?>
                </p>
                
                <input class="btn btn-block btn-success text-uppercase" name="envoyer" type="submit" value="Envoyer" onclick="submitBeatport()">
                
            </form>

        </div>
    </div>
</div>

<?php require_once('_footer.php'); ?>