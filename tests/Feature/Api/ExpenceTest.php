<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenceTest extends TestCase
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
    public function it_gets_expences_list(): void
    {
        $expences = Expence::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.expences.index'));

        $response->assertOk()->assertSee($expences[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_expence(): void
    {
        $data = Expence::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.expences.store'), $data);

        $this->assertDatabaseHas('expences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_expence(): void
    {
        $expence = Expence::factory()->create();

        $data = [
            'type' => 'ঘর ভাড়া',
            'description' => $this->faker->sentence(15),
            'amount' => $this->faker->randomNumber(1),
        ];

        $response = $this->putJson(
            route('api.expences.update', $expence),
            $data
        );

        $data['id'] = $expence->id;

        $this->assertDatabaseHas('expences', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_expence(): void
    {
        $expence = Expence::factory()->create();

        $response = $this->deleteJson(route('api.expences.destroy', $expence));

        $this->assertModelMissing($expence);

        $response->assertNoContent();
    }
}
