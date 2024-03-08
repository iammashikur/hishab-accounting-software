<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Earning;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EarningTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_earnings_list(): void
    {
        $earnings = Earning::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.earnings.index'));

        $response->assertOk()->assertSee($earnings[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_earning(): void
    {
        $data = Earning::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.earnings.store'), $data);

        $this->assertDatabaseHas('earnings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_earning(): void
    {
        $earning = Earning::factory()->create();

        $data = [
            'source' => 'বেতন',
            'description' => $this->faker->text(),
            'amount' => $this->faker->randomNumber(1),
        ];

        $response = $this->putJson(
            route('api.earnings.update', $earning),
            $data
        );

        $data['id'] = $earning->id;

        $this->assertDatabaseHas('earnings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_earning(): void
    {
        $earning = Earning::factory()->create();

        $response = $this->deleteJson(route('api.earnings.destroy', $earning));

        $this->assertModelMissing($earning);

        $response->assertNoContent();
    }
}
