<?php
namespace App\Models;
use App\Models\CRUD;

class Role extends CRUD {
    protected $table = "roles";
    protected $clePrimaire ='id';
    protected $colonnes = ['nom'];
}