<?php
namespace App\Controllers;
use App\Models\Produit;
use App\Models\Theme;
use App\Providers\View;

class AccueilController{

    public function index(){
        $produitCrud = new Produit;
        $produits =$produitCrud->select();
        $themeCrud = new Theme;
        $themesJeux = $themeCrud->selectWhere('categorie_id', 1);
        $themesLivre = $themeCrud->selectWhere('categorie_id', 2);
        return View::render('accueil',['produits'=>$produits, 'themeJeux'=>$themesJeux, 'themeLivre'=>$themesLivre]);
    }
}