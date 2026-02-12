<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bamba Cosmétiques - Accueil</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body>
  <header>
  <div > <h1>Bamba Cosmétiques</h1></div>

    <nav>
      <ul>

        <li><a href="index.php">Accueil</a></li>
        <li><a href="catalogue.php">Catalogue</a></li>
        <li><a href="panier.php">Panier</a></li>
        <?php if (isset($_SESSION['username'])) : ?>
          <li><a href="compte.php">Mon compte</a></li>
          <li><a href="logout.php">Déconnexion</a></li>
        <?php else : ?>
          <li><a href="login.php">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Quelques produits</h2>
    <div class="produits">
      <div class="produit">
        <img src="assets/produit1.jpg" alt="Produit 1" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Crème visage</h3>
        <p>25,00 €</p>
        <button onclick="ajouterAuPanier(1)">Ajouter au panier</button>
      </div>
      <div class="produit">
        <img src="assets/produit2.jpg" alt="Produit 2" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Huile essentielle</h3>
        <p>15,00 €</p>
        <button onclick="ajouterAuPanier(2)">Ajouter au panier</button>
      </div>
      <div class="produit">
        <img src="assets/produit3.jpg" alt="Produit 3" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
        <h3>Savon naturel</h3>
        <p>8,00 €</p>
        <button onclick="ajouterAuPanier(3)">Ajouter au panier</button>
      </div>
    </div>
  </main>

  <script>
    // Récupération du nom d'utilisateur côté PHP
    const username = "<?= isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
    const clePanier = "panier_" + username;

    // Produits disponibles
    const produits = {
      1: { nom: "Crème visage", prix: "25,00", image: "produit1.jpg" },
      2: { nom: "Huile essentielle", prix: "15,00", image: "produit2.jpg" },
      3: { nom: "Savon naturel", prix: "8,00", image: "produit3.jpg" }
    };

    function sauvegarderPanierServeur(panier) {
      fetch("sauver_panier.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(panier)
      });
    }

    function ajouterAuPanier(id) {
      if (!username) {
        alert("Vous devez être connecté pour ajouter un produit au panier.");
        return;
      }

      const produit = produits[id];
      if (!produit) return;

      let panier = JSON.parse(localStorage.getItem(clePanier)) || [];
      panier.push({ id, ...produit });
      localStorage.setItem(clePanier, JSON.stringify(panier));
      sauvegarderPanierServeur(panier);
      alert("Produit ajouté au panier !");
    }
  </script>
</body>
</html>
