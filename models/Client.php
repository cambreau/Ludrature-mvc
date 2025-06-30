<?php
namespace App\Models;
use App\Models\CRUD;

class Client extends CRUD {
    protected $table = "clients";
    protected $clePrimaire = "id";
    protected $colonnes = ['nom','prenom', 'email', 'adresse', 'codePostal', 'ville','motDePasse','role'];

    public function hashMotDePasse($password, $cost = 10){
        $options = [
                'cost' => $cost
        ]; // Permet de choisir un autre cost en parametre.
        return password_hash($password, PASSWORD_BCRYPT, $options); 
    }
}