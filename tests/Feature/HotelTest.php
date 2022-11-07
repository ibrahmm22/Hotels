<?php

namespace Tests\Feature;

use App\Models\Hotel;
use Tests\TestCase;

class HotelTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_hotel()
    {
        $data = [
            'name' => 'test',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'price' => 100,
            'facilities' => [
                'dsfdsfs',
                "fdsfsdsf"
            ]
        ];
        $headers = [
            'Authorization' => $this->token,
            'Accept' => 'application/json'
        ];
        $response = $this->post('api/hotels', $data, $headers);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_list_hotels()
    {
        $this->test_create_hotel();
        $headers = [
            'Authorization' => $this->token,
            'Accept' => 'application/json'
        ];
        $response = $this->get('api/hotels', $headers);
        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data'
        ]);
    }

    public function test_update_hotel()
    {
        $this->test_create_hotel();
        $data = [
            'name' => 'test2',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'price' => 5000,
            'facilities' => [
                'dsfdsfs',
                "fdsfsdsf"
            ]
        ];
        $headers = [
            'Authorization' => $this->token,
            'Accept' => 'application/json'
        ];
        $response = $this->patch('api/hotels/1', $data, $headers);
        $response->assertStatus(200)->assertJson([
            'status' => true,
            'message' => 'Hotel Updated Successfully'
        ]);
    }

    public function test_un_authenticated_user()
    {
        $data = [
            'name' => 'test',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'price' => 100,
            'facilities' => [
                'dsfdsfs',
                "fdsfsdsf"
            ]
        ];
        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('api/hotels', $data, $headers);
        $response->assertStatus(401);
    }

    public function test_sort()
    {
        Hotel::insert([[
            'name' => 'test',
            'country_id' => 1,
            'city_id' => 1,
            'price' => 100,
        ],[
            'name' => 'test2',
            'country_id' => 1,
            'city_id' => 1,
            'price' => 100
        ]]);

        $headers = [
            'Authorization' => $this->token,
            'Accept' => 'application/json'
        ];

        $response = $this->get('api/hotels?sort_key=id&sort_method=DESC', $headers);
        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data'
        ]);

        $data = json_decode($response->getContent())->data;
        self::assertEquals(1, end($data)->id);
    }
}
