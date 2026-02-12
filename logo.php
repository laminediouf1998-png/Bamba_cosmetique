<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="css/auth.css">
        <title>Logo</title>
    </head>

    <body>
        <div class="container">
            <div style="display:flex; align-items:center; justify-content: end; gap: 8px; font-size: 24px;">
                <p style="text-align:right;">Français </p>
                <i class='bx  bx-school'  ></i> 
                
            </div>

            <nav>
                <p style="background:blue;justify-conter:right;margin:10px,padding:15px;font: size 15px;">Logo</p>
            
                <h1>Créer votre compte pour commencer</h1>
            </nav >

            <div class="input-box">
                <p style="margin:10px">Prenom:</p>
                <input type="text" nom="prenom" placeholder="Lamine">
            </div>
            <div class="input-box">
                <p style="margin:10px">Nom:</p>
                <input type="text" nom="nom" placeholder="Diouf">
            </div>

            <div class="input-box">
                <p style="margin:10px">E-mail: <input type="text" nom="mail" placeholder="lamine@gmail.com"></p>
                <p style="margin:10px">Numéro de téléphone: <input type="text" nom="Numero de téléphone" placeholder="07582658"></p>
            </div>


            <div class="input-box">
            <p style="margin:10px">Mot de passe: <input type="password" nom="mot de pase" placeholder="********" require></p> 
                <p style="margin:10px">Confirmation mot de passe: <input type="password" nom="confirm mot de pass"placeholder="********"></p>
            </div>

            <p>Langue:</p>
            <select name="langue" id="lang">
                <option value="français">Français</option>
                <option value="Arabe">Arabe</option>
                <option value="Spagnol">Spagnol</option>
            </select> 

            <div class="bout">
                <button style="background:blue;color:white;padding:5px;margin:10px;justify-contet:center"> Creer un compte</button>
            </div>

            <footer>
                <div>
                    <h2 style="text-align:center">En créant un compte, vous acceptez ? <a href="lien">les conditons et notre politique de confidentielle</a></h2>
                </div>
                <div>
                <h2 style="text-align:center">une reCAPCHA peut s'appliquer.</h2>
                </div>

                <div style="text-align:center">
                <a href="icon-link" style="margin: 10px;">S'inscrire avec Google</a>
                <a href="icon-link">S'inscrire avec Appele</a>
                </div>
                <h2 style="text-align:center"> Nous protègeons vos informations.</h2>
                <div style="display:flex;justify-content:center">
                    <h2 style="margin: 10px;">Besoin d'aide ?</h2>
                    <h2 style="color #101091ff;margin: 10px">Nous protègeons vos informations </h2>
                </div>
            </footer>
        </div>
    </body> 
</html> 