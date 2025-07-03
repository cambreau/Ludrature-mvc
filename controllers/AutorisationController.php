<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Villes;
use App\Providers\View;
use App\Providers\Validation;
use App\Models\Utilisateur;
use App\Models\Produit;
use App\Models\TableauBord;

class AutorisationController{
    
   public function status (){
        if(isset($_SESSION['utilisateur_id'])){
            //** Récupérer les informations de l'utilisateur. 
            $utilisateurCrud = new Utilisateur();
            $informationsUtilisateur = $utilisateurCrud ->selectId($_SESSION['utilisateur_id']);
            //** Récupérer les informations supplémentaires liées au rôle de l'utilisateur.
            if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
                $clientCrud = new Client;
                $informationsSupplementaires = $clientCrud -> selectId($_SESSION['utilisateur_id']);
                $villeCrud =new Villes;
                $ville= $villeCrud->selectId($informationsSupplementaires["ville"]);
                $informationsSupplementaires["ville"]=$ville['nom'];
            }
            else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
            {
                $adminCrud = new Admin;
                $informationsSupplementaires = $adminCrud -> selectId($_SESSION['utilisateur_id']);
            }
            // Fusionner les informations utilisateur et supplémentaires en gardant les noms de clés
            $utilisateur = array_merge($informationsUtilisateur, $informationsSupplementaires);
            $session = $_SESSION ?? null;
            return View::render('/utilisateurs/profil',['utilisateur'=>$utilisateur,'session'=>$session]);
        }else{
            return View::render('/autorisations/se-connecter');
        }   
   }
   public function connexion ($data){
     // Validation du format du nom utilisateur et du mot de passe.
      $Validation = new Validation;
      $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50);
      $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
     // Si la validation est un succès. 
      if($Validation->estUnSucces()){
        // On valide que le mot de passe soit le bon.
         $utilisateurCrud = new Utilisateur;
         $checkUtilisateur = $utilisateurCrud->checkUtilisateur($data['nomUtilisateur'], $data['motDePasse']);
         // Si le mot de passe est bon.
         if($checkUtilisateur){
            // On récupère les informations de l’utilisateur pour créer la session.
            $utilisateur = $utilisateurCrud->selectWhere($data['nomUtilisateur'],'nomUtilisateur');
            $utilisateurSession = $utilisateurCrud ->creationSession($utilisateur[0]);
            // Si l'utilisateur a un role Client, alors on recupère les produits pour afficher le catalogue produits.
            if($utilisateur[0]['role'] === 1){
                $produitCrud = new Produit;
                $produits =$produitCrud->select();
                $utilisateur = $utilisateurSession ?? null;
                return View::render('accueil',['produits'=>$produits, 'session'=>$utilisateur]);
            }
            //Si le rôle est un administrateur, on redirige vers le tableau de bord.
             else if($utilisateur[0]['role'] === 2){
                $tableauBordCrud = new TableauBord;
                $lignesAction = $tableauBordCrud ->select('id','desc');
                $session = $_SESSION ?? null;
                return View::render('admin/tableau-bord', ['lignesAction'=>$lignesAction, 'session'=>$session]);
             }
         // Si le mot de passe n'est pas correct, on recupère les erreurs et on renvoie une message d'erreur.    
         }else{
             $erreurs = $Validation->geterreurs();
             $message = "Veuillez vérifier vos identifiants ";
             return View::render('autorisations/se-connecter', ['erreurs'=>$erreurs, 'message'=>$message]);
         }
        // Si la validation des champs n'est pas correcte, on recupère les erreurs et on les renvoie.   
      }else{
         $erreurs = $Validation->geterreurs();
         return View::render('autorisations/se-connecter', ['erreurs'=>$erreurs]);
      }
   }

   public function deconnexion (){
    // On détruit la session et on renvoie à la page de connexion.
    session_destroy();
    return View::render('autorisations/se-connecter');
   }

}


