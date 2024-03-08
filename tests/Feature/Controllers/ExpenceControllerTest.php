<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Expence;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenceControllerTest extends TestCase
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
    public function it_displays_index_view_with_expences(): void
    {
        $expences = Expence::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('expences.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.expences.index')
            ->assertViewHas('expences');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_expence(): void
    {
        $response = $this->get(route('expences.create'));

        $response->assertOk()->assertViewIs('app.expences.create');
    }

    /**
     * @test
     */
    public function it_stores_the_expence(): void
    {
        $data = Expence::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('expences.store'), $data);

        $this->assertDatabaseHas('expences', $data);

        $expence = Expence::latest('id')->first();

        $response->assertRedirect(route('expences.edit', $expence));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_expence(): void
    {
        $expence = Expence::factory()->create();

        $response = $this->get(route('expences.show', $expence));

        $response
            ->assertOk()
            ->assertViewIs('app.expences.show')
            ->assertViewHas('expence');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_expence(): void
    {
        $expence = Expence::factory()->create();

        $response = $this->get(route('expences.edit', $expence));

        $response
            ->assertOk()
            ->assertViewIs('app.expences.edit')
            ->assertViewHas('expence');
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

        $response = $this->put(route('expences.update', $expence), $data);

        $data['id'] = $expence->id;

        $this->assertDatabaseHas('expences', $data);

        $response->assertRedirect(route('expences.edit', $expence));
    }

    /**
     * @test
     */
    public function it_deletes_the_expence(): void
    {
        $expence = Expence::factory()->create();

        $response = $this->delete(route('expences.destroy', $expence));

        $response->assertRedirect(route('expences.index'));

        $this->assertModelMissing($expence);
    }
}
