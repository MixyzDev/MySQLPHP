<?php
    session_start();
    // on verifie si il n'y a pas d'erreures au lancement de la session
    $error="";
    // si on veut remplir le champ username on verifie bien que post username est présent
    if(isset($_POST["username"])){
        // dans le cas ou on peut entrer un username alors on entre dans la condition des caractères que l'on va pouvoir utiliser avec un regex ou preg_match
        if(preg_match("/^[A-z]*$/",$_POST["username"]) && preg_match("/^(?![\d-])[a-zA-Z0-9-]{3,16}$/",$_POST["password"])){
            // dans le cas ou les caractères sont respecter alors on peut ouvrir une session qui ici stockera username
            $_SESSION["username"] = $_POST["username"];
            header("Location:index.php");
            // le exit ici nous sert a sortir de la fonction , le code arrete de s'executer ici.
            exit();
        }
        // si le if plus haut n'est pas bon alors il y aura une erreur qui s'affichera
        else{
            $error = "Username ou mot de passe incorrect";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post">
            <input type="text" name="username" placeholder="Your name"/>
            <input type="text" name="password" placeholder="Your password"/>
            <button>Se connecter</button>
        </form>
        <!-- ici on a un petit code php qui nous indique que si il n'y a rien de rempli dans le champ alors il affiche l'erreure -->
        <?= $error!=="" ? $error : null ?>
    </body>
</html>