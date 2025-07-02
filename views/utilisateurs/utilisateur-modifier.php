{{ include('layouts/header.php', {
    title: 'Modification Profil - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
        <h2>Modification du profil</h2>
        <form class="form" method="post" action="/clients/modifier">
        <div class="form__champ">
              <label for="nomUtilisateur">Nom Utilisateur :</label>
              <input
                type="text"
                id="nomUtilisateur"
                name="nomUtilisateur"
                placeholder="Veuillez saisir votre nom utilisateur"
                {% if client.nomUtilisateur is defined %}
                value="{{client.nomUtilisateur}}"
                {%endif %}
                required
              />
            </div> 
            {% if erreurs.nomUtilisateur is defined %}
              <p class="erreur">{{erreurs.nomUtilisateur}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="nom">Nom :</label>
              <input
                type="text"
                id="nom"
                name="nom"
                placeholder="Veuillez saisir votre nom"
                {% if client.nom is defined %}
                value="{{client.nom}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.nom is defined %}
              <p class="erreur">{{erreurs.nom}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="prenom">Prénom :</label>
              <input
                type="text"
                id="prenom"
                name="prenom"
                placeholder="Veuillez saisir votre prénom"
                {% if client.prenom is defined %}
                value="{{client.prenom}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.prenom is defined %}
              <p class="erreur">{{erreurs.prenom}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="email">Adresse courriel :</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="Veuillez saisir votre adresse courriel"
                {% if client.email is defined %}
                value="{{client.email}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.email is defined %}
              <p class="erreur">{{erreurs.email}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="adresse">Adresse :</label>
              <input
                type="text"
                id="adresse"
                name="adresse"
                placeholder="Veuillez saisir votre adresse"
                {% if client.adresse is defined %}
                value="{{client.adresse}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.adresse is defined %}
              <p class="erreur">{{erreurs.adresse}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="codePostal">Code postal :</label>
              <input
                type="text"
                id="codePostal"
                name="codePostal"
                placeholder="Veuillez saisir votre code postal"
                {% if client.codePostal is defined %}
                value="{{client.codePostal}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.codePostal is defined %}
              <p class="erreur">{{erreurs.codePostal}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="ville">Ville :</label>
              <select id="ville" name="ville" required>
                <option value="">-- Sélectionnez une ville --</option>
                {% for ville in villes %}
                  <option value="{{ ville.id }}" {% if ville.id == client.ville %}
                    selected
                  {%endif %}>
                  {{ ville.nom }}</option>
                {%endfor%}
              </select>
            </div>
            <div class="form__champ">
              <label for="motDePasse">Mot de passe :</label>
              <input
                type="password"
                id="motDePasse"
                name="motDePasse"
                placeholder="Choisissez un mot de passe"
                required
              />
            </div>
            {% if erreurs.motDePasse is defined %}
              <p class="erreur">{{erreurs.motDePasse}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="confirmation-mot-passe"
                >Confirmez le mot de passe :</label
              >
              <input
                type="password"
                id="confirmation-mot-passe"
                name="confirmation-mot-passe"
                placeholder="Confirmez votre mot de passe"
                required
              />
            </div>
            {% if erreurs.confirmationMotPasse is defined %}
              <p class="erreur">{{erreurs.confirmationMotPasse}}</p>
            {%endif %}
          <div class="form__btn-conteneur">
            <input class="form__btn-conteneur__btn" value="Modifier" type="submit">
          </div>
        </form>
      </section>

{{ include('layouts/footer.php') }}