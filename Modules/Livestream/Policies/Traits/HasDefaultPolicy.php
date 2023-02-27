<?php

    namespace Modules\Livestream\Policies\Traits;

    use Modules\Livestream\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    trait HasDefaultPolicy
    {
        use HandlesAuthorization;

        public function adminBypass(User $user)
        {
            if ($user->isAdmin()) {
                return true;
            }
        }

        public function before(User $user, $ability)
        {
            return $this->adminBypass($user);
        }

        public function create()
        {
            return true;
        }

        public function view()
        {
            return true;
        }

        public function viewAny()
        {
            return true;
        }

        public function delete()
        {
            return true;
        }

        public function destroy()
        {
            return $this->delete();
        }

        public function restore()
        {
            return true;
        }

        public function forceDelete()
        {
            return true;
        }
    }
