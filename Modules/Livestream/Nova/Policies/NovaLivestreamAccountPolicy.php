<?php

namespace Modules\Livestream\Nova\Policies;

    use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

    class NovaLivestreamAccountPolicy
    {
        use HasDefaultPolicy;

        public function create()
        {
            return false;
        }

        public function delete()
        {
            return false;
        }
    }
