<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Villes;
use App\Providers\View;
use App\Providers\Validation;
use App\Models\Utilisateur;
use App\Models\Produit;

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
      $Validation = new Validation;
      $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50);
      $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();

      if($Validation->estUnSucces()){
         $utilisateurCrud = new Utilisateur;
         $checkUtilisateur = $utilisateurCrud->checkUtilisateur($data['nomUtilisateur'], $data['motDePasse']);
         if($checkUtilisateur){
            $utilisateur = $utilisateurCrud->selectWhere($data['nomUtilisateur'],'nomUtilisateur');
            $utilisateurSession = $utilisateurCrud ->creationSession($utilisateur[0]);
            if($utilisateur[0]['role'] === 1){
                $produitCrud = new Produit;
                $produits =$produitCrud->select();
                $utilisateur = $utilisateurSession ?? null;
                return View::render('accueil',['produits'=>$produits, 'session'=>$utilisateur]);
            }
             else if($data[0]['role'] === 2){
             return View::render('admin/tableau-bord');
             }
         }else{
             $erreurs = $Validation->geterreurs();
             $message = "Veuillez vérifier vos identifiants ";
             return View::render('autorisations/se-connecter', ['erreurs'=>$erreurs, 'message'=>$message]);
         }

        }else{
         $erreurs = $Validation->geterreurs();
         return View::render('autorisations/se-connecter', ['erreurs'=>$erreurs]);
     }

   }
   public function deconnexion (){
    session_destroy();
    return View::render('autorisations/se-connecter');
   }

}


