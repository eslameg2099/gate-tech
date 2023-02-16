@include('dashboard.errors')

<div class="row">
    <div class="col-md-6">
        {{ BsForm::text('number')->required() }}
    </div>
    <div class="col-md-6">
        {{ BsForm::text('floor')->required() }}
    </div>
</div>