<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form wire:submit="save" class="p-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input
                            id="name"
                            wire:model="name"
                            type="text"
                            class="mt-1 block w-full"
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea
                            id="description"
                            wire:model="description"
                            rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        ></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        >
                        <span class="text-sm text-gray-700">{{ __('Active') }}</span>
                    </label>
                    <x-input-error :messages="$errors->get('is_active')" class="mt-2" />

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('admin.forms.index') }}"
                            wire:navigate
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
