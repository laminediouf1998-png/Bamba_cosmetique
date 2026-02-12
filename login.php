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
  }

  .btn-retour:hover {
    background-color: #f0f0f0;
  }


</style>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body class="login-page">
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
    <h2>Connexion</h2>
    <form action="login.php" method="POST">
      <label>Nom d'utilisateur : <input type="text" name="username" required></label>
      <label>Mot de passe : <input type="password" name="password" required></label>
      <button type="submit">Se connecter</button>
      <p style="text-align:center;">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $lignes = file("../data/users.txt", FILE_IGNORE_NEW_LINES);
      $trouve = false;

      foreach ($lignes as $ligne) {
        list($nom, $hash) = explode(";", $ligne);
        if ($username === $nom && password_verify($password, $hash)) {
          $_SESSION['username'] = $username;

          // Sauvegarde du panier si envoyé
          if (isset($_POST['panierJSON']) && $_POST['panierJSON'] !== "") {
            file_put_contents("../data/paniers/$username.json", $_POST['panierJSON']);
          }

          $trouve = true;
          break;
        }else if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin'] = true;
            header("Location: ../admin/login.php");
            exit;
          }
          
        
      }

      if (!$trouve) {
        echo "<p style='color:red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
      }
    }
    ?>
  </main>

  <?php if (isset($_SESSION['username'])) : ?>
  <script>
    const redirectToCompte = () => {
      window.location.href = "compte.php";
    };

    fetch("../data/paniers/<?= $_SESSION['username'] ?>.json")
      .then(res => res.ok ? res.json() : null)
      .then(data => {
        if (data) {
          localStorage.setItem("panier_<?= $_SESSION['username'] ?>", JSON.stringify(data));
        }
      })
      .catch(() => {})
      .finally(redirectToCompte);

    setTimeout(redirectToCompte, 800);
  </script>
  <?php endif; ?>

  <script>
    document.querySelector("form").addEventListener("submit", function(e) {
      const usernameField = document.querySelector("input[name='username']");
      const cleUtilisateur = usernameField ? "panier_" + usernameField.value : "panier";
      const panier = localStorage.getItem(cleUtilisateur) || localStorage.getItem("panier");
      if (panier) {
        const champ = document.createElement("input");
        champ.type = "hidden";
        champ.name = "panierJSON";
        champ.value = panier;
        this.appendChild(champ);
      }
    });
  </script>
</body>
</html>
