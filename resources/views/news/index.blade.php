<?php
// resources/views/news/index.blade.php
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nieuws') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(auth()->check() && auth()->user()->is_admin)
                        <div class="mb-6">
                            <a href="{{ route('news.create') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nieuws toevoegen
                            </a>
                        </div>
                    @endif

                    @if($news->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Geen nieuws</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nog geen nieuws gepubliceerd</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($news as $item)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $item->title }}
                                        </h3>
                                        @if(auth()->check() && auth()->user()->is_admin)
                                            <div class="flex space-x-2">
                                                <a href="{{ route('news.edit', $item) }}" 
                                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    bewerken
                                                </a>
                                                <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette nouvelle ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        verwijderen
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        Gepubliceerd door {{ $item->user->username ?? $item->user->name }} op {{ $item->created_at->format('d/m/Y') }}
                                    </p>
                                    
                                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                                        {{ Str::limit($item->description, 200) }}
                                    </p>
                                    
                                    <a href="{{ route('news.show', $item) }}" 
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                        Volgende lezen →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>