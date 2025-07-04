<?php
namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\Client;
use App\Models\Admin;
use App\Models\Villes;
use Dompdf\Dompdf;
use App\Providers\View;

class EnregistrementPdfController {

    public function enregistrerPDF(){
        // Initialisation du Dompdf
        $dompdf = new Dompdf();

        // On reconstruit la vue Profil car DomPdf ne sait pas lire le  TWIG. 
         //** Récupérer les informations de l'utilisateur. 
         $utilisateurCrud = new Utilisateur();
         $informationsUtilisateur = $utilisateurCrud ->selectId($_SESSION['utilisateur_id']);
         //** Récupérer les informations supplémentaires liées au rôle de l'utilisateur.
         if($_SESSION['utilisateur_role'] === 1){ // Si le role est Client.
             $clientCrud = new Client;
             $informationsSupplementaires = $clientCrud -> selectId($_SESSION['utilisateur_id']);
             $villeCrud =new Villes;
             $ville= $villeCrud->selectId($informationsSupplementaires["ville"]);
             $informationsSupplementaires["ville"]=$ville['nom'];
         }
         else if($_SESSION['utilisateur_role'] === 2) // Si le role est admin
         {
             $adminCrud = new Admin;
             $informationsSupplementaires = $adminCrud -> selectId($_SESSION['utilisateur_id']);
         }

       
        // On recontruit le html pour le pdf.
        // References: https://github.com/dompdf/dompdf/wiki/CSSCompatibility / https://www.php.net/manual/fr/language.operators.string.php
        // CSS du pdf suit mes variables CSS.
        $html = '<style>
        .profil h1 { font-size: 28px; margin-bottom: 20px; }
        .profil p { margin: 10px 0; }
        .profil span { font-weight: 700; }
        </style>';
        $html .= '<div class="profil">';
        $html .= '<h1>Profil</h1>';
        $html .= '<p><span>Nom d\'utilisateur :</span> ' . $informationsUtilisateur['nomUtilisateur'] . '</p>';
        $html .= '<p><span>Nom :</span> ' . $informationsUtilisateur['nom'] . '</p>';
        $html .= '<p><span>Prénom :</span> ' . $informationsUtilisateur['prenom'] . '</p>';
        $html .= '<p><span>Adresse courriel :</span> ' . $informationsUtilisateur['email'] . '</p>';
        if ($_SESSION['utilisateur_role'] === 1) {
            $html .= '<p><span>Adresse :</span> ' . $informationsSupplementaires['adresse'] . '</p>';
            $html .= '<p><span>Code postal :</span> ' . $informationsSupplementaires['codePostal'] . '</p>';
            $html .= '<p><span>Ville :</span> ' . $informationsSupplementaires['ville'] . '</p>';
        }
        if ($_SESSION['utilisateur_role'] === 2) {
            $html .= '<p><span>Emploi :</span> ' . $informationsSupplementaires['emploi'] . '</p>';
        }
        $html .= '</div>';


        $dompdf->loadHtml($html); 

         // On générer le PDF
         $dompdf->render();

         // On envoye le PDF au navigateur
         $dompdf->stream("document.pdf");

         // Retourne à la vue du profi
         return View::render('utilisateurs/profil');
    }
}

