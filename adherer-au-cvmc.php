<?php session_start(); ?>

<?php
require_once '_head.php';
require_once '_nav.php';
require_once '_header2.php';
require_once 'bdd.php';
require_once 'vendor/autoload.php';
$bdd = bdd();
?>

<?php
// echo '<pre>';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '/<pre>';
?>

<div class="container mt-4">

    <div class="row">

        <?php
        if (!empty($_SESSION['paychq'])) {
            echo '<div class="row justify-content-center bg-success text-white"> <h4 class="text-center">' . $_SESSION['paychq'] . ' </h4> </div>';
        }
        ?>

        
        <div class="col-auto">
            <h1 class="pl-3 " style="font-family: 'Oswald', sans-serif; line-height: 88px; font-weight: 200; font-size: 54px; color: #444; margin-bottom: 7px;">Adhérer au Club Vosgien de Mulhouse & Crêtes</h1>
        </div>

        <div class="col-auto mb-4">

            <p class="pl-3 text-justify">
                Adhérer à notre association, c’est l’assurance de participer à nos activités et mieux connaître notre région… Et la cotisation annuelle englobe toutes nos activités. <br><br>

                Mais devenir membre de notre Club, c’est aussi nous soutenir dans nos différentes missions. Parmi celles-ci, il y a la création, le développement et l’entretien des sentiers. Eh oui, notre <a href="https://club-vosgien-mulhouse.fr/le-club/balisage-des-sentiers/" target="_BLANK">secteur d’intervention</a> est très grand : partie du massif vosgien, du Sundgau et la zone urbaine de notre secteur. <br><br>

                Et puis nos guides, baliseurs ou encore ceux et celles qui gèrent notre association sont tous des bénévoles. Evidemment, le Club Vosgien de Mulhouse & Crêtes a toujours besoin de compétences diverses. Alors, si vous avez envie de donner un coup de main sur les sentiers, dans l’administration… Ou bien si vous savez organiser des séjours, communiquer (site internet, salons etc…) : n’hésitez pas à nous contacter pour nous faire part de vos idées ! <br><br>

                Enfin, la carte de membre ouvre droit à des <a href="https://club-vosgien-mulhouse.fr/adhesion/vos-avantages/" target="_BLANK">avantages</a> non négligeables, à condition d’être à jour de sa cotisation. Et n’oubliez pas que notre Club est une association reconnue d’utilité publique. <br><br>

                Si vous nous rejoignez, ou si vous renouvelez votre adhésion, nous aurons besoin d’un <a href="https://club-vosgien-mulhouse.fr/wp-content/uploads/2021/11/certificat-medical-type-nov-2021.pdf" target="_BLANK">certificat de non contre-indication à la pratique sportive</a>. Même si votre santé ne vous pose aucun problème, il n’en reste pas moins que nous sommes responsables de vous lors d’une randonnée. Il faut donc <b>remplir cette formalité</b>, même si elle semble pesante ... <br><br>
                <span class="under" style="font-weight:bold">Précisions importantes : </span> <br>
                <ul>
                    <li>Votre certificat médical reste <b>valable 3 ans</b> SAUF modification de votre état de santé, </li>
                    <li>C’est pourquoi, la <b>2e et 3e année</b>, nous vous invitons à vérifier cette stabilité à l'aide du <a href="pdf/qss2023.pdf">Questionnaire Santé Sport (QSS)</a>, puis à nous <b>renvoyer ce document</b> une fois renseigné.</li>
                </ul>
            </p>

            <div class="row justify-content-center">

                <div class="col-auto">
                    <?php
                    $annee = date('Y'); 
                    ?>
                    <h3>Cotisation <?php echo $annee ; ?> </h3>
                    <p>1°) <span class="alert-danger font-weight-bold font-italic">Déjà membre du CV Mulhouse & Crêtes en <?php echo $annee - 1 ; ?> ? Cliquez </a> <a href='https://www.payasso.fr/cvmc/cotisations' target="_BLANK">ici</a></span>.</h5>
                    <script>
                    function toggleText() {
                        var texte = document.getElementById("texte");
                        if (texte.style.display === "none") {
                            texte.style.display = "block";
                        } else {
                            texte.style.display = "none";
                        }
                    }
                    </script>
                    <p onclick="toggleText()">2°) <span class="alert-primary font-weight-bold font-italic">Première inscription ? Cliquez sur cette ligne.</span>.</p>
                    <div id="texte" style="display:none">
                        <table  class="table table-hover mt-3">
                            <thead class="thead-dark">
                                <th>Formules d'adhésion</th>
                                <th>Cliquez sur le montant de la formule choisie</th>
                                <!-- <th>Avec enfant(s)</th> -->
                            </thead>
                            <tbody>
                                <?php
                                    $statement = $bdd->prepare ("SELECT SubscriptionID, subscription_name, subscription_price, DATE_FORMAT(date_debut, '%m-%d') AS date_debut, DATE_FORMAT(date_fin, '%m-%d') AS date_fin  FROM subscriptions WHERE date_debut <= NOW() AND date_fin >= NOW()");
                                    $statement->execute();
                                    while ($item = $statement->fetch()) {
                                        echo '<tr>';
                                        echo '<td>' . $item['subscription_name'] . '</td>';
                                        echo '<td>';
                                        echo '<form method="post" name="subscription" action="subscription.php" role="form">';
                                        echo '<input id"SubscriptionID" type="hidden" name="SubscriptionID" value="' . $item['SubscriptionID'] . '"> ';
                                        echo '<input type="submit" class="btn btn-success" value="' . $item['subscription_price'] . ' € ">';
                                        echo '</form>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="mb-4"><i>Enfants mineurs dont un parent ou grand-parent est membre du Club Vosgien : <a href="https://club-vosgien-mulhouse.fr/accueil/contact/" target="_BLANK">Nous consulter</a></i></p>

                    <h3 class="pl-3">Paiement de la cotisation</h3>
                    <ul>
                        <li class="pl-3 pr-3 text-justify">En cas de <b>nouvelle adhésion</b>, après avoir rempli le formulaire d'adhésion, par carte bancaire en cliquant <a href='https://www.payasso.fr/cvmc/cotisations' target="_BLANK">ici</a></li>
                        <li class="pl-3 pr-3 text-justify">En cas de <b>renouvellement</b>, par carte bancaire en cliquant <a href='https://www.payasso.fr/cvmc/cotisations' target="_BLANK">ici</a></li>
                        <li class="pl-3 pr-3 text-justify"><b>En espèces ou en chèque</b> à l’occasion de l’une ou l’autre rencontre, ou encore au siège du Club les jours de permanence, ou lors de l’Assemblée Générale du Club en mars.</li>
                        <li class="pl-3 pr-3 text-justify"><b>Par courrier avec chèque </b> à l’ordre du Club Vosgien de Mulhouse & Crêtes à l’adresse du siège de l’association: 33 Grand Rue, 68100 MULHOUSE. <br>
                            N’oubliez pas de nous signaler dans les plus brefs délais tout changement d’adresse postale, de courriel, de numéro de téléphone, etc….</li>
                        <li class="pl-3 pr-3 text-justify"><b>Renouvellement de la cotisation :</b> à verser au plus tard au 31 mars de l’année en cours. Néanmoins, nous vous conseillons de <b>régler votre cotisation dès début janvier,</b> en particulier pour ceux qui souhaitent recevoir la revue <b>Les Vosges</b>, afin de ne pas interrompre son routage. Il en est de même pour l’assurance du Club Vosgien qui ne sera active qu’après paiement de la cotisation !</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<?php session_unset(); ?>

<?php require_once('_footer.php'); ?>