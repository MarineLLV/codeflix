<?php
    // Vérifier si un fichier a été envoyé
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0 ) {
        // On a reçu l'image
        // On procède aux vérifications (extension de l'image, type de l'image, dimensions, poids, ...)
        // On vérifie toujours l'extension ET le type Mime
        $allowed = [
            "jpg" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "png" => "image/png"
        ]; // lister les différentes extensions avec leur type Mime que l'on souhaite autoriser

        // On récupère le nom du fichier
        $filename = $_FILES["image"]["name"];
        // On récupère le type MIME
        $filetype = $_FILES["image"]["type"];
        // On récupère la taille
        $filesize = $_FILES["image"]["size"];

        // Avec toutes ces informations, on peut effectuer les premières vérifications
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // + conversion en minuscules
        // On vérifie l'absence de l'extension dans les clés de $allowed ou l'absence de type MIME dans les valeurs
        if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) { // Est-ce que la clé $extension existe à l'intérieur de $allowed? OU chercher l'aiguille ($filetype) dans la botte de foin ($allowed)
            // Ici soit l'extension, soit le type est incorrect (ou les deux)
            die("Erreur : format de fichier incorrect");
        }

        // Ici le type est correct
        // On limite à 1Mo par exemple
        if ($filesize > 1024 * 1024) {
            die("Fichier trop volumineux");
        }

        // On génère un nom unique pour le fichier
        $newname = md5(uniqid());
        // On génère le chemin d'accès complet au fichier
        $newfilename = __DIR__ . "/uploads/$newname.$extension";
        
        // On va déplacer le fichier depuis sa destination tmp vers le dossier uploads
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfilename)) {
            die("L'upload a échoué");
        }

        // Bonne pratique complémentaire : une fois le fichier transféré, on le protège pour éviter toute exécution en utilisant le chmod
        chmod($newfilename, 0644); // Si le fichier contient un script, il sera lu mais pas exécuté

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ajout de fichiers</h1>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="fichier">Fichier</label>
            <input type="file" name="image" id="fichier">
        </div>
        <button type="submit">Envoyer</button>

    </form>
</body>
</html>