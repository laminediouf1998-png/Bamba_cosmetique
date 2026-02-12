<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un compte - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body>
  <header>
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
    <h2>Créer un compte</h2>
    <form action="register.php" method="POST">
      <label>Nom d'utilisateur : <input type="text" name="username" required></label><br>
      <label>Numéro de téléphone : <input type="number"></label><br>
      <select name="indicatif" required>
        <option value="+33">+33 (France)</option>
        <option value="+221">+221 (Sénégal)</option>
        <option value="+212">+212 (Maroc)</option>
      </select>
      <input type="tel" name="telephone" required>

      <label>Mot de passe : <input type="password" name="password" required></label><br>
      <label>Confirmation de mot de passe : <input type="password" name="password2" required></label><br>
      <button type="submit">S'inscrire</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = trim($_POST['username']);
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $indicatif = $_POST['indicatif'];   
      $numero = $_POST['telephone'];     
      $telephoneComplet = $indicatif . $numero; 

      if ($password !== $password2) {
        echo "<p style='color:red;'>Veuillez saisir le même mot de passe !</p>";
        exit;
      }

      $usersFile = "../data/users.txt";
      $utilisateurs = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES) : [];

      // Vérification si l'utilisateur existe déjà
      foreach ($utilisateurs as $ligne) {
        list($nom, ) = explode(";", $ligne);
        if ($username === $nom) {
          echo "<p style='color:red;'>Ce nom d'utilisateur est déjà pris.</p>";
          exit;
        }
      }

      // Ajouter le nouveau compte
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $ligne = $username . ";" . $hashedPassword . "\n";
      file_put_contents($usersFile, $ligne, FILE_APPEND);

      header("Location: login.php");
      exit;
    }
    ?>
  </main>
</body>
</html>
