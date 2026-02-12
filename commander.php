<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$panier = isset($_POST['panierJSON']) ? json_decode($_POST['panierJSON'], true) : [];

if (!empty($panier)) {
  $produitsTexte = [];
  $total = 0;

  foreach ($panier as $produit) {
    $nom = $produit['nom'] ?? 'Inconnu';
    $quantite = $produit['quantite'] ?? 1;
    $prix = isset($produit['prix']) ? floatval(str_replace(",", ".", $produit['prix'])) : 0;

    $produitsTexte[] = "$nom x $quantite";
    $total += $prix * $quantite;
  }

  $commande = $_SESSION['username'] . ";" .
              implode(", ", $produitsTexte) . ";" .
              number_format($total, 2, '.', '') . ";En cours\n";

  file_put_contents("../data/commandes.txt", $commande, FILE_APPEND);
  $confirmation = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation commande</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body>
  <main>
    <h1>Commande</h1>
    <?php if (isset($confirmation)) : ?>
      <p style="color:green;">Merci pour votre commande, <?php echo htmlspecialchars($_SESSION['username']); ?> !</p>
      <p><a href="index.php">Retour à l'accueil</a></p>
    <?php else : ?>
      <p style="color:red;">Erreur : aucune commande n'a été transmise.</p>
      <p><a href="panier.php">Retour au panier</a></p>
    <?php endif; ?>
  </main>
</body>
</html>
