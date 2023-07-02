@extends('layout.app')

@section('title', 'Un petit verre de vino')
@section('titleHeader', 'Un petit verre de vino ?')

@section('content')
<div class="ajouter">
    <form method="post" class="nouvelleBouteille" vertical layout>
        @csrf
        <label for="nom_bouteille">Recherche:</label>
        <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete"></ul>
        <div>
            <p>Nom: <span data-id="" class="nom_bouteille"></span></p>
            <p>Millesime: <input name="millesime"></p>
            <p>Quantite: <input name="quantite" value="1"></p>
            <p>Date achat: <input name="date_achat"></p>
            <p>Prix: <input name="prix"></p>
            <p>Garde: <input name="garde_jusqua"></p>
            <p>Notes: <input name="notes"></p>
        </div>
        <button type="submit" name="ajouterBouteilleCellier">Ajouter la bouteille (champs tous obligatoires)</button>
    </form>
</div>
@endsection
