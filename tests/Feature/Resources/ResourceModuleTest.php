<?php

namespace Tests\Feature\Resources;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public $user;
    public $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->actingAs($user = User::factory()->withTeam()->create([
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

        $this->user = $user;

        $otherUser = User::factory()->create();

        $otherUser->profile()->save(new Profile([
            'first_name'       => 'other user first name',
            'last_name'       => 'other user last name',
            'bio'        => 'other user bio',
            'remote_url' => 'http://otheruser.url/',
            'location'   => 'other user location',
        ]));

        $this->otherUser = $otherUser;
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
        $resource = app(CreateNewPostAction::class)->type(PostType::RESOURCE)->execute(
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

        $resource = app(CreateNewPostAction::class)->user($user)->type(PostType::RESOURCE)->execute(
            $this->faker->paragraphs(3, true),
            [
                'title' => $this->faker->sentence(),
                'url' => $this->faker->url()
            ]
        );

        Livewire::test(EditResource::class, ['resource' => $resource])
            ->set('resource.title', 'Updated Title')
            ->set('resource.body', 'This is the updated body of the resource which is at least 50 characters in order to avoid errors in validation.')
            ->call('publishResource')
            ->assertSuccessful()
            ->assertHasNoErrors(['title', 'body']);

        $this->assertTrue(Post::where('title', 'Updated Title')->exists());
        $this->assertTrue(Post::where('body', 'This is the updated body of the resource which is at least 50 characters in order to avoid errors in validation.')->exists());
        
    }

}
