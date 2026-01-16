<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <header class="bg-white shadow-sm fixed top-0 left-0 shadow-sm z-10 border-b w-full">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a wire:navigate href="{{ route('dashboard') }}"
                class="flex items-center space-x-2 text-2xl font-bold text-indigo-600">
                <x-application-logo class="h-9 w-auto fill-current text-gray-800" />
                <span>{{ config('app.name', 'Recipio') }}</span>
            </a>

            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-indigo-600 text-white mt-18">
        <div class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Discover, Save & Share Amazing Recipes
                </h2>
                <p class="text-lg mb-8 text-indigo-100">
                    Manage your favorite recipes, plan meals, and explore dishes from around the world.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="bg-white text-indigo-600 rounded-md font-semibold text-xs uppercase px-4 py-2 hover:bg-gray-100">
                        Explore Recipes
                    </a>
                    <a href="{{ route('register') }}"
                        class="border border-white rounded-md font-semibold text-xs uppercase px-4 py-2 hover:bg-indigo-700">
                        Create Account
                    </a>
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836" alt="Food"
                    class="rounded-xl shadow-lg" />
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="tutorial" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12">
                How {{ config('app.name') }} Works
            </h3>

            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="p-8">
                    <div class="text-4xl mb-4">👤</div>
                    <h4 class="text-xl font-semibold mb-2">Create an Account</h4>
                    <p class="text-gray-600">
                        Sign up in seconds and start your personal recipe collection.
                    </p>
                </div>

                <div class="p-8">
                    <div class="text-4xl mb-4">📖</div>
                    <h4 class="text-xl font-semibold mb-2">Save & Discover</h4>
                    <p class="text-gray-600">
                        Add your own recipes or explore dishes shared by others.
                    </p>
                </div>

                <div class="p-8">
                    <div class="text-4xl mb-4">🍽️</div>
                    <h4 class="text-xl font-semibold mb-2">Plan & Cook</h4>
                    <p class="text-gray-600">
                        Plan meals, stay organized, and enjoy stress-free cooking.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12">
                Why Choose {{ config('app.name') }}?
            </h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <h4 class="text-xl font-semibold mb-4">📚 Recipe Management</h4>
                    <p class="text-gray-600">
                        Add, edit, and organize all your recipes in one place.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <h4 class="text-xl font-semibold mb-4">📝 Meal Planning</h4>
                    <p class="text-gray-600">
                        Plan your weekly meals and generate shopping lists easily.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <h4 class="text-xl font-semibold mb-4">🌍 Discover Recipes</h4>
                    <p class="text-gray-600">
                        Explore recipes shared by chefs and home cooks worldwide.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Recipes -->
    <section id="recipes" class="bg-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12">
                Popular Recipes
            </h3>
            
            <livewire:recipe.popular-recipe />
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12">
                Frequently Asked Questions
            </h3>

            <div class="space-y-6">

                <div class="border rounded-lg p-6">
                    <h4 class="font-semibold text-lg mb-2">
                        Is {{ config('app.name') }} free to use?
                    </h4>
                    <p class="text-gray-600">
                        Yes! You can create an account and manage your recipes for free.
                        Premium features may be added later.
                    </p>
                </div>

                <div class="border rounded-lg p-6">
                    <h4 class="font-semibold text-lg mb-2">
                        Do I need to install anything?
                    </h4>
                    <p class="text-gray-600">
                        No installation required. {{ config('app.name') }} works directly in your browser
                        on desktop and mobile devices.
                    </p>
                </div>

                <div class="border rounded-lg p-6">
                    <h4 class="font-semibold text-lg mb-2">
                        Can I add my own recipes?
                    </h4>
                    <p class="text-gray-600">
                        Absolutely. You can create, edit, and organize your personal recipes
                        anytime.
                    </p>
                </div>

                <div class="border rounded-lg p-6">
                    <h4 class="font-semibold text-lg mb-2">
                        Is my data safe?
                    </h4>
                    <p class="text-gray-600">
                        Yes. Your recipes are private by default and securely stored.
                    </p>
                </div>

                <div class="border rounded-lg p-6">
                    <h4 class="font-semibold text-lg mb-2">
                        Who is {{ config('app.name') }} for?
                    </h4>
                    <p class="text-gray-600">
                        {{ config('app.name') }} is perfect for home cooks, food enthusiasts,
                        and anyone who wants to stay organized in the kitchen.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-indigo-600 text-white text-center">
        <h3 class="text-3xl font-bold mb-6">
            Start Cooking Smarter Today
        </h3>
        <p class="mb-8 text-indigo-100">
            Join thousands of food lovers using {{ config('app.name') }} daily.
        </p>
        <a href="{{ route('register') }}"
            class="bg-white text-indigo-600 rounded-md font-semibold text-xs uppercase px-4 py-2 hover:bg-gray-100">
            Join Now
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>© 2025 {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
