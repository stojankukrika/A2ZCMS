<ul>
    @foreach($users as $user)
        <li>{{ $user->name }} : {{ $user->surname }}</li>
    @endforeach
</ul>