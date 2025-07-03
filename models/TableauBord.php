<?php
namespace App\Models;

class TableauBord extends CRUD {
    protected $table = "tableauBord";
    protected $clePrimaire = "id";
    protected $colonnes = ['date_action', 'url', 'methode', 'utilisateur_id', 'utilisateur_nom', 'utilisateur_role'];

} 