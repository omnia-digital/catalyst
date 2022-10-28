<?php

namespace Modules\Forms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Forms\Models\FormType;

class FormsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Default Form Types
        $registrationFormType = FormType::create([
            'name' => \Trans::get('Registration'),
            'slug' => 'registration',
        ]);
        $teamResourceRequestForm = FormType::create([
            'name' => \Trans::get('Team Resource Request'),
            'slug' => 'team-resource-request',
        ]);
        $teamMemberApplicationForm = FormType::create([
            'name' => \Trans::get('Team Member Application Form'),
            'slug' => 'team-member-application-form',
        ]);
        $teamMemberForm = FormType::create([
            'name' => \Trans::get('Team Member Form'),
            'slug' => 'team-member-form',
        ]);
    }
}
