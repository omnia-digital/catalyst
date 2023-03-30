<?php

use Illuminate\Database\Migrations\Migration;

class MigrateRoleUserToTeamUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('roles')->get()
            ->each(function ($role) {
                $userRoles = \DB::table('user_role')->where('role_id', $role->id)->get();
                $team = \App\Models\Team::find($role->team_id);

                $members = [];
                foreach ($userRoles as $userRole) {
                    if ($team->user_id !== $userRole->user_id) {
                        $members[$userRole->user_id] = ['role' => 'editor'];
                    }
                }

                $team->users()->sync($members);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
