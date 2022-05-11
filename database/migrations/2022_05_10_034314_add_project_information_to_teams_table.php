<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('title');
            $table->string('summary');
            $table->longText('description');  
            $table->foreignIdFor(User::class, 'organizer_id')->index()->nullable();    
            $table->timestamp('launch_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropIndex('teams_organizer_id_index');
            $table->dropColumn(['title', 'summary', 'description', 'organizer_id', 'launch_date']);
        });
    }
};
