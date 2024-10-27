<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <!-- {{ __('Profile Picture') }} -->
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your profile picture.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.upload') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div>
            <label for="profile_picture" class="block font-medium text-sm text-gray-700">{{ __('Profile Picture') }}</label>
            @if($user->profile && $user->profile->profile_picture)
                <div class="mt-2">
                <img src="{{ Storage::url('public/profile_picture/' . $user->profile->profile_picture) }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
                </div>
            @endif
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" required>
            @error('profile_picture')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <br>
        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Upload') }}
            </button>

            @if (session('status') === 'profile-picture-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Uploaded.') }}</p>
            @endif
        </div>
    </form>
</section>