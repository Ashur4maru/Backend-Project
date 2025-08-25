<?php
// resources/views/profiles/show.blade.php (Version mise à jour)
?>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profil') }}: {{ $user->username ?? 'Pas de nom d\'utilisateur' }}
            </h2>
            <a href="{{ route('profile.edit') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Profiel bewerken
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Naam
                                </label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->name }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email
                                </label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->email }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    gebruikersnaam
                                </label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->username ?? 'Non défini' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Verjaardag
                                </label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->verjaardag ? $user->verjaardag->format('d/m/Y') : 'Non définie' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Over mij
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    {{ $user->about_me ?? 'Aucune description disponible.' }}
                                </div>
                            </div>

                            @if($user->profile_picture)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Profiel foto
                                    </label>
                                    <div class="mt-1">
                                        <img src="{{ Storage::url($user->profile_picture) }}" 
                                             alt="Photo de profil" 
                                             class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>