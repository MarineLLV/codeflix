<?php
if (!empty($_POST)) {
    // var_dump($_POST);
    // Le formulaire a été envoyé
    // On verifie que TOUS les champs requis sont remplis
    if (
        isset($_POST["email"], $_POST["mot_de_passe"])
        && !empty($_POST["email"]) && !empty($_POST["mot_de_passe"])
    ) {
        // Vérifier que c'est un email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("L'adresse email est incorrecte");
        }
        // Vérifier si l'email existe dans la base de données
        // Connexion à la base de données
        require_once "server_connection.php";
        // requête SQL
        $sql = "SELECT * FROM `utilisateurs` WHERE `email` = :email";
        // préparer la requête
        $query = $db->prepare($sql);
        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        //exécuter la requête
        $query->execute();

        $user = $query->fetch();
        

    }
}



// inclure header

// inclure navbar
?>


<h1>Connexion</h1>
<?php
// Pour afficher les erreurs 
if (isset($_SESSION["error"])) {
    foreach ($_SESSION["error"] as $message) {
        ?>
    <p><?= $message ?></p>
        <?php
    }
    // Une fois qu'une erreur a été affichée, il faut l'effacer
    unset($_SESSION["error"]);
}
?>

<form method="post">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </div>
    <div>
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe">
    </div>
    <button type="submit">Me connecter</button>

</form>

<?php
// inclure le footer
?>