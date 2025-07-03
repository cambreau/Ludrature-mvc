{{ include('layouts/header.php', {
    title: 'Créer un nouvel administrateur  - Ludrature : Boutique Jeux et Livre',
}) }}

<section>
        <h2>Créer un nouvel administrateur </h2>
        <form class="form" method="post" action="/admin/admin-creation">
        <div class="form__champ">
              <label for="nomUtilisateur">Nom Utilisateur :</label>
              <input
                type="text"
                id="nomUtilisateur"
                name="nomUtilisateur"
                placeholder="Veuillez saisir le nom utilisateur"
                {% if admin.nomUtilisateur is defined %}
                value="{{admin.nomUtilisateur}}"
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
                {% if admin.nom is defined %}
                value="{{admin.nom}}"
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
                {% if admin.prenom is defined %}
                value="{{admin.prenom}}"
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
                {% if admin.email is defined %}
                value="{{admin.email}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.email is defined %}
              <p class="erreur">{{erreurs.email}}</p>
            {%endif %}
            <div class="form__champ">
              <label for="emploi">Emploi :</label>
              <input
                type="text"
                id="emploi"
                name="emploi"
                placeholder="Veuillez saisir l'emploi"
                {% if admin.emploi is defined %}
                value="{{admin.emploi}}"
                {%endif %}
                required
              />
            </div>
            {% if erreurs.emploi is defined %}
              <p class="erreur">{{erreurs.emploi}}</p>
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
                placeholder="Confirmez le mot de passe"
                required
              />
            </div>
            {% if erreurs.confirmationMotPasse is defined %}
              <p class="erreur">{{erreurs.confirmationMotPasse}}</p>
            {%endif %}
          <div class="form__btn-conteneur">
            <input class="form__btn-conteneur__btn" value="S'inscrire" type="submit">
          </div>
        </form>
      </section>

{{ include('layouts/footer.php') }}