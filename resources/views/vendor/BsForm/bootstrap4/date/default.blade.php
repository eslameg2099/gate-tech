<?php $invalidClass = $errors->{$errorBag}->has($nameWithoutBrackets) ? ' is-invalid' : ''; ?>
<?php $format = isset($attributes['data-format']) ? $attributes['data-format'] : 'Y-m-d'; ?>
<?php $jsFormat = isset($attributes['data-js-format']) ? $attributes['data-js-format'] : 'YYYY-MM-DD'; ?>
<?php $type = isset($attributes['data-type']) ? $attributes['data-type'] : 'date'; ?>
<?php $value = $value && $type !== 'range' ? \Carbon\Carbon::parse($value)->format($format) : $value; ?>
<?php
$value = $type == 'range' && is_array($value) && count($value) == 2 ?
    [
        $value[0] ? \Carbon\Carbon::parse($value[0])->format($format) : null,
        $value[1] ? \Carbon\Carbon::parse($value[1])->format($format) : null
    ]
    : $value; ?>
<?php $fromName = isset($attributes['data-from-name']) ? $attributes['data-from-name'] : 'from'; ?>
<?php $toName = isset($attributes['data-to-name']) ? $attributes['data-to-name'] : 'to'; ?>
<div class="form-group">
    @if($label)
        {{ Form::label($name, $label) }}
    @endif
    @if($type == 'date')
        <datepicker name="{{ $name }}"
                    class-name="{{ $invalidClass }}"
                    format="{{ $jsFormat }}"
                    value="{{ $value }}"></datepicker>
    @elseif($type == 'datetime')
        <date-time-picker name="{{ $name }}"
                          class-name="{{ $invalidClass }}"
                          format="{{ $jsFormat }}"
                          value="{{ $value }}"></date-time-picker>
    @elseif($type == 'range')
        <date-range-picker name="{{ $name }}"
                           class-name="{{ $invalidClass }}"
                           format="{{ $jsFormat }}"
                           from-name="{{ $fromName }}"
                           to-name="{{ $toName }}"
                           :value="{{ json_encode($value) }}"></date-range-picker>
    @endif


    @if($inlineValidation)
        @if($errors->{$errorBag}->has($nameWithoutBrackets))
            <div class="invalid-feedback">
                {{ $errors->{$errorBag}->first($nameWithoutBrackets) }}
            </div>
        @else
            <small class="form-text text-muted">{{ $note }}</small>
        @endif
    @else
        <small class="form-text text-muted">{{ $note }}</small>
    @endif
</div>
