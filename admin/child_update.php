<?php session_start();
$_SESSION['ChildID'] = $_POST['ChildID'];
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
if (!empty($_SESSION['ChildID'])) {
    $ChildID = ($_SESSION['ChildID']);
    $statement = $bdd->prepare("SELECT * FROM children WHERE ChildID = ?");
    $statement->execute(array($ChildID));
    $item = $statement->fetch();
    $ChildID            = $item['ChildID'];
    $child_firstname    = $item['child_firstname'];
    $child_lastname     = $item['child_lastname'];
    $child_dob          = $item['child_dob'];
}
?>

<?php
if (isset($_POST['modifier'])) {
    $ChildID            = $_POST['ChildID'];
    $child_firstname    = $_POST['child_firstname'];
    $child_lastname     = $_POST['child_lastname'];
    $child_dob          = $_POST['child_dob'];

    $statement = $bdd->prepare("UPDATE children SET child_firstname = ?, child_lastname = ?, child_dob = ? WHERE ChildID = ?");
    $statement->execute(array($child_firstname, $child_lastname, $child_dob, $ChildID));

    echo '<script type="text/javascript">document.location.replace("children_list.php");</script>';
    exit();
}
?>

<div class="container">

    <div class="row justify-content-center mt-4">

        <div class="col-lg-12 bg-secondary text-white text-center mb-4">
            <h2>Modifier le profil de l'enfant <?php echo ucfirst($item['child_firstname']) . " " . strtoupper($item['child_lastname']); ?></h2>
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
    if (!empty($_SESSION['ChildID'])) {
        $ChildID = $_SESSION['ChildID'];
        $statement = $bdd->prepare("SELECT* FROM children WHERE ChildID = ?");
        $statement->execute(array($ChildID));
    }
    while ($item = $statement->fetch()) {
    ?>
        <div class="row justify-content-center">

            <div class="col-lg-12 bg-secondary text-white mb-4">

                <form class="mb-4 mt-4 form-inline" action="" role="form" method="post" enctype="multipart/form-data">

                    <input style="width:300px" type="hidden" class="form-control" id="ChildID" name="ChildID" value="<?php echo $item['ChildID']; ?>">

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="civ_name">Civilités</label>
                        <select style="width:850px" class="form-control" name="civ_name">
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
                        <label style="width:250px" class="d-inline pl-4" for="child_firstname">Prénom de l'enfant</label>
                        <input style="width:300px" type="text" class="form-control" id="child_firstname" name="child_firstname" value="<?php echo $item['child_firstname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:250px" class="d-inline pl-4" for="child_lastname">Nom de l'enfant</label>
                        <input style="width:300px" type="text" class="form-control" id="child_lastname" name="child_lastname" value="<?php echo $item['child_lastname']; ?>">
                    </div>

                    <div class="mb-4 form-group">
                        <label style="width:350px" class="d-inline pl-4" for="child_dob">Date de naissance (format jj/mm/aaaa)</label>
                        <input style="width:750px" type="text" class="form-control" id="child_dob" name="child_dob" value="<?php echo $item['child_dob']; ?>">
                    </div>

                <?php }  ?>

                <div class="pl-4 mb-4 form-group">
                    <button style="width:1080px" type="submit" name="modifier" class="btn btn-lg btn-block btn-success text-uppercase">Modifier le profil de l'enfant</button>
                </div>

                </form>

            </div>
        </div>
</div>

<?php require_once('_footer.php'); ?>