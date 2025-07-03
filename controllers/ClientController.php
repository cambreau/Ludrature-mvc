<?php
namespace App\Controllers;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Villes;
use App\Providers\View;
use App\Providers\Validation;



class ClientController{
    public function pageInscription(){
        // Récupérer les informations sur les villes. 
        $villesCrud = new Villes; 
        $villes = $villesCrud -> select();
        // Renvoyer vers la view Clients/inscription
        return View::render('clients/client-inscription', ['villes'=>$villes] );
    }

    public function inscription($data){
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
            $Validation->field('adresse',$data['adresse'])->min(2)->max(100);
            $Validation->field('codePostal',$data['codePostal'])->min(6)->max(7);
            $Validation->field('ville',$data['ville'])->obligatoire();
            $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
            $Validation->field('confirmationMotPasse',$data['confirmation-mot-passe'])->confirmationChampIdentique($data['motDePasse']);
            
            // Si la validation est correcte.
            if($Validation->estUnSucces()){
                //** On ajoute les données dans la table "utilisateur".
                $utilisateurCrud = new Utilisateur;
                $data['motDePasse'] = $utilisateurCrud ->hashMotDePasse($data['motDePasse']);
                $data['role'] = 1; // Correspond à l’ID du client dans la table "rôle" de la base de données.
                $utilisateur = $utilisateurCrud ->insert($data);
                //** On ajoute des données dans la table "client".
                $clientCrud = new Client;
                $data['id_Utilisateur']=$utilisateur;
                $clientInsert = $clientCrud ->insert($data);
                unset($data); // Pour que le formulaire ne conserve pas les informations après l'inscription.
            
                // Si l'insertion du client dans la base de données a fonctionné, on renvoie vers la page de connexion avec un message de succès.
                if($clientInsert){
                    return View::render('autorisations/se-connecter',['msgCreation'=>"Profil créé avec succès!"]);
                // Si l'insertion a échoué, alors on renvoie vers la page 404, avec un message d'erreur.
                }else{
                    return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]);  
                }
            // Si la validation n'est pas bonne.    
            }else{
                // On recupère les erreurs.    
                $erreurs = $Validation->geterreurs();
                // On recupère  les informations sur les villes.
                $villesCrud = new Villes; 
                $villes = $villesCrud -> select();
                // On renvoie à la page d'inscription, avec les erreurs.
                return View::render('clients/client-inscription',['villes'=>$villes,'erreurs'=>$erreurs,'client'=>$data]);
           }   
        }
    }
}
