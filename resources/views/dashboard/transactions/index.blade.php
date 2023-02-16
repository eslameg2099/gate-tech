<x-layout :title="trans('transactions.plural')" :breadcrumbs="['dashboard.transactions.index']">
        @include('dashboard.transactions.partials.filter')
    @component('dashboard::components.table-box')
        @slot('title')
            @lang('transactions.actions.list') ({{ $transactions->total() }})
        @endslot

        <thead>
        <tr>
            <th>@lang('transactions.attributes.reason')</th>
            <th>@lang('transactions.attributes.payment_method')</th>
            <th>@lang('transactions.attributes.wallet_id')</th>
            <th>@lang('transactions.attributes.amount')</th>
            <th>@lang('transactions.attributes.balance')</th>
            <th>@lang('transactions.attributes.date')</th>
            <th>@lang('transactions.attributes.created_at')</th>
            <th style="width: 50px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($transactions as $transaction)
            <tr>
                <td>
                    <a href="{{ route('dashboard.transactions.show', $transaction) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $transaction->reason ?: '---' }}
                    </a>
                </td>
                <td>{{ __('transactions.payment_methods.'.$transaction->payment_method) }}</td>
                <td>{{ $transaction->wallet->name }}</td>
                <td>
                    @include('dashboard.transactions.flags.price', ['amount' => $transaction->amount])
                </td>
                <td>
                    {{ price($transaction->balance) }}
                </td>
                <td>
                    <bdi>{{ $transaction->date->format('Y-d-m h:i A') }}</bdi>
                </td>
                <td>
                    <bdi>{{ $transaction->created_at->format('Y-d-m h:i A') }}</bdi>
                </td>

                <td>
                    @include('dashboard.transactions.partials.actions.show')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('transactions.empty')</td>
            </tr>
        @endforelse

        @if($transactions->hasPages())
            @slot('footer')
                {{ $transactions->links() }}
            @endslot
        @endif
        @endcomponent
</x-layout>
