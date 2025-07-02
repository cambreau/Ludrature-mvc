<?php
namespace App\Models;
use App\Models\CRUD;

class Utilisateur extends CRUD {
    protected $table = "utilisateur";
    protected $clePrimaire = "id";
    protected $colonnes = ['nomUtilisateur','nom','prenom', 'email','motDePasse','role'];

    public function hashMotDePasse($password, $cost = 10){
        $options = [
                'cost' => $cost
        ]; // Permet de choisir un autre cost en parametre.
        return password_hash($password, PASSWORD_BCRYPT, $options); 
    }

    public function checkUtilisateur($nomUtilisateur, $motDePasse){
        $utilisateur = $this->unique('nomUtilisateur',$nomUtilisateur);
        if($utilisateur){
            if(password_verify($motDePasse, $utilisateur['motDePasse'])){
                return true;
            }else{
                return false;   
            }
        }else{
            return false; 
        }
    }

    public function creationSession($utilisateur){
        session_regenerate_id();
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $_SESSION['utilisateur_nomUtilisateur'] = $utilisateur['nomUtilisateur'];
        $_SESSION['utilisateur_role'] = $utilisateur['role'];
        $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
        return $_SESSION;
    }
};

