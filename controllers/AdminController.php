<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\TableauBord;
use App\Models\Utilisateur;
use App\Providers\View;
use App\Providers\Validation;


class AdminController{
    public function pageCreation(){
        if(!isset($_SESSION['utilisateur_id'] ) || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }  
        else{
            return View::render('admin/admin-creation'); 
        }
    }
    public function creation($data){
        if(!isset($_SESSION['utilisateur_id'] ) || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
        else{
            // Si la méthode est différente de POST, on renvoie à la page 404.
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return View::render('erreur404', ['Erreur 404 - Page introuvable!']);
            }
            else{
                // Validation des $data.
                $Validation = new Validation;
                $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50)->unique('Utilisateur');
                $Validation->field('nom',$data['nom'])->min(2)->max(50);
                $Validation->field('prenom',$data['prenom'])->min(2)->max(50);
                $Validation->field('email',$data['email'])->min(2)->max(50)->email();
                $Validation->field('emploi',$data['emploi'])->min(2)->max(100);
                $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
                $Validation->field('confirmationMotPasse',$data['confirmation-mot-passe'])->confirmationChampIdentique($data['motDePasse']);
                
                // Si la validation est correcte.
                if($Validation->estUnSucces()){
                    //** On ajoute les données dans la table "utilisateur".
                    $utilisateurCrud = new Utilisateur;
                    $data['motDePasse'] = $utilisateurCrud ->hashMotDePasse($data['motDePasse']);
                    $data['role'] = 2; // Correspond à l’ID du admin dans la table "rôle" de la base de données.
                    $utilisateur = $utilisateurCrud ->insert($data);
                    //** On ajoute des données dans la table "admin".
                    $adminCrud = new Admin;
                    $data['id_Utilisateur']=$utilisateur;
                    $adminInsert = $adminCrud ->insert($data);
                    unset($data); // Pour que le formulaire ne conserve pas les informations après la creation.
                
                    // Si l'insertion du admin dans la base de données a fonctionné, on renvoie vers la page de connexion avec un message de succès.
                    if($adminInsert){
                        $tableauBordCrud = new TableauBord;
                        $lignesAction = $tableauBordCrud ->select('id','desc');
                        return View::render('admin/tableau-bord',['msgCreation'=>"Profil créé avec succès!",'lignesAction'=>$lignesAction]);
                    // Si l'insertion a échoué, alors on renvoie vers la page 404, avec un message d'erreur.
                    }else{
                        return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]);  
                    }
                // Si la validation n'est pas bonne.    
                }else{
                    // On recupère les erreurs.    
                    $erreurs = $Validation->geterreurs();
                    // On renvoie à la page d'inscription, avec les erreurs.
                    return View::render('admin/admin-creation',['erreurs'=>$erreurs,'admin'=>$data]);
               }   
            }
        } 
    }
}
