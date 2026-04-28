<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit') }}: {{ $form->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form wire:submit="submit" class="p-6 space-y-6">
                    @error('form')
                        <div class="rounded-md bg-red-50 p-4 text-sm text-red-800">
                            {{ $message }}
                        </div>
                    @enderror

                    @foreach ($form->fields as $field)
                        <div>
                            <x-input-label for="field-{{ $field->id }}">
                                {{ $field->label }}
                                @if ($field->is_required)
                                    <span class="text-red-600">*</span>
                                @endif
                            </x-input-label>

                            @if ($field->type === \App\Enums\FormFieldType::Textarea)
                                <textarea
                                    id="field-{{ $field->id }}"
                                    wire:model="values.{{ $field->id }}"
                                    rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                ></textarea>
                            @elseif ($field->type === \App\Enums\FormFieldType::Select)
                                <select
                                    id="field-{{ $field->id }}"
                                    wire:model="values.{{ $field->id }}"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">{{ __('Select option') }}</option>
                                    @foreach ($field->options ?? [] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @else
                                <x-text-input
                                    id="field-{{ $field->id }}"
                                    wire:model="values.{{ $field->id }}"
                                    type="{{ $field->type === \App\Enums\FormFieldType::Date ? 'date' : ($field->type === \App\Enums\FormFieldType::Number ? 'number' : 'text') }}"
                                    class="mt-1 block w-full"
                                />
                            @endif

                            <x-input-error :messages="$errors->get('values.'.$field->id)" class="mt-2" />
                        </div>
                    @endforeach

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('forms.index') }}"
                            wire:navigate
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <x-primary-button>
                            {{ __('Submit Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
