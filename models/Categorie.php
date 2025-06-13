<?php
namespace App\Models;
use App\Models\CRUD;

class Categorie extends CRUD {
    protected $table = "categorie";
    protected $clePrimaire = "id";
    protected $colonnes = ['nom'];

}