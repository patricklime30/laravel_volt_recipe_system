<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                How to Use {{ config('app.name') }}?
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Learn how to actually use your recipe app: uploading recipes, saving favorites, commenting, rating, and managing your account.
            </p>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">

            <div class="space-y-6">

                <div class="border rounded-lg p-6 bg-white">
                    <h4 class="font-semibold text-lg mb-2">
                        How do I upload a recipe?
                    </h4>
                    <p class="text-gray-600">
                        Go to your dashboard and click “Create Recipe.” Fill in the recipe details, upload an image, 
                        and click “Submit” to share it with the community.
                    </p>
                </div>

                <div class="border rounded-lg p-6 bg-white">
                    <h4 class="font-semibold text-lg mb-2">
                        How can I save or favorite a recipe?
                    </h4>
                    <p class="text-gray-600">
                        Click the save icon on any recipe to add it to your favorites. 
                        You can view all saved recipes in your “Favorites menu.”
                    </p>
                </div>

                <div class="border rounded-lg p-6 bg-white">
                    <h4 class="font-semibold text-lg mb-2">
                       How do I comment on a recipe?
                    </h4>
                    <p class="text-gray-600">
                        Read the recipe and scroll to the comments section on a recipe detail page, 
                        type your comment in the input box, and click “Send”. 
                        You will see list of other users’ comments there.
                    </p>
                </div>

                <div class="border rounded-lg p-6 bg-white">
                    <h4 class="font-semibold text-lg mb-2">
                        How do I rate a recipe?
                    </h4>
                    <p class="text-gray-600">
                        Click the star icons on a recipe detail page to rate it from 1 to 5 stars. You can update your rating anytime.
                    </p>
                </div>

                <div class="border rounded-lg p-6 bg-white">
                    <h4 class="font-semibold text-lg mb-2">
                        How do I reset my password?
                    </h4>
                    <p class="text-gray-600">
                        Go to settings menu and scroll to “Update Password section”. Enter old password then your new password, and save the changes.
                    </p>
                </div>

            </div>
    </div>
</x-app-layout>