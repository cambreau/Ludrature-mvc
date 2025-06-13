<?php
namespace App\Models;
use App\Models\CRUD;

class Produit extends CRUD {
    protected $table = "produit";
    protected $clePrimaire = "id";
    protected $colonnes = ['nom','auteur', 'edition', 'date_sortie', 'prix', 'age_min','age_max'];

}