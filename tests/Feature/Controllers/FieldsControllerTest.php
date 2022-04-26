<?php

namespace Tests\Feature\Controllers;

use App\Models\Field;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FieldsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_field_can_be_created()
    {
        $response = $this->post(route('fields.store'), [
            'name' => 'my first field',
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('field.name', 'my first field')
                ->where('message', 'Field created')
            );

    }

    public function test_field_can_be_updated()
    {
       $field =  Field::create(['name' => 'field']);

        $response = $this->put(route('fields.update', compact('field')), [
            'name' => 'new field name',
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('field.name', 'new field name')
                ->where('message', 'Field updated')
            );
    }

    public function test_field_can_be_deleted()
    {
        $field =  Field::create(['name' => 'field']);

        $response = $this->delete(route('fields.destroy', compact('field')));

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'Field deleted')
            );
    }
}
