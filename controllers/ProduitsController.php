<?php
namespace App\Controllers;
use App\Models\Theme;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\ProduitTheme;
use App\Providers\View;

class ProduitsController{

    public function ajouter(){
        $categorieSelection = null;
        $themesSelection = null;
        if (isset($_GET['categorie'])){
            $categorieSelection = $_GET['categorie'];
        }
        if (isset($_GET['themes'])){
            $themesSelection = $_GET['themes'];
        }
        $themeCrud = new Theme;
        $themesJeux = $themeCrud->selectWhere(1,'categorie_id');
        $themesLivre = $themeCrud->selectWhere(2,'categorie_id');
        $categorieCrud = new Categorie;
        $categories = $categorieCrud->select();
        return View::render('produits/produits-ajouter',['categories'=>$categories, 'themesJeux'=>$themesJeux, 'themesLivre'=>$themesLivre,'categorieSelection'=>$categorieSelection,'themesSelection'=>$themesSelection]);
    }

    public function actionAjouter(){
        $produitCrud = new Produit;
        $produitId = $produitCrud->insert($_POST);
        
        if ($produitId && isset($_POST['themes'])) {
            $produitTheme = new ProduitTheme;
            $produitTheme->insertProduitThemes($produitId, $_POST['themes']);
        }
        
        return View::render('produits/produits-ajouter');
    }

    public function modifier(){
    }

    public function supprimer(){
    }
}