<?php
namespace App\Models;
use App\Models\CRUD;

class ProduitTheme extends CRUD {
    protected $table = "produit_theme";
    protected $autoIncrement = false;

    protected $clePrimaire ='produit_id';
    protected $colonnes = ['produit_id','theme_id'];

}