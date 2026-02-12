<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Catalogue - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
 

  
</head>
<body>
  <header>
  <button class="btn-retour" onclick="history.back()">←</button>

    <h1>Bamba Cosmétiques</h1>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="catalogue.php">Catalogue</a></li>
        <li><a href="panier.php">Panier</a></li>
        <li><a href="login.php">Connexion</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Catalogue complet</h2>
    <div class="produits">
      <div class="produit">
        <img src="assets/produit1.jpg" alt="Produit 1" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Crème visage</h3>
        <p>25,00 €</p>
        <a href="produit.php?id=1"><button>Voir</button></a>
      </div>
      <div class="produit">
        <img src="assets/produit2.jpg" alt="Produit 2" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Huile essentielle</h3>
        <p>15,00 €</p>
        <a href="produit.php?id=2"><button>Voir</button></a>
      </div>
      <div class="produit">
        <?php
          $imagesCatalogue = ["produit1.jpg", "produit2.jpg", "produit3.jpg", "produit4.jpg", "produit5.jpg"];
          $imageAleatoire = $imagesCatalogue[array_rand($imagesCatalogue)];
        ?>
        <img src="assets/<?= $imageAleatoire ?>" alt="Produit 3" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Savon naturel</h3>
        <p>8,00 €</p>
        <a href="produit.php?id=3"><button>Voir</button></a>
      </div>
      <div class="produit">
        <img src="assets/produit4.jpg" alt="Produit 4" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Lotion corps</h3>
        <p>18,00 €</p>
        <a href="produit.php?id=4"><button>Voir</button></a>
      </div>
    </div>

  </main>

</body>
</html>
