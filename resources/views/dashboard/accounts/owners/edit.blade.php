<x-layout :title="$owner->name" :breadcrumbs="['dashboard.owners.edit', $owner]">
    {{ BsForm::resource('owners')->putModel($owner, route('dashboard.owners.update', $owner), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('owners.actions.edit'))

        @include('dashboard.accounts.owners.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('owners.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
