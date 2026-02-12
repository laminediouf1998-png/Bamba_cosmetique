<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

// Nombre de produits
$produits = file("../data/produits.txt", FILE_IGNORE_NEW_LINES);
$nbProduits = count($produits);

// Nombre de commandes (fichier texte, une ligne = une commande)
$commandes = file("../data/commandes.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$nbCommandes = is_array($commandes) ? count($commandes) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <script src="../public/js/ui.js" defer></script>
  <style>
    main {
      max-width: 600px;
      margin: auto;
      padding: 2rem;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    p {
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <main>
    <h2>Tableau de bord admin</h2>
    <p>Nombre de produits : <strong><?php echo $nbProduits; ?></strong></p>
    <p>Nombre de commandes : <strong><?php echo $nbCommandes; ?></strong></p>
    
      <div class="button">
        <a href="produit.php">Modification</a>
        <a href="commandes.php">Commandes</a>
        <a href="../public/logout.php">Déconnexion</a>
      </div>


    <style>
      .button {
        display: flex;                   /* aligne les enfants en ligne */
        justify-content: space-between; /* espace égal entre les boutons */
        gap: 20px;                       /* optionnel, espace fixe entre eux */
        background-color: #aa4b5b;
        padding: 20px;
        width:auto
      }

      .button a {
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
      }


    
    </style>

  </main>
</body>
</html>
