<?php

namespace Modules\Jobs\Http\Livewire\Jobs;

use Modules\Jobs\Actions\Fortify\CreateNewUser;
use Modules\Jobs\Data\Transaction;
use Modules\Jobs\Events\JobWasCreated;
use Modules\Jobs\Models\ApplyType;
use Modules\Jobs\Models\Coupon;
use Modules\Jobs\Models\HoursPerWeek;
use Modules\Jobs\Models\ExperienceLevel;
use Modules\Jobs\Models\Job;
use Modules\Jobs\Models\JobAddon;
use Modules\Jobs\Models\JobLength;
use Modules\Jobs\Models\PaymentType;
use Modules\Jobs\Models\ProjectSize;
use Modules\Jobs\Models\Tag;
use Modules\Jobs\Rules\ValidJobAddons;
use Modules\Jobs\Rules\ValidTags;
use Modules\Jobs\Support\Livewire\WithNotification;
use Modules\Jobs\Support\Livewire\WithValidationFails;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewJob extends Component
{
    use WithNotification, WithValidationFails, WithFileUploads;

    public $title;
    public $description;
    public $team_id = '';
    public $apply_type = '';
    public $apply_value;
    public $payment_type = '';
    public $budget;
    public $is_remote = false;
    public $location;
    public $selected_tags = [];
    public $selected_addons = [];
    public $price = 0;
    public $payment_method;
    public $selected_payment_method;
    public $line1;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $card_holder_name;
    public $coupon;
    public $validCoupon;
    public $logo;
    public $registerModalOpen = false;
    public $hours_per_week_id;
    public $register = [
        'name',
        'email',
        'password',
        'confirm-password'
    ];
    public $job_length_id;
    public $experience_level_id;
    public $project_size_id;
    public $is_active = true;
    public $default_description = "The description of the job position will appear here. Write this in the \"Job Description\" box above.";

    public function mount()
    {
        $this->setTeamId();
        $this->price = nova_get_setting('job:posting_price');

    }

    public function updatedLogo()
    {
        $this->validate(['logo' => 'image|max:2048']);
    }

    public function updatedCoupon($value)
    {
        if (!empty($value)) {
            $coupon = Coupon::findByCode($this->coupon);

            if (!$coupon || !$coupon->isValid()) {
                // Re-calculate the total
                $this->price = $this->totalPrice;

                $this->validCoupon = null;
                $this->coupon = null;

                $this->error('The coupon is invalid or expired.');

                return;
            }

            $this->validCoupon = $coupon;

            $this->price = $coupon->afterDiscount($this->totalPrice);

            $this->success('Coupon is applied successfully!');
        }
    }

    public function updatedTeamId()
    {
        $this->switchTeam();
    }

    /**
     * Show register modal when user click Publish Job without logged in.
     */
    public function showRegisterModal()
    {
        $this->registerModalOpen = true;
    }

    /**
     * A guest can see the form but force him to register an account first.
     */
    public function register()
    {
        $data = array_merge($this->register, ['role' => 'Client']);

        event(new Registered($user = (new CreateNewUser)->create($data)));

        // Login
        resolve(StatefulGuard::class)->login($user);

        // Emit an event to Navigation component to reload the user information.
        $this->emitTo('navigation', 'LoggedIn');

        // Set the the current team is default company.
        $this->setTeamId();

        // Close register modal.
        $this->registerModalOpen = false;

        $this->success('Register an account successfully! You can upload your company logo and add a payment method now.');
    }

    /**
     * Save the job.
     */
    public function save()
    {
        $validated = $this->whenFails(fn() => $this->alertInvalidInput())->validate($this->rules());

        // Make sure users have their default payment method.
        if (!Auth::user()->hasDefaultPaymentMethod()) {
            $this->error('You have not setup your default payment method yet. Please setup one!');

            return;
        }

        DB::beginTransaction();

        try {
            // Store logo
            $this->storeLogo();

            // Save job
            $job = Job::create(collect($validated)->except('selected_tags')->all());

            // Attach maximum 5 tags to job
            $job->tags()->attach(collect($this->selected_tags)->take(5)->all());

            // Attach job addons to job
            $job->addons()->attach($this->selected_addons);

            // Redeem coupon
            if ($this->coupon) {
                $redeemedCoupon = $job->redeemCoupon($this->coupon, $this->totalPrice);
            }

            // Get the grand total price.
            $price = isset($redeemedCoupon) ? $redeemedCoupon->after_discount_price : $this->totalPrice;

            // Charge via user's default payment method
            // Note: Stripe accepts charges in cents
            $invoice = Auth::user()->invoiceFor('Publish job: ' . $this->title, $price * 100);

            // Save a transaction into the database
            $job->transactions()->create($this->prepareTransaction($invoice)->all());
        } catch (\Exception $exception) {
            DB::rollBack();

            report($exception);

            $this->error('There is an error please contact our support team. Don\'t worry, your card won\'t be charge.');

            return;
        }

        DB::commit();

        event(new JobWasCreated($job));

        $this->redirectRoute('jobs.show', [
            'team' => $job->company,
            'job' => $job
        ]);
    }

    private function rules()
    {
        return [
            'title'             => 'required|max:254',
            'description'       => 'required|min:50',
            'team_id'           => 'required|' . Rule::in(Auth::user()->allTeams()->pluck('id')),
            'apply_type'        => 'required|' . Rule::in(['link', 'email']),
            'apply_value'       => 'required',
            'payment_type'      => 'required|' . Rule::in(['hourly', 'fixed']),
            'budget'            => 'nullable|numeric|min:0',
            'is_remote'         => 'boolean',
            'location'          => 'nullable|max:254',
            'selected_tags'     => ['required', new ValidTags],
            'selected_addons'   => [new ValidJobAddons],
            'line1'             => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'city'              => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'country'           => 'required_if:selected_payment_method,new-card|nullable|string|size:2',
            'postal_code'       => 'required_if:selected_payment_method,new-card|nullable|numeric',
            'state'             => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'card_holder_name'  => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'payment_method'    => 'required_if:selected_payment_method,new-card|nullable|string|regex:/^pm/',
            'job_length_id'    => 'required',
            'hours_per_week_id' => 'required',
            'project_size_id'   => 'required',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Add/remove addon.
     *
     * @param $addonId
     */
    public function toggleAddon($addonId)
    {
        if (!in_array($addonId, $this->selected_addons)) {
            array_push($this->selected_addons, $addonId);
        } else {
            $key = array_search($addonId, $this->selected_addons);

            if ($key !== false) {
                unset($this->selected_addons[$key]);
            }
        }

        $discount = $this->validCoupon ? $this->validCoupon->discountAmount($this->totalPrice) : 0;

        $this->price = $this->totalPrice - $discount;
    }

    /**
     * Update new payment method.
     */
    public function updatePaymentMethod()
    {
        $this->validate([
            'payment_method' => 'required|string|regex:/^pm/',
        ]);

        Auth::user()->updateDefaultPaymentMethod($this->payment_method);

        $this->dispatchBrowserEvent('card', [
            'card_brand'     => Auth::user()->card_brand,
            'card_last_four' => Auth::user()->card_last_four
        ]);

        $this->success('Your payment method was updated! You can publish your job now.');
    }

    /**
     * Sum the addon prices.
     *
     * @return mixed
     */
    public function getAddonsPriceProperty()
    {
        return JobAddon::whereIn('id', $this->selected_addons)->sum('price');
    }

    /**
     * Job posting price + addons.
     *
     * @return mixed
     */
    public function getTotalPriceProperty()
    {
        return nova_get_setting('job:posting_price') + $this->addonsPrice;
    }

    /**
     * Switch current team to company value.
     */
    private function switchTeam()
    {
        $team = Jetstream::newTeamModel()->find($this->team_id);

        if ($team) {
            return Auth::user()->switchTeam($team);
        }

        $this->error('notify', 'Cannot find the company.');
    }

    /**
     * Prepare transaction to save it into database.
     *
     * @param $invoice
     * @return Transaction
     */
    private function prepareTransaction($invoice)
    {
        $payer = Auth::user();

        return new Transaction([
            'gateway'        => 'Stripe',
            'description'    => 'Publish job: ' . $this->title,
            'transaction_id' => $invoice->asStripeInvoice()->charge,
            'payer_id'       => $invoice->asStripeInvoice()->customer,
            'payer_name'     => $invoice->asStripeInvoice()->customer_name ?? $payer->name,
            'payer_email'    => $invoice->asStripeInvoice()->customer_email ?? $payer->email,
            'amount'         => (float)($invoice->asStripeInvoice()->amount_paid / 100),
            'invoice_number' => $invoice->asStripeInvoice()->id,
            'user_id'        => Auth::id()
        ]);
    }

    /**
     * Set current user's company id.
     *
     * @return void
     */
    private function setTeamId()
    {
        $this->team_id = Auth::guest() ? null : Auth::user()->currentTeam->id;
    }

    /**
     * Upload and store logo in database.
     */
    private function storeLogo()
    {
        if ($this->logo) {
            $filename = $this->logo->store('/logos', $this->logoDisk());

            Auth::user()->currentTeam->update(['logo_path' => $filename]);
        }
    }

    /**
     * Get the disk that logo should be stored on.
     *
     * @return string
     */
    private function logoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }

    public function render()
    {
        return view('livewire.jobs.new-job', [
            'companies'    => Auth::guest() ? [] : Auth::user()->allTeams(),
            'applyTypes'   => ApplyType::pluck('name', 'code'),
            'paymentTypes' => PaymentType::pluck('name', 'code'),
            'tags'         => Tag::pluck('name', 'id'),
            'addons'       => JobAddon::all(),
            'intent'       => Auth::guest() ? null : Auth::user()->createSetupIntent(),
            'jobLengths'   => JobLength::all(),
            'experienceLevels' => ExperienceLevel::all(),
            'hoursPerWeek' => HoursPerWeek::pluck('value', 'id'),
            'projectSizes' => ProjectSize::orderBy('order')->get()->toArray()
        ]);
    }
}
