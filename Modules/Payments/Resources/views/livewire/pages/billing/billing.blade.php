<div>
    <div class="max-w-7xl mx-auto pb-10 px-4 sm:px-6 lg:px-8 min-h-screen">
        <div class="max-w-3xl mx-auto pt-8 space-y-8">
            <livewire:payments::pages.billing.payment-method :billable="$this->getBillable()"/>

            <livewire:payments::pages.billing.invoices :billable="$this->getBillable()"/>
        </div>
    </div>
</div>
