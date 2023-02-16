@component('dashboard::components.table-box')
    @slot('title', $title)
    <thead>
    <tr>
        <th>@lang('رقم الوحدة')</th>
        <th>@lang('اسم المستأجر')</th>
        <th>@lang('البيان')</th>
        <th>@lang('المبلغ')</th>
        <th>@lang('نقدً/شيكات')</th>
        <th>@lang('تاريخ الايداع')</th>
        <th>@lang('ملاحظات')</th>
    </tr>
    </thead>
    <tbody>
    @forelse($transactions as $transaction)
        <tr>
            <td>{{ $transaction->model->apartment_id }}</td>
            <td>{{ $transaction->model->tenant->name ?? '---' }}</td>
            <td>{{ $transaction->reason ?: '---' }}</td>
            <td>
                @include('dashboard.transactions.flags.price', ['amount' => $transaction->amount])
            </td>
            <td>{{ $transaction->payment_method == \App\Models\Transaction::CASH_MONEY ? __('نقداً') : $transaction->check_number }}</td>
            <td>{{ $transaction->date->toDateString() }}</td>
            <td>{{ $transaction->notes }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('transactions.empty')</td>
        </tr>
    @endforelse
    <tr class="tw-bg-green-200">
        <td colspan="3">{{ __('المجموع') }}</td>
        <td>
            @include('dashboard.transactions.flags.price', ['amount' => $transactions->sum('amount')])
        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

@endcomponent