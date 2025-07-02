<?php
use App\Routes\Route;

Route::get('', 'AccueilController@index');
Route::get('/', 'AccueilController@index');
Route::get('/accueil', 'AccueilController@index');
Route::get('/index', 'AccueilController@index');
Route::get('/index.php', 'AccueilController@index');

Route::get('/autorisations/status', 'AutorisationController@status');
Route::post('/autorisations/connexion', 'AutorisationController@connexion');
Route::get('/autorisations/deconnexion', 'AutorisationController@deconnexion');

Route::get('/clients/client-inscription', 'ClientController@pageInscription');
Route::post('/clients/inscription', 'ClientController@inscription');

Route::get('/produits/fiche-produit', 'ProduitsController@affichageProduit');
Route::get('/produits/produits-ajouter', 'ProduitsController@formulaireAjouter');
Route::post('/produits/actionAjouter', 'ProduitsController@actionAjouter');
Route::get('/produits/produits-modifier', 'ProduitsController@formulaireModifier');
Route::post('/produits/actionModifier','ProduitsController@actionModifier');
Route::post('/produit/supprimer', 'ProduitsController@supprimer');

Route::get('/utilisateurs/utilisateur-modifier', 'UtilisateurController@pageModifier');
Route::post('/utilisateurs/modifier', 'UtilisateurController@modifier');
Route::get('/utilisateurs/supprimer', 'UtilisateurController@supprimer');



Route::dispatch();



