<?php
// resources/views/faqs/index.blade.php
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Question & Answer') }}
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
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="mb-6">
                                <a href="{{ route('faqs.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Categorie of vraag toevoegen
                                </a>
                            </div>
                        @endif
                    @endauth

                    @if($categories->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Geen Vragen</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Er zijn nog geen vragen gesteld.</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-8">
                            @foreach($categories as $category)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $category->name }}
                                        </h3>
                                        @if(auth()->user()->is_admin ?? false)
                                            <div class="flex space-x-2">
                                                <a href="{{ route('faqs.edit', ['id' => $category->id, 'type' => 'category']) }}" 
                                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Verwerken
                                                </a>
                                                <form action="{{ route('faqs.destroy', ['id' => $category->id, 'type' => 'category']) }}" 
                                                      method="POST" class="inline" 
                                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        verwijderen
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    @if($category->faqs->isEmpty())
                                        <p class="text-gray-500 dark:text-gray-400 italic">Aucune question dans cette catégorie.</p>
                                    @else
                                        <div class="space-y-4">
                                            @foreach($category->faqs as $faq)
                                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $faq->question }}
                                                        </h4>
                                                        @if(auth()->user()->is_admin ?? false)
                                                            <div class="flex space-x-2 ml-4">
                                                                <a href="{{ route('faqs.edit', ['id' => $faq->id, 'type' => 'faq']) }}" 
                                                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                                                    Verwerken
                                                                </a>
                                                                <form action="{{ route('faqs.destroy', ['id' => $faq->id, 'type' => 'faq']) }}" 
                                                                      method="POST" class="inline" 
                                                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette question ?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">
                                                                        verwijderen
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <p class="text-gray-700 dark:text-gray-300">{{ $faq->answer }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>