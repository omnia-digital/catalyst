<?php

namespace Modules\Forms\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Forms\Models\FormType;
use Trans;

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
            'name' => Trans::get('Registration'),
            'slug' => 'registration',
            'for' => 'admin',
        ]);
        $teamResourceRequestForm = FormType::create([
            'name' => Trans::get('Team Resource Request'),
            'slug' => 'team-resource-request',
            'for' => 'teams',
        ]);
        $teamMemberApplicationForm = FormType::create([
            'name' => Trans::get('Team Member Application Form'),
            'slug' => 'team-member-application-form',
            'for' => 'teams',
        ]);
        $teamMemberForm = FormType::create([
            'name' => Trans::get('Team Member Form'),
            'slug' => 'team-member-form',
            'for' => 'teams',
        ]);
    }
}
