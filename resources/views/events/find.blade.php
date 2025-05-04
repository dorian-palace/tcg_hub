@extends('layouts.app')

@section('title', 'Recherche d\'événements TCG | TCG HUB')
@section('meta_description', 'Trouvez des événements de jeux de cartes à collectionner près de chez vous')

@section('styles')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<style>
    .map-container {
        height: 500px;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .search-results {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Trouver des événements TCG près de chez vous</h1>
    
    <div id="event-search-app">
        <event-search></event-search>
    </div>
</div>
@endsection