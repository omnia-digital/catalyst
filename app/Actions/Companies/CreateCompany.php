<?php

namespace App\Actions\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class CreateCompany// implements CreatesCompanies
{
//    public function create($user, array $input): Company
//    {
//        Gate::forUser($user)->authorize('create', Jetstream::newCompanyModel());
//
//        Validator::make($input, [
//            'name' => ['required', 'string', 'max:255'],
//            //            'start_date' => ['required', 'date'],
//            //            'summary' => ['required', 'max:280'],
//        ])->validateWithBag('createCompany');
//
//        AddingCompany::dispatch($user);
//
//        $company = $user->ownedCompanies()->create([
//            'name' => $input['name'],
//            //            'start_date' => $input['start_date'],
//            //            'summary' => $input['summary'],
//        ]);
//
//        if (! empty($input['companyTypes'])) {
//            $company->attachTags($input['companyTypes']);
//        }
//
//        $user->companies()->updateExistingPivot($company->id, ['role' => 'owner']);
//
//        if (! empty($input['bannerImage'])) {
//            $company->addMedia($input['bannerImage'])->toMediaCollection('company_banner_images');
//        }
//        if (! empty($input['mainImage'])) {
//            $company->addMedia($input['mainImage'])->toMediaCollection('company_main_images');
//        }
//        if (! empty($input['profilePhoto'])) {
//            $company->addMedia($input['profilePhoto'])->toMediaCollection('company_profile_photos');
//        }
//
//        if (! empty($input['sampleMedia'])) {
//            foreach ($input['sampleMedia'] as $media) {
//                $company->addMedia($media)->toMediaCollection('company_sample_images');
//            }
//        }
//
//        (new CreateStripeConnectAccountForCompanyAction)->execute($company);
//
//        $user->switchCompany($company);
//
//        return $company;
//    }
}
