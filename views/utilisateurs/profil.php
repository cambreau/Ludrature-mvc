{{ include('layouts/header.php', {
    title: 'Profil - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
<h2>Profil</h2>
<div class="profil">
<p><span>Nom d'utilisateur :</span> {{ utilisateur.nomUtilisateur }}</p>

<p><span>Nom :</span> {{ utilisateur.nom }}</p>

<p><span>Prénom :</span> {{ utilisateur.prenom }}</p>

<p><span>Adresse courriel : {{ utilisateur.email }}</p>

<p><span>Adresse :</span> {{ utilisateur.adresse }}</p>

<p><span>Code postal :</span> {{ utilisateur.codePostal }}</p>

<p><span>Ville :</span> {{ utilisateur.ville }}</p>

<p><span>Mot de passe :</span> ********</p>

<p><span>Confirmation du mot de passe :</span> ********</p>

<div class="conteneur-btn">
    <a class="bouton" href="utilisateur/modifier">Modifier</a>
    <a class="bouton bouton-rouge" href="utilisateur/supprimer">Supprimer</a>
</div>
</div>
</section>

{{ include('layouts/footer.php') }}