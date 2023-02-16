@include('dashboard.errors')

@bsMultilangualFormTabs
{{ BsForm::text('name') }}
@endBsMultilangualFormTabs
@if(request('user_id'))
    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
@else
    <select2
            label="{{ __('owners.singular') }}"
            name="user_id"
            value="{{ old('user_id', $building->user_id ?? null) }}"
            placeholder="{{ __('owners.select') }}"
            remote-url="{{ route('api.users.select', ['type' => \App\Models\User::OWNER_TYPE]) }}"
    ></select2>
@endif
