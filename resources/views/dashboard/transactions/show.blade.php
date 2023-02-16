<x-layout :title="'#'.$transaction->id" :breadcrumbs="['dashboard.transactions.show', $transaction]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')
                <div>
                    <table class="table table-striped table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('transactions.attributes.id')</th>
                            <td>{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('transactions.attributes.created_at')</th>
                            <td>
                                <bdi>{{ $transaction->created_at->format('Y-m-d h:i A') }}</bdi>
                            </td>
                        </tr>
                        <tr>
                            <th width="200">@lang('transactions.attributes.date')</th>
                            <td>
                                <bdi>{{ $transaction->date->format('Y-m-d h:i A') }}</bdi>
                            </td>
                        </tr>
                        <tr>
                            <th width="200">@lang('transactions.attributes.amount')</th>
                            <td>
                                @include('dashboard.transactions.flags.price', ['amount' => $transaction->amount])
                            </td>
                        </tr>
                        <tr>
                            <th width="200">@lang('transactions.attributes.payment_method')</th>
                            <td>{{ __('transactions.payment_methods.'.$transaction->payment_method) }}</td>
                        </tr>
                        @if($transaction->check_number)
                            <tr>
                                <th width="200">@lang('transactions.attributes.check_number')</th>
                                <td>{{ $transaction->check_number ?: '---' }}</td>
                            </tr>
                        @endif
                        @if($transaction->reason)
                            <tr>
                                <th width="200">@lang('transactions.attributes.reason')</th>
                                <td>{{ $transaction->reason ?: '---' }}</td>
                            </tr>
                        @endif
                        @if($transaction->service)
                            <tr>
                                <th width="200">@lang('transactions.attributes.service_id')</th>
                                <td>{{ $transaction->service->name }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th width="200">
                                @if($transaction->amount > 0)
                                    @lang('transactions.attributes.credit_to')
                                @else
                                    @lang('transactions.attributes.debit_from')
                                @endif
                            </th>
                            <td>{{ __('رصيد') }} {{ $transaction->wallet->model->name ?? __('شركة الادارة') }}</td>
                        </tr>
                        {{--                        <tr>--}}
                        {{--                            <th width="200">@lang('transactions.attributes.notes')</th>--}}
                        {{--                            <td>{{ $transaction->notes ?: '---' }}</td>--}}
                        {{--                        </tr>--}}
                        <tr class="hide_in_print">
                            <th width="200">@lang('transactions.attributes.actor_id')</th>
                            <td>@include('dashboard.accounts.admins.partials.actions.link', ['admin' => $transaction->actor])</td>
                        </tr>
                        @if($transaction->getFirstMediaUrl())
                            <tr class="hide_in_print">
                                <th width="200">@lang('transactions.attributes.check_image')</th>
                                <td>
                                    <img src="{{ $transaction->getFirstMediaUrl() }}" style="width: 300px;" alt="">
                                </td>
                            </tr>
                        @endif
                        @if($transaction->model)
                            <tr>
                                <th width="200">@lang('buildings.singular')</th>
                                <td>{{ $transaction->model->apartment->building->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('apartments.attributes.number')</th>
                                <td>{{ $transaction->model->apartment->number }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('apartments.attributes.tenant')</th>
                                <td>{{ $transaction->model->tenant->name }}</td>
                            </tr>
                            @if($transaction->details()->has('installment')->get()->count())
                                <tr>
                                    <th width="200">@lang('transactions.details')</th>
                                    <td>
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th>@lang('تاريخ الاستحقاق')</th>
                                                <th>@lang('installments.attributes.paid_amount')</th>
                                                <th>@lang('المبلغ المتبقي')</th>
                                            </tr>
                                            @foreach($transaction->details()->has('installment')->get() as $transactionDetail)
                                                <tr>
                                                    <td>
                                                        {{ $transactionDetail->installment->date->format('M Y') }}
                                                    </td>
                                                    <td>{{ price($transactionDetail->amount) }} <br>
                                                        ({{ price_string($transactionDetail->amount) }})
                                                    </td>

                                                    <td>
                                                        @if($transactionDetail->installment->remaining_amount)
                                                            {{ price($transactionDetail->installment->remaining_amount, 0) }}
                                                            <br>
                                                            ({{ price_string($transactionDetail->installment->remaining_amount) }}
                                                            )
                                                        @else
                                                            {{ __('لا يوجد') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>


                    <div class="invoice-container print only_in_print text-left" dir="rtl">
                        @if($transaction->amount > 0)
                            <h4 class="text-center">{{ __('transactions.catch_receipt') }}</h4>
                        @else
                            <h4 class="text-center">{{ __('transactions.debit_receipt') }}</h4>
                        @endif
                        <div class="row form-group">
                            <div class="col">
                                {{ __('transactions.attributes.id') }}:
                                #{{ $transaction->id }}
                            </div>
                            <div class="col">
                                {{ __('transactions.attributes.date') }}:
                                <bdi>{{ $transaction->date->format('Y-m-d h:i A') }}</bdi>
                            </div>
                        </div>
                        @if($transaction->model)
                            <div class="row form-group">
                                <div class="col">
                                    {{ __('buildings.singular') }}: {{ $transaction->model->apartment->building->name }}
                                </div>
                                <div class="col">
                                    {{ __('apartments.attributes.number') }}
                                    : {{ $transaction->model->apartment->number }}
                                </div>
                            </div>
                            @if($transaction->model->lastPartiallyOrPaidInstallment)
                                <div class="row form-group">
                                    <div class="col">
                                        {{ __('apartments.attributes.tenant') }}
                                        : {{ $transaction->model->tenant->name }}
                                    </div>
                                    <div class="col">
                                        {{ __('installments.attributes.status') }}
                                        : {{ $transaction->model->lastPartiallyOrPaidInstallment->getStatusMessage() }}
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="row form-group">
                            <div class="col">
                                {{ __('transactions.attributes.amount') }}: {{ price($transaction->amount) }}
                                ({{ price_string($transaction->amount) }})
                            </div>
                            <div class="col">
                                {{ __('transactions.attributes.payment_method') }}
                                : {{ __('transactions.payment_methods.'.$transaction->payment_method) }}
                            </div>
                        </div>
                        <div class="row form-group">
                            @if($transaction->reason)
                                <div class="col">
                                    {{ __('transactions.attributes.reason') }}: {{ $transaction->reason }}
                                </div>
                            @endif
                            @if($transaction->notes)
                                <div class="col">
                                    {{ __('transactions.attributes.notes') }}: {{ $transaction->notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @slot('footer')
                    <a href="#" class="btn btn-outline-primary print-trigger">
                        <i class="fas fa fa-fw fa-print"></i> {{ __('طباعة') }}
                    </a>
                @endslot
            @endcomponent
        </div>
    </div>
    @push('styles')
        <style>
            .invoice-container {
                border: 1px solid #eee;
                padding: 10px;
                margin: 10px;
            }
        </style>
    @endpush
    @push('scripts')
        @push('scripts')
            <script>
              $(document).on('click', '.print-trigger', (e) => {
                e.preventDefault();
                $(".print").printThis()
              })
            </script>
        @endpush
    @endpush
</x-layout>