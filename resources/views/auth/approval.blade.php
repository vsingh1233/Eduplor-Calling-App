<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-center">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Account Pending Approval</h2>
        <p>Your registration was successful, but an administrator needs to activate your account before you can access the dashboard.</p>
        <p class="mt-4">Please contact your manager or system administrator.</p>
    </div>

    <div class="mt-6 flex items-center justify-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>