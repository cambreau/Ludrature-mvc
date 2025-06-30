<?php
namespace App\Controllers;
use App\Providers\View;
use App\Providers\Validation;

class AutorisationController{
   public function seConnecter (){
    return View::render('/autorisations/se-connecter');
   }
   public function connexion (){}
   public function deconnexion (){}

}


