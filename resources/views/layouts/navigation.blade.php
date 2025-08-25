<!-- Dans les Navigation Links (vers ligne 20) -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    
    <!-- Lien Contact pour tous -->
    <x-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.show')">
        {{ __('Contact') }}
    </x-nav-link>
    
    <!-- Liens admin -->
    @auth
        @if(auth()->user()->is_admin)
            <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.*')">
                {{ __('Berichten') }}
                @php
                    $unreadCount = \App\Models\Contact::unread()->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="ml-1 px-1.5 py-0.5 bg-red-600 text-white text-xs rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </x-nav-link>
            
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                {{ __('Gebruikers') }}
            </x-nav-link>
            
            <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                {{ __('Nieuws') }}
            </x-nav-link>
        @endif
    @endauth
</div>

<!-- Dans la navigation responsive (vers ligne 40) -->
<div class="pt-2 pb-3 space-y-1">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-responsive-nav-link>
    
    <x-responsive-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.show')">
        {{ __('Contact') }}
    </x-responsive-nav-link>
    
    @auth
        @if(auth()->user()->is_admin)
            <x-responsive-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.*')">
                {{ __('Berichten') }}
                @php
                    $unreadCount = \App\Models\Contact::unread()->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="ml-1 px-1.5 py-0.5 bg-red-600 text-white text-xs rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                {{ __('Gebruikers') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                {{ __('Nieuws') }}
            </x-responsive-nav-link>
        @endif
    @endauth
</div>