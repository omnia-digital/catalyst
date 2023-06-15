<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    use RefreshDatabase;

    // @TODO [Josh] - fix these to use passport eventually

    /**
     * @test
     */
//    public function api_tokens_can_be_created()
//    {
//        if (! Features::hasApiFeatures()) {
//            return $this->markTestSkipped('API support is not enabled.');
//        }
//
//        if (Features::hasTeamFeatures()) {
//            $this->actingAs($user = User::factory()->withPersonalTeam()->create());
//        } else {
//            $this->actingAs($user = User::factory()->create());
//        }
//
//        Livewire::test(ApiTokenManager::class)
//            ->set(['createApiTokenForm' => [
//                'name' => 'Test Token',
//                'permissions' => [
//                    'read',
//                    'update',
//                ],
//            ]])
//            ->call('createApiToken');
//
//        $this->assertCount(1, $user->fresh()->tokens);
//        $this->assertEquals('Test Token', $user->fresh()->tokens->first()->name);
//        $this->assertTrue($user->fresh()->tokens->first()->can('read'));
//        $this->assertFalse($user->fresh()->tokens->first()->can('delete'));
//    }
}
