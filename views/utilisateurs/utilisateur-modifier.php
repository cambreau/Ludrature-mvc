{{ include('layouts/header.php', {
    title: 'Modification Profil - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
        <h2>Modification du profil</h2>
        <form class="form" method="post" action="/utilisateurs/modifier">
            <div class="form__champ">
              <label for="nomUtilisateur">Nom Utilisateur :</label>
              <input
                type="text"
                id="nomUtilisateur"
                name="nomUtilisateur"
                placeholder="Veuillez saisir le nom utilisateur"
                {% if utilisateur.nomUtilisateur is defined %}
                value="{{utilisateur.nomUtilisateur}}"
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
                placeholder="Veuillez saisir le nom"
                {% if utilisateur.nom is defined %}
                value="{{utilisateur.nom}}"
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
                placeholder="Veuillez saisir le prénom"
                {% if utilisateur.prenom is defined %}
                value="{{utilisateur.prenom}}"
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
                placeholder="Veuillez saisir l'adresse courriel"
                {% if utilisateur.email is defined %}
                value="{{utilisateur.email}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.email is defined %}
              <p class="erreur">{{erreurs.email}}</p>
            {%endif %}
            {% if utilisateur.role == 1 %}
              <div class="form__champ">
                <label for="adresse">Adresse :</label>
                <input
                  type="text"
                  id="adresse"
                  name="adresse"
                  placeholder="Veuillez saisir votre adresse"
                  {% if utilisateur.adresse is defined %}
                  value="{{utilisateur.adresse}}"
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
                  {% if utilisateur.codePostal is defined %}
                  value="{{utilisateur.codePostal}}"
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
                    <option value="{{ ville.id }}" {% if ville.id == utilisateur.ville %}
                      selected
                    {%endif %}>
                    {{ ville.nom }}</option>
                  {%endfor%}
                </select>
              </div>
            {%endif %}
            {% if utilisateur.role == 2 %}
              <div class="form__champ">
                <label for="emploi">Emploi :</label>
                <input
                  type="text"
                  id="emploi"
                  name="emploi"
                  placeholder="Veuillez saisir l'emploi"
                  {% if utilisateur.emploi is defined %}
                  value="{{utilisateur.emploi}}"
                  {%endif %}
                  required
                />
              </div>
              {% if erreurs.emploi is defined %}
                <p class="erreur">{{erreurs.emploi}}</p>
              {%endif %}
            {%endif %}
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