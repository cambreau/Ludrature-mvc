     {{ include('layouts/header.php', {
    title: 'Fiche Produit - Ludrature : Boutique Jeux et Livre',
}) }}
    <div class="produit__fiche-produit">
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
                   - {{ produit.age_max }}
                {% endif %}
                ans </p>
                <p>{{session.utilisateur_role}}</p>
                    <div class="bouton-conteneur"> 
                        {% if session.utilisateur_id is not defined or session.utilisateur_role == 1 %} 
                             <button class="bouton bouton-petit">Ajouter au panier</button>
                        {% endif %}
                        {% if session.utilisateur_id is defined and session.utilisateur_role == 2 %}
                            <a class="bouton" href="{{base}}/produits/produits-modifier?id={{ produit.id }}">Modifier</a>
                            <form method="post" action="{{base}}/produit/supprimer">
                                <input type="hidden" name="id" value="{{ produit.id }}">
                                <button class="bouton bouton-rouge" type="submit">Supprimer</button>
                            </form>
                        {% endif %}
                    </div>  
            </div>    
     </section>
    </div>
   {{ include('layouts/footer.php') }}