@extends('layouts.app')

@section('title', 'Admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-indigo-50 p-6 rounded-lg">
                        <div class="text-indigo-600 text-sm font-semibold mb-2">Összes Pilóta</div>
                        <div class="text-3xl font-bold text-indigo-900">{{ $stats['total_drivers'] }}</div>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <div class="text-green-600 text-sm font-semibold mb-2">Összes Verseny</div>
                        <div class="text-3xl font-bold text-green-900">{{ $stats['total_races'] }}</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="text-blue-600 text-sm font-semibold mb-2">Összes GP</div>
                        <div class="text-3xl font-bold text-blue-900">{{ $stats['total_gps'] }}</div>
                    </div>
                    <div class="bg-yellow-50 p-6 rounded-lg">
                        <div class="text-yellow-600 text-sm font-semibold mb-2">Összes Üzenet</div>
                        <div class="text-3xl font-bold text-yellow-900">{{ $stats['total_contacts'] }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-4">Pilóták kezelése</h3>
                        <p class="text-gray-600 mb-4">Pilóták hozzáadása, szerkesztése és törlése.</p>
                        <a href="{{ route('drivers.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                            Pilóták kezelése →
                        </a>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-4">Üzenetek kezelése</h3>
                        <p class="text-gray-600 mb-4">Beérkezett üzenetek megtekintése és kezelése.</p>
                        <a href="{{ route('messages.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                            Üzenetek megtekintése →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
