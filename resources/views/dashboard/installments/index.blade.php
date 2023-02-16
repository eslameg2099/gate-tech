<?php /** @var \App\Models\Installment[]|\Illuminate\Pagination\LengthAwarePaginator $installments */ ?>
<?php /** @var \App\Models\Installment $installment */ ?>
@component('dashboard::components.table-box')
    @slot('title')
        @lang('installments.plural') ({{ $installments->count() }})
    @endslot

    <thead>
    <tr>
        <th>@lang('installments.attributes.date')</th>
        <th>@lang('installments.attributes.amount')</th>
        <th>@lang('installments.attributes.paid_amount')</th>
        <th>...</th>
    </tr>
    </thead>
    <tbody>
    @forelse($installments as $installment)
        <tr class="{{ $installment->isPaid() ? 'tw-bg-green-200' : ($installment->isPartiallyPaid() ? 'tw-bg-orange-200' : '') }}">
            <td>
                {{ $installment->date->format('Y-m-d') }}
            </td>
            <td>{{ price($installment->amount) }}</td>
            <td>{{ price($installment->paid_amount) }}</td>
            <td>
                @if(! $installment->isUnpaid())
                    <a href="{{ route('dashboard.transactions.show', $installment->transactionDetail->transaction) }}"
                       class="btn btn-outline-dark btn-sm">
                        <i class="fas fa fa-fw fa-eye"></i>
                    </a>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('installments.empty')</td>
        </tr>
    @endforelse
@endcomponent
