<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Loan;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanControllerTest extends TestCase
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
    public function it_displays_index_view_with_loans(): void
    {
        $loans = Loan::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('loans.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.loans.index')
            ->assertViewHas('loans');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_loan(): void
    {
        $response = $this->get(route('loans.create'));

        $response->assertOk()->assertViewIs('app.loans.create');
    }

    /**
     * @test
     */
    public function it_stores_the_loan(): void
    {
        $data = Loan::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('loans.store'), $data);

        $this->assertDatabaseHas('loans', $data);

        $loan = Loan::latest('id')->first();

        $response->assertRedirect(route('loans.edit', $loan));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_loan(): void
    {
        $loan = Loan::factory()->create();

        $response = $this->get(route('loans.show', $loan));

        $response
            ->assertOk()
            ->assertViewIs('app.loans.show')
            ->assertViewHas('loan');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_loan(): void
    {
        $loan = Loan::factory()->create();

        $response = $this->get(route('loans.edit', $loan));

        $response
            ->assertOk()
            ->assertViewIs('app.loans.edit')
            ->assertViewHas('loan');
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

        $response = $this->put(route('loans.update', $loan), $data);

        $data['id'] = $loan->id;

        $this->assertDatabaseHas('loans', $data);

        $response->assertRedirect(route('loans.edit', $loan));
    }

    /**
     * @test
     */
    public function it_deletes_the_loan(): void
    {
        $loan = Loan::factory()->create();

        $response = $this->delete(route('loans.destroy', $loan));

        $response->assertRedirect(route('loans.index'));

        $this->assertModelMissing($loan);
    }
}
