<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ancien = $_POST['ancien'];
  $nouveau = $_POST['nouveau'];
  $confirm = $_POST['confirm'];

  if ($nouveau !== $confirm) {
    $message = "❌ Les mots de passe ne correspondent pas.";
  } else {
    $username = $_SESSION['username'];
    $lignes = file("../data/users.txt", FILE_IGNORE_NEW_LINES);
    $nouveauContenu = "";
    $trouve = false;

    foreach ($lignes as $ligne) {
      list($nom, $hash) = explode(";", trim($ligne));
      if ($nom === $username) {
        if (password_verify($ancien, $hash)) {
          $nouveauHash = password_hash($nouveau, PASSWORD_DEFAULT);
          $nouveauContenu .= "$nom;$nouveauHash\n";
          $trouve = true;
        } else {
          $message = "❌ Ancien mot de passe incorrect.";
          $nouveauContenu .= $ligne . "\n";
        }
      } else {
        $nouveauContenu .= $ligne . "\n";
      }
    }

    if ($trouve && $message === "") {
      file_put_contents("../data/users.txt", $nouveauContenu);
      $message = "✅ Mot de passe changé avec succès.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Changer mot de passe</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/ui.js" defer></script>
</head>
<body>
  <header>
    <h1>Bamba Cosmétiques</h1>
    <nav>
      <ul>
        <li><a href="compte.php">Mon compte</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Changer mon mot de passe</h2>
    <?php if ($message): ?>
      <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>Ancien mot de passe :
        <input type="password" name="ancien" required>
      </label>
      <label>Nouveau mot de passe :
        <input type="password" name="nouveau" required>
      </label>
      <label>Confirmer le nouveau mot de passe :
        <input type="password" name="confirm" required>
      </label>
      <button type="submit">Changer</button>
    </form>
    <?php if ($message === "✅ Mot de passe changé avec succès.") : ?>
  <a href="compte.php" class="button">⬅ Retour à mon compte</a>
<?php endif; ?>

  </main>
</body>
</html>
