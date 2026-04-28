<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Pending Approvals') }}</div>
                <div class="mt-2 text-3xl font-semibold text-yellow-700">{{ $stats['pendingRequests'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Total Decisions') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['totalActions'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Approved') }}</div>
                <div class="mt-2 text-3xl font-semibold text-green-700">{{ $stats['approvedActions'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Rejected') }}</div>
                <div class="mt-2 text-3xl font-semibold text-red-700">{{ $stats['rejectedActions'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Latest Decisions') }}</h3>

            @if ($stats['latestActions']->isEmpty())
                <p class="mt-4 text-sm text-gray-600">{{ __('No approval decisions yet.') }}</p>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acted At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($stats['latestActions'] as $action)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $action->approvalRequest?->form?->name ?? __('Deleted form') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $action->approvalRequest?->requester?->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $action->action->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $action->acted_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
