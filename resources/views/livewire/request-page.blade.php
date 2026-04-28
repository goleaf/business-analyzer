<section class="form-page">
    <div class="form-layout">
        <aside class="form-intro reveal-up">
            <p class="eyebrow eyebrow--dark">Request</p>
            <h1 class="form-intro__title">Build the operating brief.</h1>
            <p class="form-intro__text">
                Submit enough context to identify bottlenecks, momentum, and the outcomes worth optimizing first.
            </p>

            <div class="insight-list">
                @foreach ([
                    ['Context', 'What the business does, who it serves, and where the pressure is.'],
                    ['Proof', 'What is already working and where momentum exists.'],
                    ['Target', 'What should improve, by when, and how success should be measured.'],
                ] as [$title, $description])
                    <div class="insight-item">
                        <h2 class="insight-item__title">{{ $title }}</h2>
                        <p class="insight-item__text">{{ $description }}</p>
                    </div>
                @endforeach
            </div>
        </aside>

        <form wire:submit="submit" class="form-panel reveal-up reveal-up--delay">
            @if (session('status'))
                <div class="alert alert--success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="field-stack">
                <div class="field">
                    <label for="business_description" class="field__label">Business description</label>
                    <p class="field__hint">Include market, customer, team, offer, and current operating constraints.</p>
                    <textarea id="business_description" wire:model="business_description" rows="6" class="field__control"></textarea>
                    @error('business_description')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="achievements" class="field__label">Achievements</label>
                    <p class="field__hint">List recent wins, strong channels, efficiency gains, or proof that should shape the analysis.</p>
                    <textarea id="achievements" wire:model="achievements" rows="5" class="field__control"></textarea>
                    @error('achievements')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="expected_results" class="field__label">Expected results</label>
                    <p class="field__hint">Define the decision, outcome, or improvement you want the analysis to support.</p>
                    <textarea id="expected_results" wire:model="expected_results" rows="5" class="field__control"></textarea>
                    @error('expected_results')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-footer">
                <p class="form-footer__note">Saved requests are reviewed before processing.</p>
                <button type="submit" wire:loading.attr="disabled" class="button button--dark">
                    <span wire:loading.remove>Submit Request</span>
                    <span wire:loading>Submitting...</span>
                </button>
            </div>
        </form>
    </div>
</section>
