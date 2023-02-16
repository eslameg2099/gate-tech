<x-layout :title="$rent->tenant->name" :breadcrumbs="['dashboard.rents.show', $rent]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('rents.attributes.user_id')</th>
                        <td>{{ $rent->tenant->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('rents.attributes.period')</th>
                        <td>{{ $rent->from->toDateString() }} ~ {{ $rent->to->toDateString() }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('rents.attributes.renewable')</th>
                        <td><x-boolean is="{{ $rent->renewable }}"></x-boolean></td>
                    </tr>
                    <tr>
                        <th width="200">@lang('rents.attributes.amount')</th>
                        <td>{{ price($rent->amount) }}</td>
                    </tr>
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>
</x-layout>