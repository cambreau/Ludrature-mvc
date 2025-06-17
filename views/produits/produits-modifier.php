{{ include('./layouts/header.php', {title: 'Modifier - Ludrature : Boutique Jeux et Livre'}) }}
  <h2>Modifier le produit numéro {{produit.id}} {{produit.nom}}</h2>
       <div class="non-modifiable">
        <p class="label-non-modifiable">Catégorie:</p>
        <p class="input-non-modifiable">{{categorie.nom}}</p>
      </div>
      <div class="non-modifiable">
        <p class="label-non-modifiable">Thème:</p>
        {% for theme in themes %}
            <p class="input-non-modifiable">{{theme.nom}}</p>
        {% endfor %}
      </div>
      <form class="form-produit" method="post" action="/produits/actionModifier">
        <input type="hidden" name="id" value="{{produit.id}}"/>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="{{produit.nom}}" required/>
        <label for="auteur">Auteur:</label>
        <input type="text" id="auteur" name="auteur" value="{{produit.auteur}}" required/>
        <label for="edition">Edition:</label>
        <input type="text" id="edition" name="edition" value="{{produit.edition}}"required/>
        <label for="date_sortie">Date de sortie:</label>
        <input type="date" id="date_sortie" name="date_sortie" value="{{produit.date_sortie}}"/>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" value="{{produit.prix}}" required/>
        <label for="age_min">Age minimum:</label>
        <input type="number" id="age_min" name="age_min" value="{{produit.age_min}}" required/>
        {% if categorie.id == 1 %}
          <label for="age_max">Age maximum:</label>
          <input type="number" id="age_max" name="age_max" value="{{produit.age_max}}"/>
        {% endif %}
        <button class="bouton" type="submit">Modifier</button>
      </form>
{{ include('./layouts/footer.php') }}