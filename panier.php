<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
  <style>
    
  </style>
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
    <h2>Votre panier</h2>
    <div id="contenu-panier" class="panier-produits"></div>
    <p id="total"></p>
    <form id="form-commande" method="POST" action="commander.php">
      <input type="hidden" name="panierJSON" id="panierJSON">
      <button type="submit">Commander</button>
    </form>
  </main>

  <script>
    // 1. Récupérer le nom d'utilisateur PHP (si connecté)
    const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
    const clePanier = "panier_" + username;

    function sauvegarderPanierServeur(panier) {
      fetch("sauver_panier.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(panier)
      });
    }

    function afficherPanier() {
      let panier = JSON.parse(localStorage.getItem(clePanier)) || [];
      const zone = document.getElementById("contenu-panier");
      const totalElem = document.getElementById("total");

      if (panier.length === 0) {
        zone.innerHTML = "<p>Votre panier est vide.</p>";
        totalElem.textContent = "";
        return;
      }

      let total = 0;
      zone.innerHTML = "";

      panier.forEach((produit, index) => {
        const prixUnitaire = parseFloat(produit.prix.replace(",", "."));
        const quantite = produit.quantite || 1;
        const sousTotal = prixUnitaire * quantite;
        total += sousTotal;

        zone.innerHTML += `
          <div class="produit">
            <img src="assets/${produit.image}" alt="${produit.nom}" style="width:100px" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
            <h3>${produit.nom}</h3>
            <p>Prix unitaire : ${produit.prix}</p>
            <label>Quantité : 
              <input type="number" min="1" value="${quantite}" onchange="changerQuantite(${index}, this.value)">
            </label>
            <p>Sous-total : ${(sousTotal).toFixed(2).replace(".", ",")} €</p>
            <button type="button" onclick="supprimer(${index})">Supprimer</button>
          </div>
        `;
      });

      totalElem.textContent = "Total : " + total.toFixed(2).replace(".", ",") + " €";
    }

    function supprimer(index) {
      let panier = JSON.parse(localStorage.getItem(clePanier)) || [];
      panier.splice(index, 1);
      localStorage.setItem(clePanier, JSON.stringify(panier));
      sauvegarderPanierServeur(panier);
      afficherPanier();
    }

    function changerQuantite(index, nouvelleQuantite) {
      let panier = JSON.parse(localStorage.getItem(clePanier)) || [];
      panier[index].quantite = parseInt(nouvelleQuantite);
      localStorage.setItem(clePanier, JSON.stringify(panier));
      sauvegarderPanierServeur(panier);
      afficherPanier();
    }

    document.getElementById("form-commande").addEventListener("submit", function(e) {
      const panier = localStorage.getItem(clePanier);
      document.getElementById("panierJSON").value = panier;
    });

    afficherPanier();
  </script>
</body>
</html>
