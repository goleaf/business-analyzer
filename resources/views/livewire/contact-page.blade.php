<section class="form-page">
    <div class="contact-layout">
        <div class="contact-brief reveal-up">
            <p class="eyebrow">Contact</p>
            <h1 class="contact-brief__title">Bring a real operating challenge.</h1>
            <p class="contact-brief__text">
                Share the constraint, the decision, or the improvement target. We will route it into the same structured review path.
            </p>

            <div class="contact-steps">
                <div class="contact-step">
                    <p class="contact-step__number">01</p>
                    <p class="contact-step__text">Clarify the business pressure.</p>
                </div>
                <div class="contact-step">
                    <p class="contact-step__number">02</p>
                    <p class="contact-step__text">Separate signal from noise.</p>
                </div>
                <div class="contact-step">
                    <p class="contact-step__number">03</p>
                    <p class="contact-step__text">Decide the next action.</p>
                </div>
            </div>
        </div>

        <form wire:submit="submit" class="form-panel reveal-up reveal-up--delay">
            @if (session('status'))
                <div class="alert alert--success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="field-stack">
                <div class="field">
                    <label for="name" class="field__label">Name</label>
                    <input id="name" type="text" wire:model="name" class="field__control">
                    @error('name')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="email" class="field__label">Email</label>
                    <input id="email" type="email" wire:model="email" class="field__control">
                    @error('email')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="message" class="field__label">Message</label>
                    <textarea id="message" wire:model="message" rows="7" class="field__control"></textarea>
                    @error('message')
                        <p class="field__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-footer form-footer--end">
                <button type="submit" wire:loading.attr="disabled" class="button button--dark">
                    <span wire:loading.remove>Send Message</span>
                    <span wire:loading>Sending...</span>
                </button>
            </div>
        </form>
    </div>
</section>
