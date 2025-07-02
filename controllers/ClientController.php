<?php
namespace App\Controllers;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Villes;
use App\Providers\View;
use App\Providers\Validation;



class ClientController{
    public function pageInscription(){
        //Recuperer les informations sur les villes.
        $villesCrud = new Villes; 
        $villes = $villesCrud -> select();
        //Renvoyer vers la view Clients/inscription
        return View::render('clients/client-inscription', ['villes'=>$villes] );
    }

    public function inscription($data){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return View::render('erreur404', ['Erreur 404 - Page introuvable!']);
        }
        else{
             // Validation des $data.
        $Validation = new Validation;
        $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50);
        $Validation->unique('Utilisateur');
        $Validation->field('nom',$data['nom'])->min(2)->max(50);
        $Validation->field('prenom',$data['prenom'])->min(2)->max(50);
        $Validation->field('email',$data['email'])->min(2)->max(50);
        $Validation->email();
        $Validation->unique('Utilisateur');
        $Validation->field('adresse',$data['adresse'])->min(2)->max(100);
        $Validation->field('codePostal',$data['codePostal'])->min(6)->max(7);
        $Validation->field('ville',$data['ville'])->obligatoire();
        $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
        $Validation->field('confirmationMotPasse',$data['confirmation-mot-passe'])->confirmationChampIdentique($data['motDePasse']);
         if($Validation->estUnSucces()){
             //Ajout des donnees dans la table "utilisateur".
             $utilisateurCrud = new Utilisateur;
             $data['motDePasse'] = $utilisateurCrud ->hashMotDePasse($data['motDePasse']);
             $data['role'] = 1; // Correspond à l’ID du client dans la table "rôle" de la base de données.
             $utilisateur = $utilisateurCrud ->insert($data);
            //Ajout des donnees dans la table "client".
            $clientCrud = new Client;
            $data['id_Utilisateur']=$utilisateur;
            $clientInsert = $clientCrud ->insert($data);
            $client =$clientCrud ->selectId($data['id_Utilisateur']);
            unset($data); // Pour que le formulaire ne conserve pas les informations apres inscription.
           
            if($client){
                return View::render('autorisations/se-connecter',['msg'=>"Profil créé avec succès!"]);
            }else{
                return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]);  
            }
         }else{
            $erreurs = $Validation->geterreurs();
             //Recuperer les informations sur les villes.
            $villesCrud = new Villes; 
            $villes = $villesCrud -> select();
            return View::render('clients/client-inscription',['villes'=>$villes,'erreurs'=>$erreurs,'client'=>$data]);
         }   
        }
}
}
