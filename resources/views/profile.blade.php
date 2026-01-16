<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>

            <p class="text-gray-500 mt-1 text-sm">
                Manage your account, view your favorite recipes, and keep track of your cooking adventures.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <livewire:profile.update-profile-information-form />

        <livewire:profile.update-password-form />
        
        <livewire:profile.delete-user-form />
    </div>
</x-app-layout>
