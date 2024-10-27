<section>
    <header>
        <!-- <h2 class="text-lg font-medium text-gray-900">
        {{ __("Update your account's profile information.") }}
        </h2> -->

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="bio" class="block font-medium text-sm text-gray-700">{{ __('Bio') }}</label>
            <textarea id="bio" name="bio" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" autocomplete="bio">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            @error('bio')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="address" class="block font-medium text-sm text-gray-700">{{ __('Address') }}</label>
            <input id="address" name="address" type="text" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('address', $user->profile->address ?? '') }}" autocomplete="address">
            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone_number" class="block font-medium text-sm text-gray-700">{{ __('Phone Number') }}</label>
            <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}" autocomplete="tel">
            @error('phone_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <br>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>