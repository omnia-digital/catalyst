<?php namespace Modules\Subscriptions\Actions\Salesforce;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class CreateContactObjectAction
{
    /**
     * @param User|Authenticatable $user
     */
    public function execute(User $user)
    {
        if($user->contact_id || !config('forrest.credentials.consumerKey')) {
            return;
        }

        Forrest::authenticate();

        $contact = Forrest::query(
            "SELECT Id FROM Contact 
            WHERE (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND Email = '" . addslashes($user->email) . "') 
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND Email2__c = '" . addslashes($user->email) . "')
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND Email3__c = '" . addslashes($user->email) . "')
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND Email4__c = '" . addslashes($user->email) . "')
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND npe01__AlternateEmail__c = '" . addslashes($user->email) . "')
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND npe01__WorkEmail__c = '" . addslashes($user->email) . "')
            or (FirstName LIKE '%" . addslashes($user->first_name) . "%' AND npe01__HomeEmail__c = '" . addslashes($user->email) . "')
            LIMIT 1"
        );


        if ($contact['totalSize'] == 0) {
            $createdContact = Forrest::sobjects('Contact', [
                'method' => 'post',
                'body'   => [
                    'FirstName' => $user->first_name,
                    'LastName'  => $user->last_name,
                    'Email'     => $user->email,
                ]
            ]);
            $contact = Forrest::query("SELECT Id FROM Contact WHERE Id = '" . $createdContact['id'] . "'");
        }

        $user->profile()->update([
            'salesforce_contact_id' => $contact['records'][0]['Id']
        ]);
    }
}
