<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Forms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($forms->isEmpty())
                        <p class="text-sm text-gray-600">
                            {{ __('No active forms are available right now.') }}
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fields</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Workflow Steps</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
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
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $form->fields_count }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $form->workflow_steps_count }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <span class="text-sm text-gray-500">
                                                    {{ __('Submit page coming next') }}
                                                </span>
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
