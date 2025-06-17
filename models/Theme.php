<?php
namespace App\Models;
use App\Models\CRUD;

class Theme extends CRUD {
    protected $table = "theme";
    protected $clePrimaire = "id";
    protected $colonnes = ['nom','categorie_id'];

}