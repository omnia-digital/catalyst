<?php
namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Social\Models\Association;

trait HasAssociations {

    /**
     * @return MorphToMany
     */
    public function associations()
    {
        return $this->morphTo(Association::class, 'associatable');
    }
}
