<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Site internet de vente de livre et jeux de société" />
    <meta
      name="keywords"
      content="jeux de société, livre"
    />
    <meta name="author" content="Ludrature" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset}}/css/style.css" />
    <title>{{titre}}</title>
  </head>
  <body>
    <!-- navigation =================================================================================================-->
    <header class="entete">
      <a class="titre-logo" href="{{base}}/accueil">
        <img src="{{asset}}/images/logo.svg" alt="Logo du restaurant Ludrature" />
        <h1><span class="titre-logo__titre-rouge">Lud</span>rature</h1></a
      >
      <form class="recherche" method="get">
        <div class="recherche-barre">
          <input 
            name="recherche"
            type="text"
            id="recherche"
            placeholder="Trouver un produit"
          />
          <button type="submit">
              <span class="recherche-cache">trouver</span>
              <i class="fa fa-search"></i>
          </button>
        </div>
      </form>
      <nav class="menu-principal">
          <div class="sousMenu">
            <a href="#">Jeux de société <span>&#9663;</span></>
          </div>
          <div class="sousMenu">
            <a href="#">Livres <span>&#9663;</span></a>
          </div>
      </nav>
      <a class="bouton bouton-petit bouton-rouge" href="{{base}}/autorisations/status">Profil</a>
    </header>
    <main>