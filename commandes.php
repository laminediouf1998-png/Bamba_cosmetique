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
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$chemin = "../data/commandes.txt";
$commandes = file_exists($chemin) ? file($chemin, FILE_IGNORE_NEW_LINES) : [];

// Changer le statut si on a ?valider=ligneX
if (isset($_GET['valider'])) {
  $index = (int) $_GET['valider'];
  if (isset($commandes[$index])) {
    $infos = explode(";", $commandes[$index]);
    if (count($infos) === 4) {
      $infos[3] = "Envoyée";
      $commandes[$index] = implode(";", $infos);
      file_put_contents($chemin, implode("\n", $commandes));
    }
  }
  header("Location: commandes.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<a href="dashboard.php" class="btn-retour">←</a>
  <meta charset="UTF-8">
  <title>Commandes - Bamba Cosmétiques</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <script src="../public/js/ui.js" defer></script>
  <style>
    main { max-width: 800px; margin: auto; padding: 2rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
    th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
    th { background-color: #eee; }
    .valider { background: green; color: white; padding: 0.3rem 0.6rem; border-radius: 4px; text-decoration: none; }
  </style>
</head>
<body>
  <main>
    <h1>Liste des commandes</h1>
    <?php if (empty($commandes)) : ?>
      <p>Aucune commande enregistrée.</p>
    <?php else : ?>
      <table>
        <tr>
          <th>Client</th>
          <th>Produits</th>
          <th>Total</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
        <?php foreach ($commandes as $index => $ligne) :
          list($client, $produits, $total, $statut) = array_pad(explode(";", $ligne, 4), 4, ''); ?>
          <tr>
            <td><?php echo htmlspecialchars($client); ?></td>
            <td><?php echo htmlspecialchars($produits); ?></td>
            <td><?php echo htmlspecialchars($total); ?> €</td>
            <td><?php echo htmlspecialchars($statut); ?></td>
            <td>
              <?php if ($statut === "En cours") : ?>
                <a href="?valider=<?php echo $index; ?>" class="valider">Marquer comme envoyée</a>
              <?php else : ?>
                <em>Fait</em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>
