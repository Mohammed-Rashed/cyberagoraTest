<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Approvals') }}
        </h2>
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

                    @if ($approvalRequests->isEmpty())
                        <p class="text-sm text-gray-600">
                            {{ __('There are no pending approvals assigned to you.') }}
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested By</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Step</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($approvalRequests as $approvalRequest)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-900">
                                                    {{ $approvalRequest->form?->name ?? __('Deleted form') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $approvalRequest->requester?->name }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $approvalRequest->current_step_order }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $approvalRequest->submitted_at?->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a
                                                    href="{{ route('approvals.show', $approvalRequest) }}"
                                                    wire:navigate
                                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-900"
                                                >
                                                    {{ __('Review') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $approvalRequests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
