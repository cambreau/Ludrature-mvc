<?php
namespace App\Models;
use App\Models\Utilisateur;

class Admin extends Utilisateur {
    protected $table = "admin";
    protected $autoIncrement = false;
    protected $clePrimaire = "id_Utilisateur";
    protected $colonnes = ['id_Utilisateur','emploi'];

}