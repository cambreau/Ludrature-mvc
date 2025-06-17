<?php
namespace App\Controllers;
use App\Models\Theme;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\ProduitTheme;
use App\Providers\View;
use App\Providers\Validation;

class ProduitsController{

    public function affichageProduit(){
        $produit_id = $_GET['id'];
        $produitCrud = new Produit;
        $produit = $produitCrud -> selectId($produit_id);
        return View::render('produits/fiche-produit',['produit'=>$produit]);
    }
    public function formulaireAjouter(){
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

    public function actionAjouter($data){
        // Insertion du produit.
        $produitCrud = new Produit;
        $produit_id = $produitCrud->insert($_POST);
        if(!$produit_id){
            return View::render('erreur404', ['message'=>'404 not found!']);   
        }
        else{
            // Insertion du produit-theme
            $themes = $data['themes'];
            $produitThemeCrud = new ProduitTheme;
            foreach ($themes as $theme_id) {
                $produitTheme = $produitThemeCrud -> insert(['produit_id' => $produit_id,'theme_id' => $theme_id]);
                if(!$produitTheme){
                    return View::render('erreur404', ['message'=>'404 not found!']); 
                }
            }
        }
        $produit = $produitCrud -> selectId($produit_id);
        return View::render('produits/fiche-produit',['produit'=>$produit]);
    }

    public function formulaireModifier(){
        // ** Recuperer les informations du produit.
        $produitCrud = new Produit;
        $produit = $produitCrud->selectId($_GET['id']);
        //Debug
        // echo '<br>';
        // print_r($produit);
        // if($produit){
        //     echo 'Je suis dans formulaireModifier niveau produit recuperer';
        //     echo '<br>';
        // };
        //Fin Debug

        // ** Recuperer les id des themes du produit.
        $themeProduitThemeCrud = new ProduitTheme;
        $themesProduits = $themeProduitThemeCrud->selectWhere($_GET['id'],'produit_id');
        //Debug
        // echo '<br>';
        // print_r($themesProduits);
        // if($themesProduits){
        //     echo 'Je suis dans formulaireModifier niveau themesProduits recuperer';
        //     echo '<br>';
        // };
        //Fin Debug

        // ** Recuperer la totalite des inforations des themes (nom et categorie_Id).
        $themeCrud = new Theme;
        $themes=[];
        foreach($themesProduits as $themeProduit){
            $theme = $themeCrud->selectId($themeProduit['theme_id']);
            //Debug
            // echo '<br>';
            // print_r($theme);
            // if($theme){
            //     echo 'Je suis dans formulaireModifier niveau theme recuperer';
            //     echo '<br>';
            // };
            //Fin Debug
            array_push($themes,$theme);
        };
        //Debug
            // echo '<br>';
            // print_r($themes);
            // if($themes){
            //     echo 'Je suis dans formulaireModifier niveau validation de $themes a envoyer grace au render';
            //     echo '<br>';
            // };
            //Fin Debug
        
        $categorieId = $themes[0]["categorie_id"];
        // echo $categorieId;

        // ** Recuperer le nom de la categorie du produit.
        $categorieCrud = new Categorie;
        $categorie = $categorieCrud->selectId($categorieId);
        $categorie["nom"] = ucfirst($categorie["nom"]);
        //Debug
        // echo '<br>';
        // print_r($categorie);
        // if($categorie){
        //     echo 'Je suis dans formulaireModifier niveau validation de $categorie a envoyer grace au render';
        //     echo '<br>';
        // };
        //Fin Debug

        return View::render('produits/produits-modifier',['produit'=>$produit,'categorie'=>$categorie,'themes'=>$themes]);
    }

    public function actionModifier($data){
        $produitCrud = new Produit;
        $produitId = $data['id'];
        print_r($data);
        $produitModifie = $produitCrud->update($data, $produitId);
        return View::redirect("produits/fiche-produit?id=$produitId");
    }

    public function supprimer($data){
        //Supression des lignes correspond au produit dans la table produit-theme.
        $produitThemeCrud = new ProduitTheme;
        $deleteProduitTheme =$produitThemeCrud->delete($data['id']);
        //Suppression du produit
        $produitCrud = new Produit;
        $deleteProduit = $produitCrud->delete($data['id']);
        //Valider que les suppression soient faites avant de rediriger sinon renvoie à la page 404.
        if($deleteProduit && $deleteProduitTheme){
            return View::redirect('accueil');
        }else{
            return View::render('erreur404', ['message'=>'404 not found!']);
        }
    }
}