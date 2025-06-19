{{ include('./layouts/header.php', {title: 'Erreur - 404'}) }}
   {% if message is defined %}
        <h2>{{message}}</h2>
   {%endif%}
{{ include('layouts/footer.php') }}