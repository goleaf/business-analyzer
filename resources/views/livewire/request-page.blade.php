<section class="mx-auto max-w-4xl px-4 py-12 lg:px-8 lg:py-16">
    <div class="mb-8 space-y-3">
        <p class="text-sm font-semibold uppercase tracking-normal text-teal-700">Request</p>
        <h1 class="text-3xl font-semibold tracking-normal text-zinc-950 sm:text-4xl">Submit business data</h1>
    </div>

    <form wire:submit="submit" class="space-y-6 rounded-md border border-zinc-200 bg-white p-6">
        @if (session('status'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label for="business_description" class="block text-sm font-medium text-zinc-900">Business description</label>
            <textarea id="business_description" wire:model="business_description" rows="5" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20"></textarea>
            @error('business_description')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="achievements" class="block text-sm font-medium text-zinc-900">Achievements</label>
            <textarea id="achievements" wire:model="achievements" rows="5" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20"></textarea>
            @error('achievements')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expected_results" class="block text-sm font-medium text-zinc-900">Expected results</label>
            <textarea id="expected_results" wire:model="expected_results" rows="5" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20"></textarea>
            @error('expected_results')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" wire:loading.attr="disabled" class="rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-60">
                Submit Request
            </button>
        </div>
    </form>
</section>
