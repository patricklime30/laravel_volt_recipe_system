<nav class="-mx-3 flex items-center justify-end space-x-8">
    <a href="#tutorial" class="hover:text-indigo-600">Tutorial</a>

    <a href="#features" class="hover:text-indigo-600">Features</a>
    
    <a href="#recipes" class="hover:text-indigo-600">Recipes</a>

    <a href="#faq" class="hover:text-indigo-600">FAQ</a>

    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="bg-indigo-600 text-white rounded-md font-semibold text-xs uppercase px-4 py-2 hover:bg-indigo-700"
        >
            Dashboard
        </a>
    @else

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="bg-indigo-600 text-white rounded-md font-semibold text-xs uppercase px-4 py-2 hover:bg-indigo-700"
            >
                Get Started
            </a>
        @endif
    @endauth
</nav>
