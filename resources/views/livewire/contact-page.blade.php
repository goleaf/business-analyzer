<section class="mx-auto max-w-3xl px-4 py-12 lg:px-8 lg:py-16">
    <div class="mb-8 space-y-3">
        <p class="text-sm font-semibold uppercase tracking-normal text-teal-700">Contact</p>
        <h1 class="text-3xl font-semibold tracking-normal text-zinc-950 sm:text-4xl">Send a message</h1>
    </div>

    <form wire:submit="submit" class="space-y-6 rounded-md border border-zinc-200 bg-white p-6">
        @if (session('status'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-medium text-zinc-900">Name</label>
            <input id="name" type="text" wire:model="name" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20">
            @error('name')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-zinc-900">Email</label>
            <input id="email" type="email" wire:model="email" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20">
            @error('email')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-zinc-900">Message</label>
            <textarea id="message" wire:model="message" rows="6" class="mt-2 block w-full rounded-md border border-zinc-300 px-3 py-2 text-zinc-950 shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/20"></textarea>
            @error('message')
                <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" wire:loading.attr="disabled" class="rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-60">
                Send Message
            </button>
        </div>
    </form>
</section>
