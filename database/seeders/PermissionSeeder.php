<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $teamPermissions = [
            'create_team',
            'read_team',
            'update_team',
            'delete_team',
            'send-team-broadcast',
        ];
        $postPermissions = [
            'create_post',
            'read_post',
            'update_post',
            'delete_post',
        ];
        $feedPermissions = [
            'create_feed',
            'read_feed',
            'update_feed',
            'delete_feed',
        ];
        $awardPermissions = [
            'create_award',
            'read_award',
            'update_award',
            'delete_award',
        ];
        $reviewPermissions = [
            'create_review',
            'read_review',
            'update_review',
            'delete_review',
        ];
        $subscriptionPermissions = [
            'create_subscription',
            'read_subscription',
            'update_subscription',
            'delete_subscription',
        ];
        $eventPermissions = [
            'create_event',
            'read_event',
            'update_event',
            'delete_event',
        ];

        $allPermissions = [
            ...$teamPermissions,
            ...$postPermissions,
            ...$feedPermissions,
            ...$awardPermissions,
            ...$reviewPermissions,
            ...$eventPermissions,
        ];

        array_push($allPermissions, ...$subscriptionPermissions);

        //Some Default Team role configuration
        $roles = [
            config('platform.teams.default_owner_role') => [
                'description' => 'There can only be 1 Owner. The owner is the user that has their financial & billing accounts linked to this Team',
                'permissions' => [
                    ...$allPermissions,
                    'billing',
                ],
            ],
            config('platform.teams.default_admin_role') => [
                'description' => 'Admins have access to everything except billing & subscription details.',
                'permissions' => [
                    ...$allPermissions,
                ],
            ],
            config('platform.teams.default_moderator_role') => [
                'description' => 'Moderators can also can edit and delete_posts.',
                'permissions' => [
                    'view_posts',
                    'create_posts',
                    'update_posts',
                    'delete_posts',
                ],
            ],
            config('platform.teams.default_editor_role') => [
                'description' => 'Editors can create_and update_posts but never delete_posts.',
                'permissions' => [
                    'view_posts',
                    'create_posts',
                    'update_posts',
                ],
            ],
            config('platform.teams.default_member_role') => [
                'description' => 'Members are a part of your Team and can see content inside the Team.',
                'permissions' => [
                    'view_posts',
                ],
            ],
        ];

        if (! empty($usingTeamMemberSubs)) {
            $roles = array_merge($roles, [
                config('platform.teams.default_subscriber_role') => [
                    'description' => "Subscribers can view 'sub-only' content, including posts, chats, events and more. Assigning a new member this role is equivalent to giving a subscription for free.",
                    'permissions' => [
                        'view_posts',
                    ],
                ],
            ]);
        }

        foreach (Team::pluck('id') as $teamId) {
            collect($roles)->each(function ($data, $role) use ($teamId) {
                app(PermissionRegistrar::class)->setPermissionsTeamId($teamId);
                $role = Role::findOrCreate($role);
                $role->description = $data['description'];
                $role->save();
                collect($data['permissions'])->each(function ($permission) use ($role) {
                    $role->permissions()->save(Permission::findOrCreate($permission));
                });
            });
        }

        // Generate all remaining permissions using shield
        Artisan::call('shield:generate --option=permissions --all');

        // add Omnia Admin as super admin
        Artisan::call('shield:super-admin --user=1');
    }
}
