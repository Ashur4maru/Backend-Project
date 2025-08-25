<?php
// resources/views/profiles/edit.blade.php - Édition de profil
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profiel bewerken
') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Information du profil -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Profielinformatie') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Werk uw accountgegevens en e-mailadres bij.
") }}
                        </p>
                    </div>

                    @if(session('status') === 'profile-updated')
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ __('Profiel is succesvol bijgewerkt.
') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Naam') }}
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                       required autofocus autocomplete="name">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('E-mail') }}
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                       required autocomplete="username">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200">
                                            {{ __('Uw e-mailadres is niet geverifieerd.
') }}

                                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                {{ __('Klik hier om de verificatiemail opnieuw te versturen.
') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                {{ __('Er is een nieuwe verificatielink naar uw e-mailadres verzonden.
') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('gebruikersnaam') }}
                                </label>
                                <input type="text" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username', $user->username) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="verjaardag" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('verjaardag') }}
                                </label>
                                <input type="date" 
                                       id="verjaardag" 
                                       name="verjaardag" 
                                       value="{{ old('verjaardag', $user->verjaardag ? $user->verjaardag->format('Y-m-d') : '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('verjaardag')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('profiel foto') }}
                            </label>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('profile_picture')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            @if($user->profile_picture)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($user->profile_picture) }}" 
                                         alt="Photo de profil actuelle" 
                                         class="w-20 h-20 rounded-full object-cover">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Actuele foto</p>
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="about_me" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Over mij') }}
                            </label>
                            <textarea id="about_me" 
                                      name="about_me" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('about_me', $user->about_me) }}</textarea>
                            @error('about_me')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Changer le mot de passe -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Wachtwoord wijzigen
') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Zorg ervoor dat u voor de veiligheid van uw account een lang, willekeurig wachtwoord gebruikt.
') }}
                        </p>
                    </div>

                    @if(session('status') === 'password-updated')
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ __('Wachtwoord verandert met succes') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Actuele wachtwoord') }}
                            </label>
                            <input type="password" 
                                   id="update_password_current_password" 
                                   name="current_password" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                   autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Nieuwe wachtwoord') }}
                            </label>
                            <input type="password" 
                                   id="update_password_password" 
                                   name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                   autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Wachtwoord bevestigen') }}
                            </label>
                            <input type="password" 
                                   id="update_password_password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                   autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Supprimer le compte -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Account verwijderen') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Zodra uw account is verwijderd, worden alle bronnen en gegevens permanent verwijderd. Download voordat u uw account verwijdert alle gegevens of informatie die u wilt behouden.
') }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Account verwijderen') }}
                        </button>
                    </div>

                    <!-- Modal de confirmation -->
                    <div x-data="{ show: false }" 
                         x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null" 
                         x-on:close-modal.window="$event.detail == 'confirm-user-deletion' ? show = false : null" 
                         x-show="show" 
                         class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" 
                         style="display: none;">
                        
                        <div x-show="show" 
                             class="fixed inset-0 transform transition-all" 
                             x-on:click="show = false"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                        </div>

                        <div x-show="show" 
                             class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            
                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('
Weet u zeker dat u uw account wilt verwijderen?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('
Zodra uw account is verwijderd, worden alle bronnen en gegevens permanent verwijderd. Voer uw wachtwoord in om te bevestigen dat u uw account permanent wilt verwijderen.') }}
                                </p>

                                <div class="mt-6">
                                    <label for="password" class="sr-only">{{ __('Wachtwoord') }}</label>
                                    <input type="password" 
                                           id="password"
                                           name="password" 
                                           class="w-3/4 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white" 
                                           placeholder="{{ __('Mot de passe') }}">
                                    @error('password', 'userDeletion')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" 
                                            x-on:click="$dispatch('close-modal')"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                        {{ __('Annuleren') }}
                                    </button>

                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Account verwijderen') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
