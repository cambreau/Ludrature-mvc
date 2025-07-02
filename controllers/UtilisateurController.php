<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\Client;
use App\Providers\Validation;
use App\Models\Utilisateur;
use App\Models\Villes;
use App\Providers\View;

class UtilisateurController{

  public function pageModifier (){
        //Recuperer les informations sur les villes.
        $villesCrud = new Villes; 
        $villes = $villesCrud -> select();
        //Recuperer les informations de l'utilisateur.
        $utilisateurCrud= new Utilisateur();
        $informationsUtilisateur= $utilisateurCrud->selectId($_SESSION['utilisateur_id']);
        //Récupérer les informations supplémentaires liées au rôle de l'utilisateur.
        if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
          $clientCrud = new Client;
          $informationsSupplementaires = $clientCrud -> selectId($_SESSION['utilisateur_id']);
        }
        else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
        {
          $adminCrud = new Admin;
          $informationsSupplementaires = $adminCrud -> selectId($_SESSION['utilisateur_id']);
        }
        
        // Fusionner les informations utilisateur et supplémentaires en gardant les noms de clés
        $utilisateur = array_merge($informationsUtilisateur, $informationsSupplementaires);
        
        //Renvoyer vers la view Clients/inscription
        return View::render('utilisateurs/utilisateur-modifier', ['villes'=>$villes, 'utilisateur'=>$utilisateur] );
  }

  public function modifier ($data){
    //Validation
    $validation = new Validation;
    // ** Validation de la partie utilisateur. 
    $validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50);
    $validation->field('nom',$data['nom'])->min(2)->max(50);
    $validation->field('prenom',$data['prenom'])->min(2)->max(50);
    $validation->field('email',$data['email'])->min(2)->max(50)->email();
    $validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
    $validation->field('confirmationMotPasse',$data['confirmation-mot-passe'])->confirmationChampIdentique($data['motDePasse']);
    // ** Validation des informations supplémentaires en fonction du rôle de l'utilisateur.
    if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
      $validation->field('adresse',$data['adresse'])->min(2)->max(100);
      $validation->field('codePostal',$data['codePostal'])->min(6)->max(7);
      $validation->field('ville',$data['ville'])->obligatoire();
    }
    else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
    {
      $validation->field('emploi',$data['emploi'])->min(2);
    }
    // Si la validation est un succès
    //    - Envoyer la modification à la base de données.
    if($validation->estUnSucces()){
      //** Envoi des informations utilisateur.
      $utilisateurCrud = new Utilisateur();
      $data['motDePasse'] = $utilisateurCrud ->hashMotDePasse($data['motDePasse']);
      $utilateurModifie = $utilisateurCrud -> update($data,$_SESSION['utilisateur_id']);
      // Si les modifications de la table Utilisateur ont fonctionné, alors on peut effectuer les modifications des tables Client et Admin.
      //** Envoi des informations supplementaires.
      if($utilateurModifie){
        if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
         $clientCrud = new Client;
         $clientModifie = $clientCrud -> update($data,$_SESSION['utilisateur_id']);
        }
        else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
        {
         $adminCrud = new Admin;
         $adminModifie = $adminCrud -> update($data,$_SESSION['utilisateur_id']);
        }
      }
      // Si les modifications de la table Utilisateur n'ont pas fonctionné, on redirige vers le page erreur 404.
      else{
        return View::render('erreur404', ['message'=>"404 - La modification a échoué"]);
      }
      // Si les modifications de la table Client OU de la table Amin ont fonctionné:
      //    - on recupere le nouveau profil.
      //    - on modifie les informations de la session.
      if((isset($clientModifie) && $clientModifie)  || (isset($adminModifie) && $adminModifie)){
          //** Recuperer les informations de l'utilisateur.
          $informationsUtilisateur= $utilisateurCrud->selectId($_SESSION['utilisateur_id']);
          //** Récupérer les informations supplémentaires liées au rôle de l'utilisateur.
          if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
            $informationsSupplementaires = $clientCrud -> selectId($_SESSION['utilisateur_id']);
          }
          else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
          {
            $informationsSupplementaires = $adminCrud -> selectId($_SESSION['utilisateur_id']);
          }
        // Fusionner les informations utilisateur et supplémentaires en gardant les noms de clés
        $utilisateur = array_merge($informationsUtilisateur, $informationsSupplementaires);
        // Regenere la session
        $session= $utilisateurCrud->creationSession($utilisateur);
        return View::render('utilisateurs/profil', ['utilisateur'=>$utilisateur]);
      }
       // Si les modifications de la table Client OU de la table Amin n'ont pas fonctionné:
      else{
        return View::render('erreur404', ['message'=>"404 - La modification a échoué"]);
      }
    }
    // Si la validation n'est pas correcte alors :
    //     - On recupere les erreurs.
    //     - On recupere les informations de la table Ville pour le formulaire.
    //
    else{
      //On recupere les erreurs.
      $erreurs=$validation->geterreurs();
      //Recuperer les informations sur les villes.
      $villesCrud = new Villes; 
      $villes = $villesCrud -> select();
      return View::render('utilisateurs/utilisateur-modifier', ['villes'=>$villes, 'utilisateur'=>$data,'erreurs'=>$erreurs]);
    }
  }

  public function supprimer(){
    //Validation que la requete soit arrive par GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      return View::render('erreur404', ['Erreur 404 - Page introuvable!']);
    }
    else{
      //On recupere l'id et on supprime la ligne dans la table Utilisateur.
      $id=$_GET["id"];
      $crudUtilisateur = new Utilisateur;
      $utilisateurSupprime = $crudUtilisateur ->delete($id);
      //Si la suppression a fonctionne on renvoie a la page de connexion avec un message de succes, sinon on redirige vers la page d'erreurs.
      if($utilisateurSupprime){
        session_destroy();
        return View::render('autorisations/se-connecter',['msgSuppression'=>' Profil supprimé avec succès!']);
      }
      else{
        return View::render('erreur404', ['message'=>"404 - La modification a échoué"]);
      }
  }
}
}