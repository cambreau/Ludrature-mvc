<?php
namespace App\Controllers;
use App\Providers\View;
use App\Providers\Validation;
use App\Models\Utilisateur;
use App\Models\Produit;

class AutorisationController{
    
   public function status (){
        if(isset($_SESSION['utilisateur_id'])){
            $utilisateurCrud = new Utilisateur();
            $utilisateur = $utilisateurCrud ->selectId($_SESSION['utilisateur_id']);
            return View::render('/utilisateurs/profil',['utilisateur'=>$utilisateur]);
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
         $utilisateur = $utilisateurCrud->selectWhere($data['nomUtilisateur'],'nomUtilisateur');
         print_r($utilisateur);
         if($checkUtilisateur){
            if($utilisateur[0]['role'] === 1){
                $produitCrud = new Produit;
                $produits =$produitCrud->select();
                $utilisateur = $_SESSION['utilisateur'] ?? null;
                return View::render('accueil',['produits'=>$produits, 'utilisateur'=>$utilisateur]);
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
   public function deconnexion (){}

}


