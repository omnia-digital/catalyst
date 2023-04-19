<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Social\Http\Livewire\Pages\Profiles\Edit as EditProfile;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs($user = User::factory()->withTeam()->create([
            'email' => 'test@omniadigital.io',
            'is_admin' => true,
        ]));

        $profile = new Profile([
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'bio' => 'test bio',
            'remote_url' => 'http://test.url/',
            'location' => 'test location',
        ]);

        $user->profile()->save($profile);

        $this->user = $user;
    }

    /**
     * @test
     */
    public function current_profile_information_is_available()
    {
        $this->actingAs($this->user);

        Livewire::test(EditProfile::class, ['profile' => $this->user->profile])
            ->assertSet('profile.first_name', $this->user->profile->first_name)
            ->assertSet('profile.last_name', $this->user->profile->last_name);
    }

    /**
     * @test
     */
    public function profile_information_can_be_updated()
    {
        $this->actingAs($this->user);

        $profile = $this->user->profile;

        $component = Livewire::test(EditProfile::class, ['profile' => $profile])
            ->set('profile.first_name', 'New First Name')
            ->set('profile.last_name', 'New Last Name')
            ->call('saveChanges');

        $profile = $this->user->fresh()->profile;

        // $this->assertEquals('New First Name', $component->profile->first_name);
        // $this->assertEquals('New Last Name', $component->profile->last_name);
        $this->assertEquals('New First Name', $profile->fresh()->first_name);
        $this->assertEquals('New Last Name', $profile->fresh()->last_name);
    }
}
