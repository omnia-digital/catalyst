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
            $property => $rules,
        ]);
    }

    public function emitPostValidated(Validator $validator)
    {
        $this->dispatch('validationFailed', errors: $validator->errors())->to('social::post-editor');
    }

    public function emitPostSaved(string $editorId)
    {
        $this->dispatch('postSaved:' . $editorId)->to('social::post-editor');
        $this->dispatch('postSaved')->to('social::news-feed');
    }
}
