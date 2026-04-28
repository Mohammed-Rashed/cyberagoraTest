<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($actions->isEmpty())
                        <p class="text-sm text-gray-600">
                            {{ __('You have not approved or rejected any requests yet.') }}
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested By</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acted At</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($actions as $action)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-900">
                                                    {{ $action->approvalRequest?->form?->name ?? __('Deleted form') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $action->approvalRequest?->requester?->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <span @class([
                                                    'font-medium',
                                                    'text-green-700' => $action->action === \App\Enums\ApprovalActionType::Approved,
                                                    'text-red-700' => $action->action === \App\Enums\ApprovalActionType::Rejected,
                                                ])>
                                                    {{ $action->action->name }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ filled($action->comment) ? $action->comment : '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $action->acted_at?->format('Y-m-d H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $actions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
