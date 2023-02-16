<x-layout :title="trans('dashboard.home')" :breadcrumbs="['dashboard.home']">

    <div class="row view-on-load">
        <div class="col-md-12">
            {{ BsForm::resource('transactions')->post(route('dashboard.transactions.store')) }}
            @component('dashboard::components.box')

                @include('dashboard.errors')
                <br>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if(auth()->user()->isAdmin() || auth()->user()->hasPermissionTo('manage.credits'))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.home', ['type' => 'credit']) }}"
                               class="nav-link {{ request('type') === 'credit' ? 'active' : (! request('type') ? 'active' : '') }}">{{ __('transactions.catch_receipt') }}</a>
                        </li>
                    @endif
                    @if(auth()->user()->isAdmin() || auth()->user()->hasPermissionTo('manage.debits'))

                        <li class="nav-item" role="presentation">
                            <a href="{{ route('dashboard.home', ['type' => 'debit']) }}"
                               class="nav-link {{ request('type') === 'debit' ? 'active' : '' }}">{{ __('transactions.debit_receipt') }}</a>
                        </li>
                    @endif
                </ul>
                
                <invoice-form type="{{ request('type', 'credit') }}">
                    {{ BsForm::submit()->label(trans('rents.actions.payment')) }}
                </invoice-form>
            @endcomponent
            {{ BsForm::close() }}
        </div>
    </div>
    @push('styles')
        <style>
            .view-on-load {
                display: none;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
          $(window).on('load', function () {
            $('.view-on-load').css('display', 'flex')
          })
        </script>
    @endpush
</x-layout>
