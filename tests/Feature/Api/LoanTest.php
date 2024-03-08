<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Loan;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
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
    public function it_gets_loans_list(): void
    {
        $loans = Loan::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.loans.index'));

        $response->assertOk()->assertSee($loans[0]->source);
    }

    /**
     * @test
     */
    public function it_stores_the_loan(): void
    {
        $data = Loan::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.loans.store'), $data);

        $this->assertDatabaseHas('loans', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_loan(): void
    {
        $loan = Loan::factory()->create();

        $data = [
            'source' => $this->faker->text(),
            'description' => $this->faker->sentence(15),
            'amount' => $this->faker->randomNumber(1),
        ];

        $response = $this->putJson(route('api.loans.update', $loan), $data);

        $data['id'] = $loan->id;

        $this->assertDatabaseHas('loans', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_loan(): void
    {
        $loan = Loan::factory()->create();

        $response = $this->deleteJson(route('api.loans.destroy', $loan));

        $this->assertModelMissing($loan);

        $response->assertNoContent();
    }
}
