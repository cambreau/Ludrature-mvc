     {{ include('layouts/header.php', {
    title: 'Fiche Produit - Ludrature : Boutique Jeux et Livre',
}) }}
     <section class="produit">
            <picture class="produit-image">
                <img src="{{asset}}/images/produit-{{ produit.id }}.jpg" alt="{{ produit.nom }}" />
            </picture>
            <h3>{{ produit.nom }}</h3>
            <div class="produit-description">
                <p>{{ produit.auteur }}</p>
                <p>Edition: {{ produit.edition }}</p>
                <p>Prix: {{ produit.prix }} $</p>
                <p>Age: {{ produit.age_min }} 
                {%if produit.age_max is defined %}   
                   - {{ produit.age_max }} ans
                {%endif %}
                <div class="bouton-conteneur">
                  <a class="bouton" href="{{Base}}/produits/produits-modifier?id={{ produit.id }}">Modifier</a>
                  <form method="post" action="/produit/supprimer">
                      <input type="hidden" name="id" value="{{ produit.id }}">
                      <button class="bouton bouton-rouge" type="submit">Supprimer</button>
                  </form>
                </div>  
            </div>    
        </section>
   {{ include('layouts/footer.php') }}