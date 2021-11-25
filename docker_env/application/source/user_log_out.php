<?php
session_start();
// Pour empêcher d'aller sur la page logout si déjà déconnecté : 
if (!isset($_SESSION["utilisateur"])){
    header("Location: user_log_in.php");
    exit;
}

// Supprimer une variable
unset($_SESSION["utilisateur"]);

// Retour à la page d'accueil
header("Location: index.php"); 