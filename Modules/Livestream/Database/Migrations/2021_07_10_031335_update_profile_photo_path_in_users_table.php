<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateProfilePhotoPathInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('users', 'photo_url')) {
            return;
        }

        \App\Models\User::whereNotNull('photo_url')
            ->get()
            ->each(function (App\Models\User $user) {
                $newPhotoUrl = \Illuminate\Support\Str::startsWith($user->photo_url, ['http', 'https'])
                    ? $user->photo_url
                    : str_replace('/storage/profiles', 'profile-photos', $user->photo_url);

                $user->update(['profile_photo_path' => $newPhotoUrl]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo_url');
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
