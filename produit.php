<style>
  .avis-form {
  display: none;
  margin-top: 1rem;
  background: #f1f1f1;
  padding: 1rem;
  border-radius: 8px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.stars {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
  gap: 5px;
}

.stars input {
  display: none;
}

.stars label {
  font-size: 24px;
  color: #ccc;
  cursor: pointer;
}

.stars input:checked ~ label,
.stars label:hover,
.stars label:hover ~ label {
  color: gold;
}

.avis-liste {
  list-style: none;
  padding: 0;
  max-width: 500px;
  margin: 1rem auto;
  text-align: left;
}

.avis-liste li {
  background: #fff;
  padding: 0.8rem;
  margin-bottom: 1rem;
  border: 1px solid #ddd;
  border-radius: 6px;
}

.avis-utilisateur {
  font-weight: bold;
  margin-bottom: 0.3rem;
}

.avis-etoiles {
  color: gold;
  font-size: 14px;
  margin-left: 5px;
}

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
  }

  .btn-retour:hover {
    background-color: #f0f0f0;
  }


</style>

<?php
session_start();

$id = $_GET['id'] ?? null;

$produits = [
  1 => ["nom" => "Crème visage", "prix" => "25,00", "desc" => "Hydrate et adoucit la peau", "image" => "produit1.jpg"],
  2 => ["nom"=> "Huile essentielle", "prix" => "15,00", "desc" => "Relaxante et naturelle", "image" => "produit2.jpg"],
  3 => ["nom" => "Savon naturel", "prix" => "8,00", "desc" => "Fait main, doux pour la peau", "image" => "produit3.jpg"],
  4 => ["nom" => "Lotion corps", "prix" => "18,00", "desc" => "Nourrit et parfume légèrement", "image" => "produit4.jpg"]
];

$produit = $produits[$id] ?? null;
$nomProduit = $produit['nom'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username']) && $nomProduit) {
  $note = (int) $_POST['note'];
  $commentaire = trim($_POST['commentaire']);
  $ligneAvis = "$nomProduit;" . $_SESSION['username'] . ";$note;$commentaire\n";
  file_put_contents("../data/avis.txt", $ligneAvis, FILE_APPEND);
}

$avis = [];
if (file_exists("../data/avis.txt") && $nomProduit) {
  foreach (file("../data/avis.txt", FILE_IGNORE_NEW_LINES) as $ligne) {
    list($pNom, $uNom, $note, $com) = array_pad(explode(";", $ligne, 4), 4, '');
    if ($pNom === $nomProduit) {
      $avis[] = ["utilisateur" => $uNom, "note" => $note, "commentaire" => $com];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Produit - Bamba Cosmétiques</title>
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
    <?php if ($produit): ?>
      <h2><?= htmlspecialchars($produit['nom']) ?></h2>
      <img src="assets/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" style="width:200px" onerror="this.onerror=null;this.src='assets/produit5.jpg';">
      <p><strong>Prix :</strong> <?= $produit['prix'] ?> €</p>
      <p><?= htmlspecialchars($produit['desc']) ?></p>
      <button onclick="ajouterAuPanier(<?= $id ?>)">Ajouter au panier</button>
    <?php else: ?>
      <p>Produit introuvable.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])) : ?>
        <button class="btn-toggle" onclick="document.querySelector('.avis-form').style.display='block'; this.style.display='none';">Laisser un avis</button>
        <form method="POST" class="avis-form">
          <div class="stars">
            <?php for ($i = 5; $i >= 1; $i--) : ?>
              <input type="radio" id="star<?= $i ?>" name="note" value="<?= $i ?>" required>
              <label for="star<?= $i ?>">★</label>
            <?php endfor; ?>
          </div>
          <label>Commentaire : <textarea name="commentaire" required></textarea></label><br>
          <button type="submit">Envoyer</button>
        </form>
      <?php else : ?>
        <p><a href="login.php">Connectez-vous</a> pour laisser un avis.</p>
      <?php endif; ?>

      <h3>Avis des clients</h3>
      <?php if (empty($avis)) : ?>
        <p>Aucun avis pour ce produit.</p>
      <?php else : ?>
        <ul class="avis-liste">
          <?php foreach ($avis as $a) : ?>
            <li>
              <div class="avis-utilisateur">
                <?= htmlspecialchars($a['utilisateur']) ?>
                <span class="avis-etoiles">(<?= str_repeat('★', $a['note']) ?>)</span>
              </div>
              <div class="avis-commentaire">
                <?= htmlspecialchars($a['commentaire']) ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
  </main>

  <script>
  const username = "<?= isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
  const clePanier = "panier_" + username;

  function sauvegarderPanierServeur(panier) {
    fetch("sauver_panier.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(panier)
    });
  }

  function ajouterAuPanier(id) {
    const produits = {
      1: { nom: "Crème visage", prix: "25,00", image: "produit1.jpg" },
      2: { nom: "Huile essentielle", prix: "15,00", image: "produit2.jpg" },
      3: { nom: "Savon naturel", prix: "8,00", image: "produit3.jpg" },
      4: { nom: "Lotion corps", prix: "18,00", image: "produit4.jpg" }
    };

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
