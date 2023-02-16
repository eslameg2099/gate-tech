<x-layout :title="__('reports.plural')" bodyClass="sidebar-collapse" :breadcrumbs="['dashboard.reports.index']">
    @include('dashboard.reports.yearly-filter')
    @if(request()->filled('wallet_id') && request()->filled('type') && request()->filled('year'))
        @component('dashboard::components.table-box')
            @slot('title', $title)
            <thead>
            <tr>
                <th>@lang('طريقة الدفع')</th>
                @foreach(__('months') as $month)
                    <th>{{ $month }}</th>
                @endforeach
                <th>@lang('الاجمالي')</th>
            </tr>
            </thead>
            <tbody>
            @foreach(__('transactions.payment_methods') as $paymentMethod => $paymentMethodName)
                <tr>
                    <td>{{ $paymentMethodName }}</td>
                    @foreach(__('months') as $key => $month)
                        <td>
                            {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))
                                ->where('payment_method', $paymentMethod)
                                ->whereMonth('date', $key)
                                ->sum('amount')) }}
                        </td>
                    @endforeach
                    <td>
                        {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))->where('payment_method', $paymentMethod)->sum('amount')) }}
                    </td>
                </tr>
            @endforeach
            <tr class="tw-bg-green-200">
                <td>{{ __('المجموع') }}</td>
                @foreach(__('months') as $key => $month)
                    <td>
                        {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))
                            ->whereMonth('date', $key)
                            ->sum('amount')) }}
                    </td>
                @endforeach
                <td>
                    {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))->sum('amount')) }}
                </td>
            </tr>

        @endcomponent

        @component('dashboard::components.table-box')
            @slot('title', $title)
            <thead>
            <tr>
                <th>@lang('الخدمة')</th>
                @foreach(__('months') as $month)
                    <th>{{ $month }}</th>
                @endforeach
                <th>@lang('الاجمالي')</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\Service::all() as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    @foreach(__('months') as $key => $month)
                        <td>
                            {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))
                                ->where('service_id', $service->id)
                                ->whereMonth('date', $key)
                                ->sum('amount')) }}
                        </td>
                    @endforeach
                    <td>
                        {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))->where('service_id', $service->id)
                          ->sum('amount')) }}
                    </td>
                </tr>
            @endforeach
            <tr class="tw-bg-green-200">
                <td>{{ __('المجموع') }}</td>
                @foreach(__('months') as $key => $month)
                    <td>
                        {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))
                            ->whereMonth('date', $key)
                            ->whereNotNull('service_id')->sum('amount')) }}
                    </td>
                @endforeach
                <td>
                    {{ abs(\App\Models\Transaction::query()->filter()->when(request('type') == 'expenses', fn($query) => $query->where('amount', '<', 0))
                      ->whereNotNull('service_id')->sum('amount')) }}
                </td>
            </tr>

        @endcomponent
    @endif
</x-layout>
