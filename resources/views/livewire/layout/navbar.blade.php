<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="fixed top-12 lg:top-0 left-0 w-full lg:w-[calc(100%-16rem)] lg:ml-64 z-10 flex justify-between items-center gap-4 bg-white px-6 py-3 shadow-sm border-b">

    <!-- SEARCH -->
    <div class="max-w-md flex-1">
        <livewire:dashboard.recipe-search />
    </div>

    <!-- RIGHT SIDE -->
    <div class="flex items-center gap-4">

        <!-- Notifications -->
        <livewire:dashboard.notification />

        <!-- User Profile Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            <x-dropdown align="right" width="48">
                
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-600 focus:outline-none transition ease-in-out duration-150">
                        <div class="capitalize">{{ auth()->user()->name }}</div>

                        <div class="ms-1">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile')" wire:navigate>
                        Settings
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-dropdown-link class="text-red-500 hover:bg-red-100 hover:text-red-600">
                            {{ __('Logout') }}
                        </x-dropdown-link>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>
       

    </div>

</nav>