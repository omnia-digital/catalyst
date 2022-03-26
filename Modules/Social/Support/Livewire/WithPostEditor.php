<?php

namespace Modules\Social\Support\Livewire;

use Illuminate\Validation\Validator;

trait WithPostEditor
{
    public function withPostEditorEvent(): self
    {
        return $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->emitPostValidated($validator);
            });
        });
    }

    public function validatePostEditor(array $rules = ['required'], string $property = 'content'): array
    {
        return $this->withPostEditorEvent()->validate([
            $property => $rules
        ]);
    }

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
