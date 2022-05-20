<h1>Bonjour {{ $role_user }}</h1>

<p>La greatness académie t’invite à créer un nouveau compte avec le Rôle <strong>{{ $role_user }}</strong> sur leur
    outil de gestion. </p>
<p>Clique sur le lien suivant afin de te créer ton compte:
    <a class="btn btn-primary" href="{{ route('define_password.reset', $token) }}">créer votre compte ici</a>
</p>