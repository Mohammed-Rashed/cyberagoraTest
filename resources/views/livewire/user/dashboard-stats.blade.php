<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Available Forms') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['availableForms'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('My Requests') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['totalRequests'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Pending') }}</div>
                <div class="mt-2 text-3xl font-semibold text-yellow-700">{{ $stats['pendingRequests'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Approved') }}</div>
                <div class="mt-2 text-3xl font-semibold text-green-700">{{ $stats['approvedRequests'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Request Summary') }}</h3>

            <div class="mt-4 grid gap-4 sm:grid-cols-4">
                <div class="rounded-md border border-gray-200 p-4">
                    <div class="text-sm font-medium text-gray-500">{{ __('Pending') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-yellow-700">{{ $stats['pendingRequests'] }}</div>
                </div>

                <div class="rounded-md border border-gray-200 p-4">
                    <div class="text-sm font-medium text-gray-500">{{ __('Approved') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-green-700">{{ $stats['approvedRequests'] }}</div>
                </div>

                <div class="rounded-md border border-gray-200 p-4">
                    <div class="text-sm font-medium text-gray-500">{{ __('Rejected') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-red-700">{{ $stats['rejectedRequests'] }}</div>
                </div>

                <div class="rounded-md border border-gray-200 p-4">
                    <div class="text-sm font-medium text-gray-500">{{ __('Withdrawn') }}</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-700">{{ $stats['withdrawnRequests'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Latest Requests') }}</h3>

            @if ($stats['latestRequests']->isEmpty())
                <p class="mt-4 text-sm text-gray-600">{{ __('No requests submitted yet.') }}</p>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($stats['latestRequests'] as $approvalRequest)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $approvalRequest->form?->name ?? __('Deleted form') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $approvalRequest->status->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $approvalRequest->submitted_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
