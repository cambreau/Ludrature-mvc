{{ include('layouts/header.php', {
    title: 'Ludrature : Boutique Jeux et Livre',
}) }}

    <section>
        <h2>Profil administrateur</h2>
        <p>Bienvenue dans votre profil administrateur</p>
        <a href="{{base}}/produits/produits-ajouter" class="bouton">Ajouter un produit</a>
    </section>
    <section class="produits-section">
        <h2 class="produits-section__titre">Nos produits</h2>
        <div class="produits-conteneur">
            {% for produit in produits %}
                <a class="produit produit-lien" href="{{base}}/produits/fiche-produit?id={{ produit.id }}">
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
                </a>
            {% endfor %}
        </div>
    </section>
   {{ include('layouts/footer.php') }}