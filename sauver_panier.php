<?php
session_start();

if (!isset($_SESSION['username'])) {
  http_response_code(403);
  echo "Non autorisé";
  exit;
}

$donnees = file_get_contents("php://input");
if ($donnees) {
  $fichier = "../data/paniers/" . $_SESSION['username'] . ".json";
  file_put_contents($fichier, $donnees);
  echo "Panier sauvegardé";
} else {
  http_response_code(400);
  echo "Aucune donnée reçue";
}
