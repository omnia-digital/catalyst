<?php

namespace Tests\Feature\Resources;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Modules\Resources\Http\Livewire\Pages\Resources\Edit as EditResource;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class ResourceModuleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->actingAs($user = User::factory()->create([
            'email' => 'test@omniadigital.io',
            'is_admin' => true
        ]));

        $profile = new Profile([
            'first_name'       => 'test first name',
            'last_name'       => 'test last name',
            'bio'        => 'test bio',
            'remote_url' => 'http://test.url/',
            'location'   => 'test location',
        ]);

        $user->profile()->save($profile);
    }

    public function test_load_resources_page()
    {
        $response = $this->get('/resources');

        $response->assertStatus(200);
    }

    public function test_load_view_resource_page()
    {
        $resource = (new CreateNewPostAction)->type(PostType::RESOURCE)->execute(
            $this->faker->paragraphs(3, true),
            [
                'title' => $this->faker->sentence(),
                'url' => $this->faker->url()
            ]
        );
        $response = $this->get('/resources/' . $resource->id);

        $response->assertStatus(200);
    }

    public function test_load_edit_resource_page()
    {
        $resource = (new CreateNewPostAction)->type(PostType::RESOURCE)->execute(
            $this->faker->paragraphs(3, true),
            [
                'title' => $this->faker->sentence(),
                'url' => $this->faker->url()
            ]
        );
        $response = $this->get('/resources/' . $resource->id . '/edit');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_edit_resource()
    {
        $this->actingAs($user = User::factory()->withProfile()->create());

        $resource = (new CreateNewPostAction)->user($user)->type(PostType::RESOURCE)->execute(
            $this->faker->paragraphs(3, true),
            [
                'title' => $this->faker->sentence(),
                'url' => $this->faker->url()
            ]
        );

        $component = Livewire::test(EditResource::class, ['resource' => $resource])
            ->set('resource.title', 'Updated Title')
            ->set('resource.body', 'This is the updated body of the resource.')
            ->call('publishResource');

        $component->assertSuccessful()
            ->assertSet('resource.title', 'Updated Title')
            ->assertSet('resource.body', 'This is the updated body of the resource.')
            ->assertSessionHasNoErrors()
            ->assertRedirect('/resources/' . $resource->id);
        
    }

}
