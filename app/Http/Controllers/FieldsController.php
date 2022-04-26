<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Sensor;
use Illuminate\Http\Request;

class FieldsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            ['name' => 'max:100|required']
        );
        $field = Field::create($request->all());
        return \Response::json(['message' => 'Field created', 'field' => $field]);
    }

    public function update(Request $request, Field $field)
    {
        $request->validate( ['name' => 'max:100']);

        $field->update($request->all());

        return \Response::json(['message' => 'Field updated', 'field' => $field->refresh()]);
    }

    public function destroy(Field $field)
    {
        $field->delete();

        return \Response::json(['message' => 'Field deleted']);
    }
}
