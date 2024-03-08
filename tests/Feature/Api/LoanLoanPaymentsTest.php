<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Loan;
use App\Models\LoanPayment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanLoanPaymentsTest extends TestCase
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
    public function it_gets_loan_loan_payments(): void
    {
        $loan = Loan::factory()->create();
        $loanPayments = LoanPayment::factory()
            ->count(2)
            ->create([
                'loan_id' => $loan->id,
            ]);

        $response = $this->getJson(
            route('api.loans.loan-payments.index', $loan)
        );

        $response->assertOk()->assertSee($loanPayments[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_loan_loan_payments(): void
    {
        $loan = Loan::factory()->create();
        $data = LoanPayment::factory()
            ->make([
                'loan_id' => $loan->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.loans.loan-payments.store', $loan),
            $data
        );

        $this->assertDatabaseHas('loan_payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $loanPayment = LoanPayment::latest('id')->first();

        $this->assertEquals($loan->id, $loanPayment->loan_id);
    }
}
