<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $teamPermissions         = [
            'create team',
            'read team',
            'update team',
            'delete team',
        ];
        $postPermissions         = [
            'create post',
            'read post',
            'update post',
            'delete post',
        ];
        $feedPermissions         = [
            'create feed',
            'read feed',
            'update feed',
            'delete feed',
        ];
        $awardPermissions        = [
            'create award',
            'read award',
            'update award',
            'delete award',
        ];
        $reviewPermissions       = [
            'create review',
            'read review',
            'update review',
            'delete review',
        ];
        $subscriptionPermissions = [
            'create sub',
            'read sub',
            'update sub',
            'delete sub',
        ];
        $eventPermissions        = [
            'create event',
            'read event',
            'update event',
            'delete event',
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
                'description' => "There can only be 1 Owner. The owner is the user that has their financial & billing accounts linked to this Team",
                'permissions' => [
                    ...$allPermissions,
                    'billing'
                ]
            ],
            config('platform.teams.default_admin_role') => [
                'description' => "Admins have access to everything except billing & subscription details.",
                'permissions' => [
                    ...$allPermissions
                ]
            ],
            config('platform.teams.default_moderator_role') => [
                'description' => "Moderators can also can edit and delete posts.",
                'permissions' => [
                    'view posts',
                    'create posts',
                    'update posts',
                    'delete posts'
                ]
            ],
            config('platform.teams.default_editor_role') => [
                'description' => "Editors can create and update posts but never delete posts.",
                'permissions' => [
                    'view posts',
                    'create posts',
                    'update posts',
                ]
            ],
            config('platform.teams.default_member_role') => [
                'description' => "Members are a part of your Team and can see content inside the Team.",
                'permissions' => [
                    'view posts',
                ]
            ]
        ];

        if ( ! empty($usingTeamMemberSubs)) {
            $roles = array_merge($roles, [
                config('platform.teams.default_subscriber_role') => [
                    'description' => "Subscribers can view 'sub-only' content, including posts, chats, events and more. Assigning a new member this role is equivalent to giving a subscription for free.",
                    'permissions' => [
                        'view posts',
                    ]
                ]
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
    }
}
