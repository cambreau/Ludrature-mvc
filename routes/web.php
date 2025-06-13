<?php
use App\Routes\Route;
use App\Controllers\AccueilController;

Route::get('', 'AccueilController@index');
Route::get('/', 'AccueilController@index');
Route::get('/accueil', 'AccueilController@index');
Route::get('/accueil/index', 'AccueilController@index');
Route::get('/produits/produits-ajouter', 'ProduitsController@ajouter');
Route::post('/produits/produits-action-ajouter', 'ProduitsController@actionAjouter');
Route::get('/produits/produits-modifier', 'ProduitsController@modifier');
Route::get('/produits/produits-supprimer', 'ProduitsController@supprimer');

Route::dispatch();



