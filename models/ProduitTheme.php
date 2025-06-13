<?php
namespace App\Models;
use App\Models\CRUD;

class ProduitTheme extends CRUD {
    protected $table = "produit_theme";
    protected $clePrimaire = "id";
    protected $colonnes = ['categorie_id','nom'];

}