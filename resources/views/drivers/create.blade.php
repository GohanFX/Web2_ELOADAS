@extends('layouts.app')

@section('title', 'Új pilóta hozzáadása')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Új pilóta hozzáadása</h2>

                <form method="POST" action="{{ route('drivers.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Név *</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="sex" class="block text-sm font-medium text-gray-700">Nem *</label>
                        <select id="sex" name="sex" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Válassz...</option>
                            <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Férfi</option>
                            <option value="N" {{ old('sex') == 'N' ? 'selected' : '' }}>Nő</option>
                        </select>
                        @error('sex')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Születési dátum *</label>
                        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Ország *</label>
                        <input id="country" type="text" name="country" value="{{ old('country') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Hozzáadás
                        </button>
                        <a href="{{ route('drivers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Mégse
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
