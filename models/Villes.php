<?php
namespace App\Models;
use App\Models\CRUD;

class Villes extends CRUD {
    protected $table = "villes";
    protected $clePrimaire = "id";
    protected $colonnes = ['nom'];

}