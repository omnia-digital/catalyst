<?php

    namespace App\Nova\Policies;

    use App\Policies\Traits\HasDefaultPolicy;

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
