<?php
// resources/views/news/show.blade.php - Détail d'une nouvelle
?>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nieuws') }}
            </h2>
            <a href="{{ route('news.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Terug
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <article>
                        <header class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                {{ $news->title }}
                            </h1>
                            
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 space-x-4">
                                <span>
                                    Door {{ $news->user->username ?? $news->user->name }}
                                </span>
                                <span>•</span>
                                <time datetime="{{ $news->created_at->toISOString() }}">
                                    {{ $news->created_at->format('d F Y à H:i') }}
                                </time>
                                @if($news->updated_at != $news->created_at)
                                    <span>•</span>
                                    <span>Bewerkt de {{ $news->updated_at->format('d/m/Y') }}</span>
                                @endif
                            </div>

                            @if(auth()->check() && auth()->user()->is_admin)
                                <div class="flex space-x-2 mt-4">
                                    <a href="{{ route('news.edit', $news) }}" 
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        berwerken
                                    </a>
                                    <form action="{{ route('news.destroy', $news) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Supprimer cette nouvelle ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            verwijderen
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </header>

                        <div class="prose dark:prose-invert max-w-none">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                {!! nl2br(e($news->description)) !!}
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
