<?php
use App\Routes\Route;

Route::get('', 'AccueilController@index');
Route::get('/', 'AccueilController@index');
Route::get('/accueil', 'AccueilController@index');
Route::get('/accueil/index', 'AccueilController@index');

Route::get('/produits/fiche-produit', 'ProduitsController@affichageProduit');

Route::get('/produits/produits-ajouter', 'ProduitsController@formulaireAjouter');
Route::post('/produits/actionAjouter', 'ProduitsController@actionAjouter');

Route::get('/produits/produits-modifier', 'ProduitsController@formulaireModifier');
Route::post('/produits/actionModifier','ProduitsController@actionModifier');

Route::post('/produit/supprimer', 'ProduitsController@supprimer');

Route::dispatch();



