{{ include('layouts/header.php', {
    title: 'Tableau de bord - Ludrature : Boutique Jeux et Livre',
}) }}

{%if msgCreation is defined %}
    <p class="succes">{{msgCreation}}</p>
{% endif %}    
{% if session.utilisateur_id is defined and session.utilisateur_role == 2 %}
        <a class="bouton bouton-petit" href="{{base}}/admin/admin-creation">Créer un nouvel administrateur</a>
{% endif %}
<div class="table__conteneur">
    <h2>Tableau de bord - Logs des visites</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Page visitée</th>
                <th scope="col">Methode</th>
                <th scope="col">Rôle</th>
                <th scope="col">ID utilisateur</th>
                <th scope="col">Nom d'utilisateur</th>
            </tr>
        </thead>
        <tbody>
            {% for ligneAction in lignesAction %}
                <tr {% if ligneAction.utilisateur_role == 0 %} class="table__role-visiteur"  {% endif %}
                    {% if ligneAction.utilisateur_role == 1 %} class="table__role-client"  {% endif %}
                    {% if ligneAction.utilisateur_role == 2 %} class="table__role-admin"  {% endif %}
                >
                    <td>{{ ligneAction.date_action }}</td>
                    <td>{{ ligneAction.url }}</td>
                    <td>{{ ligneAction.methode ?? 'n/a' }}</td>
                    <td>
                        {% if ligneAction.utilisateur_role == 0 %}
                            Visiteur
                        {% elseif ligneAction.utilisateur_role == 1 %}
                            Client
                        {% elseif ligneAction.utilisateur_role == 2 %}
                            Admin
                        {% endif %}
                    </td>
                    <td>{{ ligneAction.utilisateur_id}}</td>
                    <td>{{ ligneAction.utilisateur_nom}}</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}