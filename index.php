<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location:login.php");
    exit();
}

try {
    $db = new PDO("mysql:host=localhost;dbname=tdsql", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();

    if (isset($_POST["confirm"])) {
        $confirmRequest = "UPDATE customer SET nom='" . $_POST['nom'] . "', prenom='" . $_POST['prenom'] . "', codepostal='" . $_POST['codePostal'] . "' WHERE id_client=" . $_POST['confirm'];
        $db->query($confirmRequest);
    } else if (isset($_POST["delete"])) {
        $removeRequest = "DELETE FROM customer WHERE id_client=" . $_POST["delete"];
        $db->query($removeRequest);
    } else if (isset($_POST["disconnect"])) {
        // 
        session_destroy();
        // 
        header("Location:login.php");
    } else if (isset($_POST["add"])) {
        $addRequest = "INSERT INTO customer (Nom, prenom, CodePostal) VALUES ('".$_POST['nom']."','".$_POST['prenom']."','".$_POST['codePostal']."')";
        $db->query($addRequest);
    }
    
    $requeteSQL = "SELECT * FROM customer";
    $dataDb = $db->query($requeteSQL)->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();

} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<form method="post">
        <input type="text" name="nom">
        <input type="text" name="prenom">
        <input type="text" name="codePostal">
        <button name="add">Ajouter</button>
    </form>
    <form method="post">
        <button name="disconnect">Déconnexion</button>
        <table>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Code Postal</th>
                <th>Actions</th>
            </tr>
            <!--  -->
            <?php foreach ($dataDb as $index => $value) { ?>
                <tr>
                    <!--  -->
                    <?php if (isset($_POST["update"]) && $_POST["update"] == $value["id_client"]) { ?>
                        <!--  -->
                        <td><input name="id" value="<?php echo $value["id_client"] ?>" /></td>
                        <td><input name="nom" value="<?php echo $value["Nom"] ?>" /></td>
                        <td><input name="prenom" value="<?= $value["prenom"] ?>" /></td>
                        <td><input name="codePostal" value="<?= $value["CodePostal"] ?>" /></td>
                        <td>
                            <!--  -->
                            <button name="confirm" value="<?php echo $value["id_client"] ?>">Confirmer</button>
                            <!--  -->
                        <?php } else { ?>
                            <!--  -->
                        <td><?php echo $value["id_client"] ?></td>
                        <td><?= $value["Nom"] ?></td>
                        <td><?= $value["prenom"] ?></td>
                        <td><?= $value["CodePostal"] ?></td>
                        <td>
                            <!--  -->
                            <button name="update" value="<?php echo $value["id_client"] ?>">Modifier</button>
                            <!--  -->
                        <?php } ?>
                        <!--  -->
                        <button name="delete" value="<?php echo $value["id_client"] ?>">Supprimer</button>
                        </td>
                </tr>
                <!--  -->
            <?php } ?>
        </table>
    </form>
</body>

</html>