<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile image.") }}
        </p>
    </header>


    <div class="mb-4 mt-4">
        <x-input-label class="mb-2 inline-block text-neutral-700 dark:text-neutral-200" :value="__('Current Image')" />

        <img src="{{ asset('') . str_replace('public', 'storage', $user->image) }}" class="h-auto max-w-full rounded-full"
            alt="{{ $user->username . ' ' . __('Profile Image') }}" style="max-height: 200px; max-width: 200px;" />
    </div>

    <form method="post" action="{{ route('image.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div class="mb-3">
            <x-input-label for="image" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                :value="__('Profile Image')" />
            <input
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                type="file" id="image" name="image" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'image-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
            @if (session('status') === 'no-image-selected')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('No Image Selected.') }}</p>
            @endif
            @if (session('status') === 'image-size-exceeded')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Image size exceeded. Maximum filesize allowed is 1.024 MB') }}
                </p>
            @endif
        </div>
    </form>
</section>
