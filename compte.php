<style>
  .btn-retour {
    position: fixed;
    top: 10px;
    left: 10px;
    width: 30px;
    height: 30px;
    background-color: white;
    border: 2px solid #ccc;
    border-radius: 50%;
    font-size: 20px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 999;
    transition: background-color 0.3s;
    text-decoration: none; 

  }

  .btn-retour:hover {
    background-color: #f0f0f0;
  }
</style>
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];
$commandes = [];

if (file_exists("../data/commandes.txt")) {
  foreach (file("../data/commandes.txt", FILE_IGNORE_NEW_LINES) as $ligne) {
    list($client, $produits, $total, $statut) = array_pad(explode(";", $ligne, 4), 4, '');
    if ($client === $username) {
      $commandes[] = ["produits" => $produits, "total" => $total, "statut" => $statut];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon compte - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body>
  <header>
  <a href="index.php" class="btn-retour">←</a>
  <h1>Bamba Cosmétiques</h1>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="catalogue.php">Catalogue</a></li>
        <li><a href="panier.php">Panier</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Bienvenue, <?= htmlspecialchars($username) ?> !</h2>

    <h3>Mes commandes</h3>
    <?php if (empty($commandes)) : ?>
      <p>Vous n'avez encore passé aucune commande.</p>
    <?php else : ?>
      <ul>
        <?php foreach ($commandes as $c) : ?>
          <li>
            <strong>Produits :</strong> <?= htmlspecialchars($c['produits']) ?> <br>
            <strong>Total :</strong> <?= htmlspecialchars($c['total']) ?> €<br>
            <strong>Statut :</strong> <?= htmlspecialchars($c['statut']) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <a href="changer_motdepasse.php" class="button">Changer mon mot de passe</a>
  </main>
</body>
</html>
