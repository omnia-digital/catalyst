<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        //Some initially role configuration
        $roles = [
            'Owner' => [
                'view posts',
                'create posts',
                'update posts',
                'delete posts',
            ],
            'Admin' => [
                'view posts',
                'create posts',
                'update posts',
                'delete posts',
            ],
            'Editor' => [
                'view posts',
                'create posts',
                'update posts'
            ],
            'Member' => [
                'view posts'
            ]
        ];

        collect($roles)->each(function ($permissions, $role) {
            $role = Role::findOrCreate($role);
            collect($permissions)->each(function ($permission) use ($role) {
                $role->permissions()->save(Permission::findOrCreate($permission));
            });
        });
    }
}
