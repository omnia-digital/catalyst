@props([
    'default' => 1
])

<div
        x-data="{
            currentId: '',
            init() {
                // Set default step on page load.
                this.$nextTick(() => this.select(this.$id('step-wizard', '{{ $default }}')))
            },
            select(id) {
                this.currentId = id
            },
            handleNextStepEmitted(passedLivewireComponentId) {
                let passedStepPanelElement = Array.from(this.$refs.stepPanels.children).filter(StepPanelElement => {
                    return StepPanelElement.children[0].getAttribute('wire:id') === passedLivewireComponentId;
                });

                let totalStep = this.$refs.steplist.children.length;
                let currentStepNumber = this.whichChild(passedStepPanelElement[0], this.$refs.stepPanels);
                let nextStepNumber = currentStepNumber > totalStep ? totalStep : currentStepNumber + 1;

                this.select(this.$id('step-wizard', nextStepNumber));
            },
            handlePreviousStepEmitted() {
                let currentStepNumber = parseInt(this.currentId.replace($el.id + '-', ''));
                let previousStepNumber = currentStepNumber === 1 ? currentStepNumber : currentStepNumber - 1;

                this.select(this.$id('step-wizard', previousStepNumber));
            },
            async goToStep(id) {
                let currentStepNumber = parseInt(this.currentId.replace($el.id + '-', ''));
                let destinationStepNumber = parseInt(id.replace($el.id + '-', ''));

                // Go to previous step
                if (destinationStepNumber < currentStepNumber) {
                    this.select(id);

                    return;
                }

                // Go to itself, do nothing
                if (destinationStepNumber === currentStepNumber) {
                    return;
                }

                // Just go one step
                if (destinationStepNumber === currentStepNumber + 1) {
                    // Just submit the current Livewire component
                    let passedLivewireComponentId = await this.findLivewireStepComponent(currentStepNumber)?.submit();

                    // If pass, go to next step
                    if (passedLivewireComponentId) {
                        this.select(id);
                    }

                    return;
                }

                // Allow to skip steps (Go multiple steps)
                // Submit all Livewire components from step 1 -> destination step
                let totalSubmittedComponents = 0;

                for (let i = 1; i <= destinationStepNumber; i++) {
                    totalSubmittedComponents++;

                    let passedLivewireComponentId = await this.findLivewireStepComponent(i)?.submit();

                    // If one component is failed, stop submit the subsequent components
                    if (!passedLivewireComponentId) {
                         break;
                    }
                }

                // Go to the step that has index equals to total submitted components (PASSED + FAILED ones).
                // [1 - PASSED], [2 - PASSED], [3- PASSED], [4 - FAILED] --> Total submitted components is 4.
                // [1 - FAILED], [2 - NOT SUBMITTED], [3- NOT SUBMITTED], [4 - NOT SUBMITTED] --> Total submitted components is 1.
                // [1 - PASSED], [2 - FAILED], [3- NOT SUBMITTED], [4 - NOT SUBMITTED] --> Total submitted components is 2.
                this.select(this.$id('step-wizard', totalSubmittedComponents));
            },
            findLivewireStepComponent(currentStepNumber) {
                // Find livewire component of the current step.
                currentPanelElement = this.$refs.stepPanels.children[currentStepNumber - 1];
                livewireComponentId = currentPanelElement.children[0]?.getAttribute('wire:id');

                return Livewire.find(livewireComponentId);
            },
            isCurrent(id) {
                return parseInt(id.replace($el.id + '-', '')) === parseInt(this.currentId.replace($el.id + '-', ''))
            },
            isCompleted(id) {
                return parseInt(id.replace($el.id + '-', '')) < parseInt(this.currentId.replace($el.id + '-', ''))
            },
            isUpcoming(id) {
                return parseInt(id.replace($el.id + '-', '')) > parseInt(this.currentId.replace($el.id + '-', ''))
            },
            whichChild(el, parent) {
                return Array.from(parent.children).indexOf(el) + 1;
            }
        }"
        x-id="['step-wizard']"
        x-on:next-step-emitted.window="handleNextStepEmitted($event.detail)"
        x-on:previous-step-emitted.window="handlePreviousStepEmitted"
        x-bind:id="$id('step-wizard')"
        {{ $attributes }}
>
    <nav :aria-label="$id('step-wizard')">
        <ol x-ref="steplist" role="list" class="space-y-4 md:flex md:space-y-0 md:space-x-8">
            {{ $items }}
        </ol>
    </nav>

    <div x-ref="stepPanels">
        {{ $panels }}
    </div>
</div>
