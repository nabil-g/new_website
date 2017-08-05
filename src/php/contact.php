<?php

          include 'db.php';

        //RECUPERATION DES DONNEES DU FORMULAIRE DE CONTACT
        // Pour info :
        // La fonction strip_tags permet d'effacer les balises HTML qui pourraient être injectés par l'utilisateur.
        // Le suffixe us qui termine les variables résultant d'un formulaire me permet de les distinguer des autres variables (user string).

        // On teste la présence de ces variables envoyées via le formulaire
        if (isset($_POST['name']) and isset($_POST['mailaddress']) and isset($_POST['message']) and !empty($_POST['name']) and !empty($_POST['mailaddress']) and !empty($_POST['message'])) {

          //On supprime les potentielles balises HTML et on enregistre les variables du formulaire dans d'autres variables, plus lisibles.
          $name_us = strip_tags($_POST['name']);
          $address_us = strip_tags($_POST['mailaddress']);
          $msg_us = strip_tags($_POST['message']);
          //On enregistre dans une variable la valeur de l'array superglobale $_SERVER correspondant au caractéristiques du navigateur de l'utilisateur.
          $nav = $_SERVER['HTTP_USER_AGENT'];
          $adresseip = $_SERVER['REMOTE_ADDR'];

          // VERIFICATION DU QUOTA D'ENVOI DE MESSAGES
          // préparation d'une requete de lecture
          $r = $bdd->prepare('SELECT COUNT(*) AS nbremsg FROM messages WHERE adresseip = ? AND date_m = CURDATE() ');
          // je compte le nombre de messages répondant au critère

          // $date = date('Y-m-d'); // j'enregistre la date actuelle dans une variable

          $r->execute(array($adresseip)); // j'exécute la requete préparée

          $donnees = $r->fetch(); // je parcoure la requete exécutée et enregistre le tableau qui en découle dans une variable
          $r->closeCursor(); // je libère le serveur en mettant fin à la requête

          if ($donnees['nbremsg'] >= 3) { // si le nombre de messages est supérieur ou égal à 3
            echo 'Vous ne pouvez pas envoyer plus de 3 messages dans la même journée, désolé !'; // alors ...
          } else { // sinon
            //ENREGISTREMENT DES DONNEES DANS LA BASE DE DONNEES

            //On prépare la requete d'insertion avant de lui insérer les variables de l'utilisateur (afin d'eviter des injections SQL).
            $req = $bdd->prepare('INSERT INTO messages(nom, adressemail, message, date_m, heure_m, adresseip, navigateur)
              VALUES(:nom, :adressemail, :message, CURDATE(), CURTIME(), :adresseip, :navigateur)');

            //On exécute la requete avec les variables "nettoyées" des éventuelles injections SQL.
            $req->execute(array(
              'nom' => $name_us,
              'adressemail' => $address_us,
              'message' => $msg_us,
              'adresseip' => $adresseip,
              'navigateur' => $nav,
              ));

            // On affiche un message.
            echo "Merci pour votre message $name_us !";
          }
        } else {
            // S'il n'y a pas de variables de formulaire, on affiche un message d'erreur.
          echo "Vous n'avez pas renseigné votre nom, votre adresse e-mail ou votre message !";
        }

?>
