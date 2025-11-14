@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">Üdvözöljük a Formula 1 Alkalmazásban!</h1>
                
                <div class="mt-6">
                    <p class="text-lg text-gray-600 mb-4">
                        Ez az alkalmazás lehetővé teszi a Formula 1 adatok böngészését, diagramok megtekintését és kapcsolatfelvételt.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Adatbázis</h3>
                            <p class="text-gray-600 mb-4">Böngéssze a versenyzőket, versenyeket és Grand Prix adatokat.</p>
                            <a href="{{ route('database.index') }}" class="text-indigo-600 hover:text-indigo-900">Megtekintés →</a>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Diagram</h3>
                            <p class="text-gray-600 mb-4">Tekintse meg a statisztikákat és diagramokat.</p>
                            <a href="{{ route('chart.index') }}" class="text-indigo-600 hover:text-indigo-900">Megtekintés →</a>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Kapcsolat</h3>
                            <p class="text-gray-600 mb-4">Küldjön üzenetet vagy kérdést számunkra.</p>
                            <a href="{{ route('contact.create') }}" class="text-indigo-600 hover:text-indigo-900">Üzenet küldése →</a>
                        </div>
                    </div>
                </div>

                @auth
                <div class="mt-8 p-4 bg-indigo-50 rounded-lg">
                    <p class="text-indigo-800">
                        Bejelentkezve mint: <strong>{{ auth()->user()->name }}</strong>
                        @if(auth()->user()->role === 'admin')
                            <span class="ml-2 px-2 py-1 bg-indigo-600 text-white text-xs rounded">Admin</span>
                        @endif
                    </p>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
