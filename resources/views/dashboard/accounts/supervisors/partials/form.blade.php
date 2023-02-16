@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}

@if(auth()->user()->isAdmin())
    {{ BsForm::select('building_id')
        ->placeholder(__('buildings.select'))
        ->options(\App\Models\Building::all()->pluck('name', 'id')) }}
    <fieldset>
        <legend>@lang('permissions.plural')</legend>
            {{ BsForm::checkbox('permissions[]')
                    ->value('manage.debits')
                    ->label(trans('اضافة سند صرف'))
                    ->checked(isset($supervisor) && $supervisor->hasPermissionTo('manage.debits')) }}
            {{ BsForm::checkbox('permissions[]')
                    ->value('manage.credits')
                    ->label(trans('اضافة سند قبض'))
                    ->checked(isset($supervisor) && $supervisor->hasPermissionTo('manage.credits')) }}
    </fieldset>
@endif

@isset($supervisor)
    {{ BsForm::image('avatar')->collection('avatars')->files($supervisor->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
