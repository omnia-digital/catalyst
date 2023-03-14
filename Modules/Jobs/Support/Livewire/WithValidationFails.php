<?php namespace Modules\Jobs\Support\Livewire;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait WithValidationFails
{
    private $whenFails;

    /**
     * Set action when validation fails.
     *
     * @param \Closure $closure
     * @return WithValidationFails
     */
    public function whenFails(\Closure $closure)
    {
        $this->whenFails = $closure;

        return $this;
    }

    /**
     * @param $rules
     * @param array $messages
     * @param array $attributes
     * @return array
     */
    public function validate($rules = null, $messages = [], $attributes = [])
    {
        [$rules, $messages, $attributes] = $this->providedOrGlobalRulesMessagesAndAttributes($rules, $messages, $attributes);

        $data = $this->prepareForValidation($this->getDataForValidation($rules));

        $validator = Validator::make($data, $rules, $messages, $attributes);

        $this->shortenModelAttributes($data, $rules, $validator);

        $validator->fails() && $this->handleFails($validator);

        $validatedData = $validator->validate();

        $this->resetErrorBag();

        return $validatedData;
    }

    /**
     * @param $validator
     * @throws ValidationException
     */
    private function handleFails($validator)
    {
        $this->whenFails && ($this->whenFails)();

        throw new ValidationException($validator);
    }
}