<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Workflow') }}: {{ $form->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form wire:submit="save" class="p-6 space-y-6">
                    @if ($approvers->isEmpty())
                        <div class="rounded-md bg-yellow-50 p-4 text-sm text-yellow-800">
                            {{ __('No approver users found. Add approver users before building a workflow.') }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Approval Steps') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Requests move through these approvers in order.') }}
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="addStep"
                            class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"
                        >
                            {{ __('Add Step') }}
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($steps as $index => $step)
                            <div class="rounded-md border border-gray-200 p-4">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="text-sm font-medium text-gray-700">
                                        {{ __('Step') }} {{ $index + 1 }}
                                    </div>

                                    @if (count($steps) > 1)
                                        <button
                                            type="button"
                                            wire:click="removeStep({{ $index }})"
                                            class="text-sm font-medium text-red-600 hover:text-red-800"
                                        >
                                            {{ __('Remove') }}
                                        </button>
                                    @endif
                                </div>

                                <div>
                                    <x-input-label for="steps-{{ $index }}-approver" :value="__('Approver')" />
                                    <select
                                        id="steps-{{ $index }}-approver"
                                        wire:model="steps.{{ $index }}.approver_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    >
                                        <option value="">{{ __('Select approver') }}</option>
                                        @foreach ($approvers as $approver)
                                            <option value="{{ $approver->id }}">
                                                {{ $approver->name }} ({{ $approver->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('steps.'.$index.'.approver_id')" class="mt-2" />
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('steps')" class="mt-2" />

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('admin.forms.index') }}"
                            wire:navigate
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <x-primary-button>
                            {{ __('Save Workflow') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
