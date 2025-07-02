{{ include('layouts/header.php', {
    title: 'Se connecter - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
  {% if msgSuppression is defined %}
        <p class="succes">{{msgSuppression}}</p>
  {%endif%}
  {% if msgCreation is defined %}
        <p class="succes">{{msgCreation}}</p>
  {%endif%}
  
    <h2>Connexion</h2>
    <form class="form" method="post" action="/autorisations/connexion">
    {% if message is defined %}
        <p class="erreur">{{message}}</p>
    {%endif%}
        <div class="form__champ">
              <label for="email">Nom d'utilisateur :</label>
              <input
                type="text"
                id="nomUtilisateur"
                name="nomUtilisateur"
                placeholder="Votre nom d'utilisateur"
                required
              />
        </div>
        {% if erreurs.nomUtilisateur is defined %}
              <p class="erreur">{{erreurs.nomUtilisateur}}</p>
        {%endif %}
        <div class="form__champ">
              <label for="motDePasse">Mot de passe :</label>
              <input
                type="password"
                id="motDePasse"
                name="motDePasse"
                placeholder="Votre mot de passe"
                required
              />
        </div>
        {% if erreurs.motDePasse is defined %}
              <p class="erreur">{{erreurs.motDePasse}}</p>
        {%endif %}
        <div class="form__btn-conteneur">
            <input class="form__btn-conteneur__btn" value="Se connecter" type="submit">
        </div>
    </form>
</section>
<div>
  <p>Pas encore de compte ?</p>
  <a class="bouton" href="{{base}}/clients/client-inscription">Créer un compte</a>
</div>
{{ include('layouts/footer.php') }}