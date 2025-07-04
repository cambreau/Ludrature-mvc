{{ include('layouts/header.php', {
    title: 'Profil - Ludrature : Boutique Jeux et Livre',
}) }}

<section>

<h2>Profil </h2> 
<div class="profil__conteneur-btn">
<a class="bouton bouton-rouge" href="{{base}}/autorisations/deconnexion">Se deconnecter</a>
<a class="pdf" href="{{base}}/utilisateurs/profilPDF"> <img src="{{asset}}/images/pdf.svg"></a>
</div>
<div class="profil">
<p><span>Nom d'utilisateur :</span> {{ utilisateur.nomUtilisateur }}</p>
<p><span>Nom :</span> {{ utilisateur.nom }}</p>
<p><span>Prénom :</span> {{ utilisateur.prenom }}</p>
<p><span>Adresse courriel : {{ utilisateur.email }}</p>

{% if session.utilisateur_role == 1 %}
<p><span>Adresse :</span> {{ utilisateur.adresse }}</p>
<p><span>Code postal :</span> {{ utilisateur.codePostal }}</p>
<p><span>Ville :</span> {{ utilisateur.ville }}</p>
{%endif%}

{% if session.utilisateur_role == 2 %}
<p><span>Emploi :</span> {{ utilisateur.emploi }}</p>
{%endif%}

<p><span>Mot de passe :</span> ********</p>
<div class="conteneur-btn">
    <a class="bouton" href="/utilisateurs/utilisateur-modifier?id={{ utilisateur.id }}">Modifier</a>
    <a class="bouton bouton-rouge" href="/utilisateurs/supprimer?id={{ utilisateur.id }}">Supprimer</a>
</div>
</div>
</section>

{{ include('layouts/footer.php') }}