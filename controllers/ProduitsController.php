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
        if(isset($_GET['id']) && $_GET['id'] != null){
            $produit_id = $_GET['id'];
            $produitCrud = new Produit;
            $produit = $produitCrud -> selectId($produit_id);
            $session = $_SESSION ?? null;
            if($produit){
                return View::render('produits/fiche-produit',['produit'=>$produit, 'session'=>$session]);
            }
            else{
                 return View::render('erreur404', ['message'=>'Produit introuvable!']);
            }
        }
        else{
            return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
        }
    }

    public function formulaireAjouter(){
        if(!isset($_SESSION['utilisateur_id'] ) || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
            $categorieSelection = null;
            $themesSelection = null;
            if (isset($_GET['categorie'])){
                $categorieSelection = $_GET['categorie'];
            }
            if (isset($_GET['themes'])){
                $themesSelection = $_GET['themes'];
            }
            // Recuperer les options themes par categorie.
            $themeCrud = new Theme;
            $themesJeux = $themeCrud->selectWhere(1,'categorie_id');
            $themesLivre = $themeCrud->selectWhere(2,'categorie_id');
            // Recuperer les options de categorie.
            $categorieCrud = new Categorie;
            $categories = $categorieCrud->select();
            $session = $_SESSION ?? null;
            return View::render('produits/produits-ajouter',['categories'=>$categories, 'themesJeux'=>$themesJeux, 'themesLivre'=>$themesLivre,'categorieSelection'=>$categorieSelection,'themesSelection'=>$themesSelection,'session'=>$session]);
    }

    public function actionAjouter($data){
        if(!isset($_SESSION['utilisateur_id'] )  || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
            // Validation des $data.
            $Validation = new Validation;
            $Validation->field('nom',$data['nom'])->min(2)->max(100);
            $Validation->field('auteur',$data['auteur'])->min(2)->max(100);
            $Validation->field('edition',$data['edition'])->min(2)->max(100);
            $Validation->field('date_sortie',$data['date_sortie'])->obligatoire();
            $Validation->field('prix',$data['prix'])->min(1)->max(20);
            $Validation->field('age_min',$data['age_min'])->obligatoire();

            if($Validation->estUnSucces()){
                // Insertion du produit.
                $produitCrud = new Produit;
                $_POST['age_max'] = isset($_POST['age_max']) && $_POST['age_max'] !== '' ? (int)$_POST['age_max'] : null;
                $produit_id = $produitCrud->insert($_POST);
                if(!$produit_id){
                    return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]);   
                }
                else{
                    // Insertion du produit-theme
                    $themes = $data['themes'];
                    $produitThemeCrud = new ProduitTheme;
                    foreach ($themes as $theme_id) {
                        $produitTheme = $produitThemeCrud -> insert(['produit_id' => $produit_id,'theme_id' => $theme_id]);
                        echo $produitTheme;
                        if(!$produitTheme){
                            return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]); 
                        }
                    }
                }
                        $produit = $produitCrud -> selectId($produit_id);
                        $session = $_SESSION ?? null;
                        return View::render('produits/fiche-produit',['produit'=>$produit,'session'=>$session]);
            }
             else{
                $erreurs = $Validation->geterreurs();
                // Recuperer les options themes par categorie.
                $themeCrud = new Theme;
                $themesJeux = $themeCrud->selectWhere(1,'categorie_id');
                $themesLivre = $themeCrud->selectWhere(2,'categorie_id');
                // Recuperer les options de categorie.
                $categorieCrud = new Categorie;
                $categories = $categorieCrud->select();
                // Recuperer categorieSelection
                $categorieSelection = $data['categorie'];
                // Recuperer categorieSelection
                $themesSelection = $data['themes'];

                return View::render('produits/produits-ajouter',['categories'=>$categories, 'themesJeux'=>$themesJeux, 'themesLivre'=>$themesLivre,'categorieSelection'=>$categorieSelection,'themesSelection'=>$themesSelection, 'erreurs'=>$erreurs ]);
            }
    }   

    public function formulaireModifier(){
        if(!isset($_SESSION['utilisateur_id'] ) || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
         if(isset($_GET['id']) && $_GET['id'] != null){
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
            
            if($produit){
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
                $session = $_SESSION ?? null;
                return View::render('produits/produits-modifier',['produit'=>$produit,'categorie'=>$categorie,'themes'=>$themes,'session'=>$session]);
            }  
            else{
                return View::render('erreur404', ['message'=>'Produit introuvable!']);
            } 
         } else{
            return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
         }
    }

    public function actionModifier($data){
        if(!isset($_SESSION['utilisateur_id'] )  || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
        // Validation des $data.
        $Validation = new Validation;
        $Validation->field('nom',$data['nom'])->min(2)->max(100);
        $Validation->field('auteur',$data['auteur'])->min(2)->max(100);
        $Validation->field('edition',$data['edition'])->min(2)->max(100);
        $Validation->field('date_sortie',$data['date_sortie'])->obligatoire();
        $Validation->field('prix',$data['prix'])->min(1)->max(20);
        $Validation->field('age_min',$data['age_min'])->obligatoire();
        
        if($Validation->estUnSucces()){
            $produitCrud = new Produit;
            $produitId = $data['id'];
            $$data['age_max'] = isset($_POST['age_max']) && $_POST['age_max'] !== '' ? (int)$_POST['age_max'] : null;
            // print_r($data);
            $produitModifie = $produitCrud->update($data, $produitId);
            return View::redirect("produits/fiche-produit?id=$produitId");
        }
        else {
            $erreurs = $Validation->geterreurs();
            // ** Recuperer les informations du produit.
            $produitCrud = new Produit;
            $produit = $produitCrud->selectId($data['id']);

            // ** Recuperer les id des themes du produit.
            $themeProduitThemeCrud = new ProduitTheme;
            $themesProduits = $themeProduitThemeCrud->selectWhere($data['id'],'produit_id');
 
            // ** Recuperer la totalite des inforations des themes (nom et categorie_Id).
            $themeCrud = new Theme;
            $themes=[];
            foreach($themesProduits as $themeProduit){
                $theme = $themeCrud->selectId($themeProduit['theme_id']);
                array_push($themes,$theme);
            };
        
            $categorieId = $themes[0]["categorie_id"];

            // ** Recuperer le nom de la categorie du produit.
            $categorieCrud = new Categorie;
            $categorie = $categorieCrud->selectId($categorieId);
            $categorie["nom"] = ucfirst($categorie["nom"]);
        
            return View::render('produits/produits-modifier',['produit'=>$produit,'categorie'=>$categorie,'themes'=>$themes, 'erreurs'=>$erreurs]);
        }
    }

    public function supprimer($data){
        if(!isset($_SESSION['utilisateur_id'] )  || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
        // echo "Je suis dans supprimer";
        if(isset($data['id']) && $data['id'] != null){
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
                return View::render('erreur404', ['message'=>'La suppression a échoué']);
            }
        }  
        else{ return View::render('erreur404', ['Erreur 404 - Page introuvable!']);} 
}
}