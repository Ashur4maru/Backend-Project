<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Contact Bericht') }}
            </h2>
            <a href="{{ route('contact.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    
                    <!-- Header bericht info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Van:</h3>
                                <p class="text-lg text-gray-900 dark:text-gray-100">{{ $contact->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contact->email }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ontvangen op:</h3>
                                <p class="text-lg text-gray-900 dark:text-gray-100">
                                    {{ $contact->created_at->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $contact->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Onderwerp -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Onderwerp:</h3>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $contact->subject }}
                        </h1>
                    </div>

                    <!-- Bericht -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Bericht:</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                        </div>
                    </div>

                    <!-- Status indicator -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Status:</span>
                            @if($contact->is_read)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Gelezen
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Nieuw
                                </span>
                            @endif
                        </div>

                        <!-- Acties -->
                        <div class="flex space-x-2">
                            <!-- E-mail button -->
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Beantwoord via e-mail
                            </a>

                            <!-- Verwijder button -->
                            <form method="POST" action="{{ route('contact.destroy', $contact) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Verwijder
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact info voor gemakkelijke referentie -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Snelle acties:</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="tel:{{ str_replace(' ', '', $contact->email) }}" 
                               class="text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded">
                                Kopieer e-mail: {{ $contact->email }}
                            </a>
                            <button onclick="copyToClipboard('{{ $contact->email }}')" 
                                    class="text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded">
                                📋 Kopieer e-mail naar clipboard
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('E-mailadres gekopieerd naar clipboard!');
            }, function() {
                // Fallback voor oudere browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('E-mailadres gekopieerd naar clipboard!');
            });
        }
    </script>
</x-app-layout>