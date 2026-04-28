<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Forms') }}
            </h2>

            <a
                href="{{ route('admin.forms.create') }}"
                wire:navigate
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
            >
                {{ __('Create Form') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($forms->isEmpty())
                        <p class="text-sm text-gray-600">
                            {{ __('No forms created yet.') }}
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fields</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Workflow Steps</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($forms as $form)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-900">{{ $form->name }}</div>
                                                @if ($form->description)
                                                    <div class="text-sm text-gray-500">{{ $form->description }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm {{ $form->is_active ? 'text-green-700' : 'text-gray-500' }}">
                                                    {{ $form->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $form->fields_count }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $form->workflow_steps_count }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $form->created_at?->format('Y-m-d') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a
                                                    href="{{ route('admin.forms.edit', $form) }}"
                                                    wire:navigate
                                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-900"
                                                >
                                                    {{ __('Edit') }}
                                                </a>
                                                <a
                                                    href="{{ route('admin.forms.workflow', $form) }}"
                                                    wire:navigate
                                                    class="ms-3 text-sm font-medium text-indigo-600 hover:text-indigo-900"
                                                >
                                                    {{ __('Workflow') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $forms->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
