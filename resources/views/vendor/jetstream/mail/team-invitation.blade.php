@php use Spatie\Permission\Models\Role; @endphp
@component('mail::message')

    <strong>{{ $invitation->inviter->name }}</strong> has invited you to join the
    <strong>{{ $invitation->team->name }}</strong> team as a(n)
    <strong>{{ Role::findByName($invitation->role)->name }}</strong>!

    <hr><br>

    {{ $invitation->inviter->name }} says:<br>
    "{{ Trans::get($invitation->message) }}"

    <br>
    <hr><br>

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        {{ Trans::get('If you do not have an account, you may create one by clicking the button below. After creating an account, you may click the invitation acceptance button in this email to accept the team invitation:') }}

        @component('mail::button', ['url' => route('register')])
            {{ Trans::get('Create Account') }}
        @endcomponent

        {{ Trans::get('If you already have an account, you may accept this invitation by clicking the button below:') }}

    @else
        {{ Trans::get('You may accept this invitation by clicking the button below:') }}
    @endif


    @component('mail::button', ['url' => $acceptUrl])
        {{ Trans::get('Accept Invitation') }}
    @endcomponent

    {{ Trans::get('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
