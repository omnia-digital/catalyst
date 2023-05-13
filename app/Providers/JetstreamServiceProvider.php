<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Actions\Teams\AddTeamMember;
use App\Actions\Teams\CreateTeam;
use App\Actions\Teams\DeleteTeam;
use App\Actions\Teams\InviteTeamMember;
use App\Actions\Teams\RemoveTeamMember;
use App\Actions\Teams\UpdateTeamName;
use App\Contracts\InvitesTeamMembers;
use App\Models\Membership;
use App\Settings\BillingSettings;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Trans;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::useMembershipModel(Membership::class);

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        /* Jetstream::inviteTeamMembersUsing(InviteTeamMember::class); */
        app()->singleton(InvitesTeamMembers::class, InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions([]);

//        if (class_exists(BillingSettings::class) && \Schema::hasTable('settings')) {
//            $usingTeamMemberSubs = (new BillingSettings())?->team_member_subscriptions;
//        }

        $postPermissions = [
            'post-create',
            'post-read',
            'post-update',
            'post-delete',
        ];
        $feedPermissions = [
            'feed-create',
            'feed-read',
            'feed-update',
            'feed-delete',
        ];
        $awardPermissions = [
            'award-create',
            'award-read',
            'award-update',
            'award-delete',
        ];
        $reviewPermissions = [
            'review-create',
            'review-read',
            'review-update',
            'review-delete',
        ];
        $subscriptionPermissions = [
            'sub-create',
            'sub-read',
            'sub-update',
            'sub-delete',
        ];
        $eventPermissions = [
            'event-create',
            'event-read',
            'event-update',
            'event-delete',
        ];

        $allPermissions = [
            ...$postPermissions,
            ...$feedPermissions,
            ...$awardPermissions,
            ...$reviewPermissions,
            ...$eventPermissions,
        ];

        array_push($allPermissions, ...$subscriptionPermissions);

        $memberRoleDescription = 'Members are a part of your Team and can see content inside the Team';
        //        if ($usingTeamMemberSubs) {
        //            $memberRoleDescription .= " (excluding 'sub-only' content)";
        //        }

        Jetstream::role('member', 'Member', [
            'post-create',
            'post-read',
            'feed-read',
            'award-read',
            'review-create',
            'review-read',
        ])
            ->description(Trans::get($memberRoleDescription));

        if (! empty($usingTeamMemberSubs)) {
            Jetstream::role('subscriber', 'Subscriber', [
                'feed-read',
            ])
                ->description(Trans::get("Subscribers can view 'sub-only' content, including posts, chats, events and more. Assigning a new member this role is equivalent to giving a subscription for free."));
        }

        Jetstream::role('moderator', 'Moderator', [
            'post-read',
            'post-delete',
            'post-edit',
            'create',
        ])
            ->description(Trans::get('Moderators can also can edit and delete posts.'));

        Jetstream::role('admin', 'Administrator', [
            ...$allPermissions,
        ])
            ->description(Trans::get('Admins have access to everything except billing & subscription details.'));

        Jetstream::role('owner', 'Owner', [
            ...$allPermissions,
            'billing',
        ])
            ->description(Trans::get('There can only be 1 Owner. The owner is the user that has their financial & billing accounts linked to this Team'));
    }
}
