<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    @auth
                        @if(auth()->user()->is_admin)
                            @php
                                $unreadContacts = \App\Models\Contact::unread()->orderBy('created_at', 'desc')->limit(5)->get();
                                $unreadCount = \App\Models\Contact::unread()->count();
                            @endphp

                            @if($unreadCount > 0)
                                <div class="mt-6">
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">
                                                📧 Nieuwe contactberichten
                                            </h3>
                                            <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded-full">
                                                {{ $unreadCount }} nieuw
                                            </span>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            @foreach($unreadContacts as $contact)
                                                <div class="bg-white dark:bg-gray-700 rounded p-3 border-l-4 border-blue-500">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $contact->name }}
                                                            </p>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $contact->email }}
                                                            </p>
                                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mt-1">
                                                                {{ Str::limit($contact->subject, 50) }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                {{ $contact->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('contact.show-message', $contact) }}" 
                                                           class="ml-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                                            Bekijk →
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 flex justify-between">
                                            <a href="{{ route('contact.index') }}" 
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                                Bekijk alle berichten →
                                            </a>
                                            @if($unreadCount > 5)
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    En {{ $unreadCount - 5 }} meer...
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Admin statistieken -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-green-900 dark:text-green-100">
                                        Totaal contactberichten
                                    </h4>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {{ \App\Models\Contact::count() }}
                                    </p>
                                </div>
                                
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-100">
                                        Nieuwe berichten
                                    </h4>
                                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                        {{ $unreadCount }}
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        Deze maand
                                    </h4>
                                    <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">
                                        {{ \App\Models\Contact::whereMonth('created_at', now()->month)->count() }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>