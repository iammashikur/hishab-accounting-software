<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LoanPayment;

use App\Models\Loan;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanPaymentTest extends TestCase
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
    public function it_gets_loan_payments_list(): void
    {
        $loanPayments = LoanPayment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.loan-payments.index'));

        $response->assertOk()->assertSee($loanPayments[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_loan_payment(): void
    {
        $data = LoanPayment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.loan-payments.store'), $data);

        $this->assertDatabaseHas('loan_payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_loan_payment(): void
    {
        $loanPayment = LoanPayment::factory()->create();

        $loan = Loan::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber(1),
            'loan_id' => $loan->id,
        ];

        $response = $this->putJson(
            route('api.loan-payments.update', $loanPayment),
            $data
        );

        $data['id'] = $loanPayment->id;

        $this->assertDatabaseHas('loan_payments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_loan_payment(): void
    {
        $loanPayment = LoanPayment::factory()->create();

        $response = $this->deleteJson(
            route('api.loan-payments.destroy', $loanPayment)
        );

        $this->assertModelMissing($loanPayment);

        $response->assertNoContent();
    }
}
