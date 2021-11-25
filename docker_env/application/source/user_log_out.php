<?php
session_start();
// SUpprimer une variable
unset($_SESSION["user"]);

// Retour à la page d'accueil
header("Location: index.php"); 