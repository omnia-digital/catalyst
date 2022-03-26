<?php

namespace Modules\Social\Support\Livewire;

use Illuminate\Validation\Validator;

trait WithPostEditor
{
    public function emitPostValidated(Validator $validator)
    {
        $this->emitTo(
            'social::post-editor',
            'validationFailed',
            $validator->errors()
        );
    }

    public function emitPostSaved()
    {
        $this->emitTo('social::post-editor', 'postSaved');
    }
}
