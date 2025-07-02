<?php
namespace App\Models;
use App\Models\Utilisateur;

class Client extends Utilisateur {
    protected $table = "clients";
    protected $autoIncrement = false;
    protected $clePrimaire = "id_Utilisateur";
    protected $colonnes = ['id_Utilisateur','adresse', 'codePostal', 'ville'];

}