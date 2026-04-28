<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $form ? __('Edit Form') : __('Create Form') }}
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

                    <div class="border-t border-gray-200 pt-6">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Fields') }}</h3>

                            <button
                                type="button"
                                wire:click="addField"
                                class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"
                            >
                                {{ __('Add Field') }}
                            </button>
                        </div>

                        <div class="space-y-4">
                            @foreach ($fields as $index => $field)
                                <div class="rounded-md border border-gray-200 p-4">
                                    <div class="mb-4 flex items-center justify-between">
                                        <div class="text-sm font-medium text-gray-700">
                                            {{ __('Field') }} {{ $index + 1 }}
                                        </div>

                                        @if (count($fields) > 1)
                                            <button
                                                type="button"
                                                wire:click="removeField({{ $index }})"
                                                class="text-sm font-medium text-red-600 hover:text-red-800"
                                            >
                                                {{ __('Remove') }}
                                            </button>
                                        @endif
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <x-input-label for="fields-{{ $index }}-label" :value="__('Label')" />
                                            <x-text-input
                                                id="fields-{{ $index }}-label"
                                                wire:model="fields.{{ $index }}.label"
                                                type="text"
                                                class="mt-1 block w-full"
                                            />
                                            <x-input-error :messages="$errors->get('fields.'.$index.'.label')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="fields-{{ $index }}-name" :value="__('Name')" />
                                            <x-text-input
                                                id="fields-{{ $index }}-name"
                                                wire:model="fields.{{ $index }}.name"
                                                type="text"
                                                class="mt-1 block w-full"
                                                placeholder="employee_name"
                                            />
                                            <x-input-error :messages="$errors->get('fields.'.$index.'.name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="fields-{{ $index }}-type" :value="__('Type')" />
                                            <select
                                                id="fields-{{ $index }}-type"
                                                wire:model.live="fields.{{ $index }}.type"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            >
                                                @foreach ($fieldTypes as $fieldType)
                                                    <option value="{{ $fieldType->value }}">
                                                        {{ $fieldType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('fields.'.$index.'.type')" class="mt-2" />
                                        </div>

                                        <label class="flex items-center gap-2 sm:pt-7">
                                            <input
                                                type="checkbox"
                                                wire:model="fields.{{ $index }}.is_required"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            >
                                            <span class="text-sm text-gray-700">{{ __('Required') }}</span>
                                        </label>
                                    </div>

                                    @if ((int) $field['type'] === \App\Enums\FormFieldType::Select->value)
                                        <div class="mt-4">
                                            <x-input-label for="fields-{{ $index }}-options" :value="__('Options')" />
                                            <x-text-input
                                                id="fields-{{ $index }}-options"
                                                wire:model="fields.{{ $index }}.options"
                                                type="text"
                                                class="mt-1 block w-full"
                                                placeholder="Option 1, Option 2, Option 3"
                                            />
                                            <x-input-error :messages="$errors->get('fields.'.$index.'.options')" class="mt-2" />
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('fields')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('admin.forms.index') }}"
                            wire:navigate
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <x-primary-button>
                            {{ $form ? __('Update') : __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
