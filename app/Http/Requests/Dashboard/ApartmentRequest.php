<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Building;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $apartmentId = optional($this->route('apartment'))->id;
        $building = $this->route('apartment')
        ? $this->route('apartment')->building
        : Building::find($this->building_id);

        return [
            'building_id' => ['required', 'exists:buildings,id'],
            'number' => [
                'required',
                Rule::unique('apartments', 'number')
                    ->where('building_id', $this->building_id)
                    ->ignore($apartmentId),
            ],
            'floor' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('apartments.attributes');
    }
}
