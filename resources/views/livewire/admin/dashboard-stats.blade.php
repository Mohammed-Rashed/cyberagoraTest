<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Forms') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['totalForms'] }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ $stats['activeForms'] }} {{ __('active') }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Users') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['totalUsers'] }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ $stats['activeUsers'] }} {{ __('active') }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Approvers') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['totalApprovers'] }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ $stats['activeApprovers'] }} {{ __('active') }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="text-sm font-medium text-gray-500">{{ __('Approval Actions') }}</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['approvalActions'] }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ __('total decisions') }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Approval Requests') }}</h3>

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
</div>
