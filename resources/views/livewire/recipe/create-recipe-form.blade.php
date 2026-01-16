<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Recipe;

new class extends Component {
    use WithFileUploads;

    public string $title = '';
    public string $category = 'breakfast';
    public array $ingredients = [''];
    public array $instructions = [''];
    public int $cooking_time = 0;
    public string $description = '';
    public $image;

    public function addIngredient()
    {
        $this->ingredients[] = '';
    }

    public function removeIngredient($index)
    {
        unset($this->ingredients[$index]);

        $this->ingredients = array_values($this->ingredients);
    }

    public function addInstruction()
    {
        $this->instructions[] = '';
    }

    public function removeInstruction($index)
    {
        unset($this->instructions[$index]);

        $this->instructions = array_values($this->instructions);
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:breakfast,lunch,dinner',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'instructions' => 'required|array|min:1', //validate the array
            'instructions.*' => 'required|string', //validat inside the array
            'cooking_time' => 'required|integer|min:1|max:4320',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('recipes', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['rating'] = 0;
        
        Recipe::create($validated);

        return redirect()->route('dashboard')->with('success', 'Recipe created successfully!');
    }

}; ?>

<div class="max-w-7xl p-4 sm:p-6 lg:p-8 bg-white shadow sm:rounded-lg">

    <form wire:submit="save" class="space-y-6">

        {{-- image + title --}}
        <div class="flex flex-col md:flex-row gap-6 items-start">
            
            {{-- image --}}
            <div class="w-full md:w-40">
                <x-input-label for="image" :value="__('Image')" />
                <input type="file" wire:model="image" class="mt-1 block w-full text-sm text-gray-500 border rounded-md py-2 px-1">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                @else
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png" class="mt-2 w-full h-32 object-cover rounded">
                @endif
            </div>
        
            <!-- Title -->
            <div class="flex-1 space-y-4">
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                
                </div>

                <div>
                     <x-input-label for="description" :value="__('Description')" />
                    <textarea wire:model="description" id="description" rows="3"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="description" required autofocus></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Ingredients -->
        <div>
            <x-input-label for="ingredients" :value="__('Ingredients')" />

            @foreach ($ingredients as $index => $ingredient)
                <div class="flex items-center gap-2 mb-2">
                    <x-text-input wire:model="ingredients.{{ $index }}" id="ingredients.{{ $index }}" class="block mt-1 w-full" type="text" name="ingredients.{{ $index }}" required autofocus />
                    <button type="button" wire:click="removeIngredient({{ $index }})"
                        class="bg-red-500 text-white p-2 rounded hover:bg-red-600">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>
            @endforeach

            <div class="flex justify-center mt-2">
                <x-secondary-button type="button" wire:click="addIngredient">
                    + Add Ingredient
                </x-secondary-button>
            </div>
        </div>

        <!-- Instruction -->
        <div>
            <x-input-label for="instruction" :value="__('Instructions')" />

            @foreach ($instructions as $index => $instruction)
                <div class="flex items-center gap-2 mb-2">
                    <x-text-input wire:model="instructions.{{ $index }}" id="instructions.{{ $index }}" class="block mt-1 w-full" type="text" name="instructions.{{ $index }}" required autofocus />
                    <button type="button" wire:click="removeInstruction({{ $index }})"
                        class="bg-red-500 text-white p-2 rounded hover:bg-red-600">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>
            @endforeach

            <div class="flex justify-center mt-2">
                <x-secondary-button type="button" wire:click="addInstruction">
                    + Add Step
                </x-secondary-button>
            </div>
            
        </div>

        <!-- Cooking Time & Category side by side -->
        <div class="flex flex-col md:flex-row gap-6">
            
            <!-- Cooking Time -->
            <div class="flex-1">
                <x-input-label for="cooking_time" :value="__('Cooking Time (minutes)')" />
                <x-text-input wire:model="cooking_time" id="cooking_time" class="block mt-1 w-full" type="number" name="cooking_time" required autofocus />
                <x-input-error :messages="$errors->get('cooking_time')" class="mt-2" />
            </div>

            <!-- Category -->
            <div class="flex-1">
                <x-input-label for="category" :value="__('Category')" />
                <select wire:model="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>
        </div>

        <div class="flex gap-4">
            {{-- wire:target="methodName" -> Only triggers loading for a specific action, like save() --}}
            {{-- wire:loading.attr="disabled" -> Adds a disabled attribute while Livewire is running --}}
            <x-primary-button 
                wire:loading.attr="disabled" 
                wire:target="save"
                class="w-full md:w-auto relative"
            >
                <!-- Default text -->
                {{-- wire:loading.remove -> Hides the element while a Livewire request is running --}}
                <span wire:loading.remove wire:target="save">
                    Save Recipe
                </span>

                <!-- Loading text -->
                {{-- wire:loading -> Shows the element only while a Livewire request is running --}}
                <span wire:loading wire:target="save" class="flex items-center justify-between gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Saving...
                </span>
            </x-primary-button>

            <x-secondary-button wire:navigate href="{{ route('dashboard') }}">
                Cancel
            </x-secondary-button>
        </div>
       
    </form>

</div>
