<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\LoanPayment;

use App\Models\Loan;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanPaymentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_loan_payments(): void
    {
        $loanPayments = LoanPayment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('loan-payments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.loan_payments.index')
            ->assertViewHas('loanPayments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_loan_payment(): void
    {
        $response = $this->get(route('loan-payments.create'));

        $response->assertOk()->assertViewIs('app.loan_payments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_loan_payment(): void
    {
        $data = LoanPayment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('loan-payments.store'), $data);

        $this->assertDatabaseHas('loan_payments', $data);

        $loanPayment = LoanPayment::latest('id')->first();

        $response->assertRedirect(route('loan-payments.edit', $loanPayment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_loan_payment(): void
    {
        $loanPayment = LoanPayment::factory()->create();

        $response = $this->get(route('loan-payments.show', $loanPayment));

        $response
            ->assertOk()
            ->assertViewIs('app.loan_payments.show')
            ->assertViewHas('loanPayment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_loan_payment(): void
    {
        $loanPayment = LoanPayment::factory()->create();

        $response = $this->get(route('loan-payments.edit', $loanPayment));

        $response
            ->assertOk()
            ->assertViewIs('app.loan_payments.edit')
            ->assertViewHas('loanPayment');
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

        $response = $this->put(
            route('loan-payments.update', $loanPayment),
            $data
        );

        $data['id'] = $loanPayment->id;

        $this->assertDatabaseHas('loan_payments', $data);

        $response->assertRedirect(route('loan-payments.edit', $loanPayment));
    }

    /**
     * @test
     */
    public function it_deletes_the_loan_payment(): void
    {
        $loanPayment = LoanPayment::factory()->create();

        $response = $this->delete(route('loan-payments.destroy', $loanPayment));

        $response->assertRedirect(route('loan-payments.index'));

        $this->assertModelMissing($loanPayment);
    }
}
