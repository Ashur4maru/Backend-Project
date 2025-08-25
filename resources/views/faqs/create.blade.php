<?php
// resources/views/faqs/create.blade.php - Création FAQ/Catégorie
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter une Catégorie ou Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                    
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('faqs.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type
                            </label>
                            <select name="type" id="type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                    onchange="toggleFields(this)">
                                <option value="category" {{ old('type', 'category') === 'category' ? 'selected' : '' }}>Catégorie</option>
                                <option value="faq" {{ old('type') === 'faq' ? 'selected' : '' }}>Question/Réponse</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs catégorie -->
                        <div id="category-fields">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nom de la catégorie
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Champs FAQ -->
                        <div id="faq-fields" class="hidden space-y-4">
                            <div>
                                <label for="faq_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Catégorie
                                </label>
                                <select name="faq_category_id" id="faq_category_id" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('faq_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('faq_category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Question
                                </label>
                                <input type="text" 
                                       id="question" 
                                       name="question" 
                                       value="{{ old('question') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('question')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Réponse
                                </label>
                                <textarea id="answer" 
                                          name="answer" 
                                          rows="6"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('answer') }}</textarea>
                                @error('answer')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('faqs.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ajouter
                            </button>
                        </div>
                    </form>

                    <script>
                        function toggleFields(select) {
                            const categoryFields = document.getElementById('category-fields');
                            const faqFields = document.getElementById('faq-fields');
                            const nameInput = document.getElementById('name');
                            const faqCategoryId = document.getElementById('faq_category_id');
                            const questionInput = document.getElementById('question');
                            const answerInput = document.getElementById('answer');

                            if (select.value === 'category') {
                                categoryFields.classList.remove('hidden');
                                faqFields.classList.add('hidden');
                                nameInput.removeAttribute('disabled');
                                faqCategoryId.setAttribute('disabled', 'disabled');
                                questionInput.setAttribute('disabled', 'disabled');
                                answerInput.setAttribute('disabled', 'disabled');
                            } else {
                                categoryFields.classList.add('hidden');
                                faqFields.classList.remove('hidden');
                                nameInput.setAttribute('disabled', 'disabled');
                                faqCategoryId.removeAttribute('disabled');
                                questionInput.removeAttribute('disabled');
                                answerInput.removeAttribute('disabled');
                            }
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            const typeSelect = document.getElementById('type');
                            toggleFields(typeSelect);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
