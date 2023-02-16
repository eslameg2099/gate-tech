@component('dashboard::components.table-box')
    @slot('title', $title)
    <thead>
    <tr>
        <th>@lang('البيان')</th>
        <th>@lang('الفاتورة')</th>
        <th>@lang('التاريخ')</th>
        @foreach(\App\Models\Service::all() as $service)
            <th>{{ $service->name }}</th>
        @endforeach
        <th>@lang('الاجمالي')</th>
        <th>@lang('الرصيد')</th>
    </tr>
    </thead>
    <tbody>
    @forelse($transactions as $transaction)
        <tr class="{{ $transaction->amount > 0 ? 'tw-bg-yellow-200' : '' }}">
            <td>
                {{ $transaction->reason ?: '---' }}
            </td>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->date->toDateString() }}</td>
            @foreach(\App\Models\Service::all() as $service)
                <td>
                    @if($transaction->service_id == $service->id)
                        @include('dashboard.transactions.flags.price', [
                            'amount' => $transaction->amount
                        ])
                    @endif
                </td>
            @endforeach
            <td>
                @include('dashboard.transactions.flags.price', ['amount' => $transaction->amount])
            </td>
            <td>
                @include('dashboard.transactions.flags.price', ['amount' => $transaction->balance])
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('transactions.empty')</td>
        </tr>
    @endforelse
    <tr class="tw-bg-green-200">
        <td>{{ __('المجموع') }}</td>
        <td></td>
        <td></td>
        @foreach(\App\Models\Service::all() as $service)
            <td>
                @if($total = $transactions->where('service_id', $service->id)->sum('amount'))
                    @include('dashboard.transactions.flags.price', [
                        'amount' => $total
                    ])
                @endif
            </td>
        @endforeach
        <td></td>
        <td></td>
    </tr>

@endcomponent