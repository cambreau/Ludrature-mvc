<?php
namespace App\Controllers;
use App\Models\Client;
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
        $Validation->field('nom',$data['nom'])->min(2)->max(50);
        $Validation->field('prenom',$data['prenom'])->min(2)->max(50);
        $Validation->field('email',$data['email'])->min(2)->max(50);
        $Validation->email();
        $Validation->unique('Client');
        $Validation->field('adresse',$data['adresse'])->min(2)->max(100);
        $Validation->field('codePostal',$data['codePostal'])->min(1)->max(20);
        $Validation->field('ville',$data['ville'])->obligatoire();
        $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
        $Validation->field('confirmation-mot-passe',$data['confirmation-mot-passe'])->confirmationChampIdentique($data['motDePasse']);
         if($Validation->estUnSucces()){
            $clientCrud = new Client;
            $data['motDePasse'] = $clientCrud ->hashMotDePasse($data['motDePasse']);
            $client = $clientCrud ->insert($_POST);
            if($client){
                return View::render('autorisations/se-connecter',['msg'=>"Profil créé avec succès"]);
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
