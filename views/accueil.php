{{ include('layouts/header.php', {
    title: 'Ludrature : Boutique Jeux et Livre',
}) }}

    <section>
    {% if message is defined %}
        <h3> {{ message }} </h3>
    {% endif %}
    {% if session is defined and session.utilisateur_role == 2 %} 
        <a href="{{base}}/produits/produits-ajouter" class="bouton">Ajouter un produit</a>
    {% endif %}
    </section>
    <section class="produits-section">
        <h2 class="produits-section__titre">Nos produits</h2>
        <div class="produits-conteneur">
            {% for produit in produits %}
                <a class="produit" href="{{base}}/produits/fiche-produit?id={{ produit.id }}">
                    <picture class="produit-image">
                        <img src="{{asset}}/images/produit-{{ produit.id }}.jpg" alt="{{ produit.nom }}" />
                    </picture>
                    <h3>{{produit.nom}}</h3>
                    <div class="produit-description">
                        <p>Auteur: {{produit.auteur}}</p>
                        <p>Edition: {{produit.edition}}</p>
                        <p>Prix: {{produit.prix}}$</p>
                        <p>Age: {{produit.age_min}} 
                            {% if produit.age_max is not null %}
                                - {{ produit.age_max }}
                            {% endif %} ans 
                        </p>
                    </div>  
                    {% if session is defined and session.utilisateur_role == 1 %} 
                    <button class="bouton bouton-petit">Ajouter au panier</button>
                    {% endif %}
                </a>
            {% endfor %}
        </div>
    </section>
   {{ include('layouts/footer.php') }}