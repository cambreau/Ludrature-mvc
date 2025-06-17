<?php
namespace App\Providers;

class Validation {
    private $erreurs = array();
    private $cle;
    private $valeur;
    private $nom;


    /**
     * La méthode field() enregistre un champ (clé, valeur) en mettant la première lettre du nom en majuscule.
     * Met la première lettre d'une chaîne de caractères en majuscule, et laisse le reste inchangé.
     * https://www.php.net/manual/en/function.ucfirst.php 
     */
    public function field($cle, $valeur, $nom = null){
        $this->cle = $cle;
        $this->valeur = $valeur;
        if($nom == null){
            $this->nom = ucfirst($cle);
        }else{
            $this->nom = ucfirst($nom);
        }
        return $this;
    }

    /**
     * Valide que la valeur ne soit pas nulle, sinon renvoie un message d’erreur.
     */
    public function obligatoire(){
        if(empty($this->valeur)){
            $this->erreurs[$this->cle] = "$this->nom est obligatoire";
        }
        return $this;
    }

    /**
     * Valide que la valeur ait une longueur inférieure ou égale à la taille maximum autorisée.
     * https://www.php.net/manual/fr/function.strlen.php Calcul la taille d'une chaîne de caractères.
     */
    public function max($length){
        if(strlen($this->valeur) >= $length ){
            $this->erreurs[$this->cle] = "$this->nom doit avoir moins de $length caractères";
        }
        return $this;
    }

    /**
     * Valide que la valeur ait une longueur supérieure à la taille minimum autorisée.
     */
    public function min($length){
        if(strlen($this->valeur) < $length ){
            $this->erreurs[$this->cle] = "$this->nom doit avoir plus de $length caractères";
        }
        return $this;
    }

    /**
     * Si il n'y a aucune erreur retourne vrai.
     */
    public function estUnSucces(){
        if(empty($this->erreurs)) return true;
    }

    /**
     * Si estUnSucces() = false alors renvoie la variable erreurs.
     */
    public function geterreurs(){
        if(!$this->estUnSucces()) return $this->erreurs;
    }
}
?>