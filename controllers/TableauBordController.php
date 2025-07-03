<?php
namespace App\Controllers;
use App\Models\TableauBord;
use App\Providers\View;


class TableauBordController{
    static public function logAction() {
        // Déclaration du tableau qui contiendra les informations de l’action.
        $action = []; 

        // Récupérer les informations de l’action.
        $action['date_action'] = date('Y-m-d'); // Ref = https://www.php.net/manual/en/function.date.php
        $action['url'] = $_SERVER['REQUEST_URI']; // Partie de l’URL située après le domaine
        $action['methode'] = $_SERVER['REQUEST_METHOD'];
        // Si les informations utilisateur existent, alors on les récupère. Sinon, on attribue le rôle « visiteur ».
        $action['utilisateur_role'] = $_SESSION['utilisateur_role'] ?? 'visiteur';
        $action['utilisateur_id'] = $_SESSION['utilisateur_id'] ?? 'n/a';
        $action['utilisateur_nom'] = $_SESSION['utilisateur_nomUtilisateur'] ?? 'n/a';

        // Insérer l’action dans la table tableauBord de la base de données.
        $tableauBordCrud = new TableauBord;
        $tableauBordLigne = $tableauBordCrud ->insert($action);

        if($tableauBordLigne){
            return true;
        }else{
            return false;
        }
    }

    public function afficherTableauBord (){
        if(!isset($_SESSION['utilisateur_id'] ) || $_SESSION['utilisateur_role'] !==2)
        {
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
        else{
            $tableauBordCrud = new TableauBord;
            $lignesAction = $tableauBordCrud ->select('id','desc');
            if($lignesAction){
                $session = $_SESSION ?? null;
                return View::render('admin/tableau-bord', ['lignesAction'=>$lignesAction, 'session'=>$session]);
            }
            else{
                return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
            }
        }
    }
}