<?php
namespace App\Controllers;
use App\Models\Produit;
use App\Providers\View;

class AccueilController{

    public function index(){
        $produitCrud = new Produit;
        $produits =$produitCrud->select();
        $session = $_SESSION ?? null;
        return View::render('accueil',['produits'=>$produits, 'session'=>$session]);
    }
}