<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\Recipe;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RecipesImport;

new class extends Component {
    use WithFileUploads;

    public $pdf;

    #[On('upload-recipe-pdf')] 
    public function loadModalData() {

        $this->dispatch('open-modal', 'upload-recipe');
    }

    public function saveRecipe(){
        $validated = $this->validate([
            'pdf' => 'required|file|mimes:xlsx,csv|max:10240',
        ]);

        Excel::import(new RecipesImport, $validated['pdf']);

        return redirect()->route('dashboard')->with('success', 'Recipes successfully added!');
    }
}; ?>

<x-modal name="upload-recipe" :show="false" focusable>
    <form wire:submit="saveRecipe" class="p-6">

        <div class="flex items-center justify-center w-full">
            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 bg-gray-50 border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-gray-10">
                <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2"/>
                    </svg>
                    
                    <p class="mb-2 text-sm">
                        @if($pdf)
                            <span class="font-semibold text-green-700">
                                {{ $pdf->getClientOriginalName() }}
                            </span>
                        @else
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        @endif
                    </p>

                    <p class="text-xs text-gray-500">XSLX & CSV only (Max 10 MB)</p>
                </div>

                <input wire:model="pdf" id="dropzone-file" type="file" class="hidden" accept=".xlsx,.xls,.csv" />
                
                <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
            </label>
        </div> 

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ms-3"
                wire:loading.attr="disabled" 
                wire:target="saveRecipe">
                
                <span wire:loading.remove wire:target="saveRecipe">
                    Submit
                </span>

                <!-- loading -->
                <span wire:loading wire:target="saveRecipe" class="flex items-center justify-between gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Saving...
                </span>
            </x-primary-button>
        </div>
    </form>
</x-modal>
