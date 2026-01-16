<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $showDropdown = false;

    public function getMyNotificationsProperty()
    {
        return auth()->user()->unreadNotifications;
    }

    public function setDropdown()
    {
        if($this->showDropdown)
            $this->showDropdown = false;
        else
            $this->showDropdown = true;
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}; ?>

<div class="flex items-center relative">
    <!-- notification icon -->
    <button wire:click="setDropdown" class="text-gray-600 hover:text-indigo-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>

        <!-- Badge -->
        @if($this->myNotifications->count() > 0)
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full ring-1 ring-white"></span>
        @endif
    </button>

    <!-- Dropdown -->
    @if($showDropdown)
        <div class="absolute z-10 mt-8 top-0 right-0 w-64 md:w-96 rounded-lg border bg-white shadow">
            <!-- Arrow -->
            <div class="absolute -z-10 -top-1 right-2 w-2 h-2 bg-white border-t border-l rotate-45"></div>

           <!-- Results -->
            @forelse($this->myNotifications as $notif)
                <div class="flex items-center justify-between px-4 py-2 hover:bg-gray-100">
                    <div class="w-full">
                        <div class="flex justify-between">
                             <!-- Title -->
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $notif->data['recipe_title'] }}
                            </p>

                            <!-- created at -->
                            <p class="text-gray-500 text-xs capitalize">
                                {{ $notif->created_at->format('d M Y h:i') }}
                            </p>
                        </div>

                        <!-- message -->
                        <p class="mt-1 text-xs text-gray-500 line-clamp-2">
                            {{ $notif->data['message'] }}
                        </p>
                    </div>
                </div>

            @empty
                <!-- No Data -->
                <div class="px-4 py-3 text-sm text-gray-500 text-center">
                    No notification found
                </div>
            @endforelse

            @if($this->myNotifications->count() > 0)
                <!-- Mark as read -->
                <div class="mt-6 mb-3 flex justify-center">
                    <button wire:click="markAllAsRead" 
                        class="text-indigo-600 hover:text-indigo-700 text-xs uppercase font-semibold transition inline-flex gap-2 cursor-pointer">
                        Mark As Read
                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>

                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
