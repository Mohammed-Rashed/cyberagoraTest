<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval Request') }} #{{ $approvalRequest->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @error('approval')
                        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
                            {{ $message }}
                        </div>
                    @enderror

                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Form') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $approvalRequest->form?->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Requested By') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $approvalRequest->requester?->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Current Step') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $approvalRequest->current_step_order }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Submitted') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $approvalRequest->submitted_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Submitted Values') }}</h3>

                    <div class="mt-4 divide-y divide-gray-200">
                        @foreach ($approvalRequest->values as $value)
                            <div class="py-3">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ $value->formField?->label }}
                                </div>
                                <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                    {{ filled($value->value) ? $value->value : '-' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form class="p-6 space-y-4">
                    <div>
                        <x-input-label for="comment" :value="__('Comment')" />
                        <textarea
                            id="comment"
                            wire:model="comment"
                            rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        ></textarea>
                        <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('approvals.pending') }}"
                            wire:navigate
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('Cancel') }}
                        </a>

                        <button
                            type="button"
                            wire:click="reject"
                            wire:confirm="Reject this request?"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500"
                        >
                            {{ __('Reject') }}
                        </button>

                        <button
                            type="button"
                            wire:click="approve"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500"
                        >
                            {{ __('Approve') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
