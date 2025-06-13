{{ include('./layouts/header.php', {title: 'Ajouter - Ludrature : Boutique Jeux et Livre'}) }}

 <h2>Ajouter un produit</h2>
      <form class="form-produit" method="get">
        <label for="categorie">Catégorie:</label>
        <select name="categorie" id="categorie" onchange="this.form.submit()" required >
           <option class="placeholder" value="" disabled selected hidden>Choisissez une option</option>
             {% for categorie in categories %}
            <option value="{{ categorie.id }}" {% if categorieSelection is defined and categorieSelection == categorie.id %}selected{% endif %}>
                {{ categorie.nom }}
            </option>
            {%endfor%}
        </select>
      </form>
      <form class="form-produit" method="get">
          <label for="themes">Thèmes:</label>
          <select name="themes[]" id="themes" onchange="this.form.submit()" multiple required>
                {%if categorieSelection is defined and categorieSelection == 1 %}
                  {%for theme in themesJeux %}
                    <option value="{{ theme.id }}" {% if themesSelection is defined and theme.id in themesSelection %}selected{% endif %}>{{ theme.nom }}</option>
                  {%endfor %}
                {%else%}
                  {%for theme in themesLivre %}
                    <option value="{{ theme.id }}" {% if themesSelection is defined and theme.id in themesSelection %}selected{% endif %}>{{ theme.nom }}</option>
                  {%endfor %}
                {%endif %}
          </select>
          <input type="hidden" name="categorie" value="{{ categorieSelection }}">
      </form>
      <form class="form-produit" method="post" action="{{base}}/produits/action-ajouter">
          <input type="hidden" name="categorie" value="{{ categorieSelection }}">
          {% if themesSelection is defined %}
            {% for theme in themesSelection %}
              <input type="hidden" name="themes[]" value="{{ theme }}">
            {% endfor %}
          {% endif %}
          <label for="nom">Nom:</label>
          <input type="text" id="nom" name="nom" placeholder="Entrez le nom du produit"/>
          <label for="auteur">Auteur:</label>
          <input type="text" id="auteur" name="auteur" placeholder="Entrez le nom de l'auteur" required/>
          <label for="edition">Edition:</label>
          <input type="text" id="edition" name="edition" placeholder="Entrez le nom de l'édition" required/>
          <label for="date_sortie">Date de sortie:</label>
          <input type="date" id="date_sortie" name="date_sortie" placeholder="Entrez la date de sortie" required/>
          <label for="prix">Prix:</label>
          <input type="number" id="prix" name="prix" placeholder="Entrez le prix du produit" required/>
          <label for="age_min">Age minimum:</label>
          <input type="number" id="age_min" name="age_min" placeholder="Entrez l'age minimum" required/>
           {%if categorieSelection is defined and categorieSelection == 1 %}
            <label for="age_max">Age maximum:</label>
            <input type="number" id="age_max" name="age_max" placeholder="Entrez l'age maximum"/>
          {%endif%}
          <button class="bouton" type="submit">Ajouter</button>
      </form>
{{ include('./layouts/footer.php') }}