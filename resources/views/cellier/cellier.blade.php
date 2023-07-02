@extends("layout.app")
@section('title', "Un petit verre de vino")
@section('titleHeader', "Un petit verre de vino ?")
@section('content')
<div class="cellier">
    @foreach ($product as $cle => $bouteille)
    <div class="bouteille" data-quantite="">
        <div class="img">
            <img src="{{ $bouteille['image'] }}">
        </div>
        <div class="description">
            <p class="nom">Nom : {{ $bouteille['nom'] }}</p>
            <p class="quantite">Quantité : {{ $bouteille['quantite'] }}</p>
            <p class="pays">Pays : {{ $bouteille['pays'] }}</p>
            <p class="type">Type : {{ $bouteille['type'] }}</p>
            <p class="millesime">Millesime : {{ $bouteille['millesime'] }}</p>
            <p><a href="{{ $bouteille['url_saq'] }}">Voir SAQ</a></p>
        </div>
        <div class="options" data-id="{{ $bouteille['id_bouteille_cellier'] }}">
            <button>Modifier</button>
            <button class='btnAjouter'>Ajouter</button>
            <button class='btnBoire'>Boire</button>
        </div>
    </div>
    @endforeach
</div>
@endsection
