<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Earning;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EarningControllerTest extends TestCase
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
    public function it_displays_index_view_with_earnings(): void
    {
        $earnings = Earning::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('earnings.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.earnings.index')
            ->assertViewHas('earnings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_earning(): void
    {
        $response = $this->get(route('earnings.create'));

        $response->assertOk()->assertViewIs('app.earnings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_earning(): void
    {
        $data = Earning::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('earnings.store'), $data);

        $this->assertDatabaseHas('earnings', $data);

        $earning = Earning::latest('id')->first();

        $response->assertRedirect(route('earnings.edit', $earning));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_earning(): void
    {
        $earning = Earning::factory()->create();

        $response = $this->get(route('earnings.show', $earning));

        $response
            ->assertOk()
            ->assertViewIs('app.earnings.show')
            ->assertViewHas('earning');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_earning(): void
    {
        $earning = Earning::factory()->create();

        $response = $this->get(route('earnings.edit', $earning));

        $response
            ->assertOk()
            ->assertViewIs('app.earnings.edit')
            ->assertViewHas('earning');
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

        $response = $this->put(route('earnings.update', $earning), $data);

        $data['id'] = $earning->id;

        $this->assertDatabaseHas('earnings', $data);

        $response->assertRedirect(route('earnings.edit', $earning));
    }

    /**
     * @test
     */
    public function it_deletes_the_earning(): void
    {
        $earning = Earning::factory()->create();

        $response = $this->delete(route('earnings.destroy', $earning));

        $response->assertRedirect(route('earnings.index'));

        $this->assertModelMissing($earning);
    }
}
