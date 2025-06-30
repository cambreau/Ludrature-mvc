{{ include('layouts/header.php', {
    title: 'Se connecter - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
    <form class="form" method="post" action="autorisation/connexion">
        <div class="form__champ">
              <label for="role">Role :</label>
              <select id="role" name="role">
                <option value="Administrateur">Administrateur</option>
                <option value="Client">Client</option>
             </select>
        </div>
        <div class="form__champ">
              <label for="email">Adresse courriel :</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="ludrature@gmail.com"
                required
              />
        </div>
        <div class="form__champ">
              <label for="motDePasse">Mot de passe :</label>
              <input
                type="motDePasse"
                id="motDePasse"
                name="motDePasse"
                placeholder="Votre mot de passe"
                required
              />
        </div>
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