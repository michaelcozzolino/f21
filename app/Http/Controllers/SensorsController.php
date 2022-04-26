<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SensorsController extends Controller
{
    public function store(Request $request, Field $field)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
                'lat' => 'double|required',
                'long' => 'double|required',
            ],
        );

        $sensor = Sensor::create(array_merge($request->all(), compact('field')));

        return \Response::json(['message' => 'Sensor created', 'sensor' => $sensor]);

    }

    public function update(Request $request, Sensor $sensor, Field $field)
    {
        $request->validate(
            [
                'name' => 'max:100|nullable',
                'lat' => 'double|nullable',
                'long' => 'double|nullable',
                'status' => [Rule::in(['connected', 'disconnected', 'connecting']), 'nullable'],
                'field_id' => [function ($attribute, $value, $fail) {
                    $fieldExists = Field::find($value)->count();
                    if (!$fieldExists) {
                        $fail('The field you are trying to associate to this sensor does not exist');
                    }
                },
                    'nullable'],
            ],
        );

        $sensor->update($request->all());

        return \Response::json(['message' => 'Sensor updated', 'sensor' => $sensor->refresh()]);
    }

    public function destroy(Sensor $sensor, Field $field)
    {
        $sensor->delete();

        return \Response::json(['message' => 'Sensor deleted']);
    }
}
