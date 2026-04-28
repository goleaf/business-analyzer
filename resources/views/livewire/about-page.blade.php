<div class="home-page">
    <section class="hero">
        <div class="hero__background" aria-hidden="true"></div>

        <div class="hero__inner">
            <div class="hero__copy reveal-up">
                <p class="eyebrow">Operational intelligence</p>
                <h1 class="hero__title">
                    Business Analyzer
                </h1>
                <p class="hero__text">
                    Turn scattered business context into a clear operating picture, prioritized next moves, and AI-ready analysis.
                </p>
                <div class="hero__actions">
                    <a href="{{ route('public.request') }}" class="button button--primary">
                        Start diagnostic
                    </a>
                    <a href="{{ route('public.contact') }}" class="button button--ghost">
                        Talk to us
                    </a>
                </div>
            </div>

            <div class="hero__visual reveal-up reveal-up--delay">
                <img src="{{ asset('images/operations-map.svg') }}" alt="Operational analysis workspace" class="hero__image">
                <div class="hero__metrics">
                    <div class="metric">
                        <p class="metric__value">4</p>
                        <p class="metric__label">decision inputs</p>
                    </div>
                    <div class="metric">
                        <p class="metric__value">90d</p>
                        <p class="metric__label">action horizon</p>
                    </div>
                    <div class="metric">
                        <p class="metric__value">1</p>
                        <p class="metric__label">ranked plan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section--split">
        <div class="section__intro">
            <div>
                <p class="eyebrow eyebrow--dark">What changes</p>
                <h2 class="section__title">Less guessing. More controlled improvement.</h2>
            </div>
            <div class="proof-grid">
                <div class="proof-item">
                    <p class="proof-item__title">Map</p>
                    <p class="proof-item__text">Capture current operations, recent wins, and the performance target in one structured request.</p>
                </div>
                <div class="proof-item">
                    <p class="proof-item__title">Score</p>
                    <p class="proof-item__text">Review what matters first: constraints, leverage points, and measurable operating outcomes.</p>
                </div>
                <div class="proof-item">
                    <p class="proof-item__title">Move</p>
                    <p class="proof-item__text">Prepare a focused AI-assisted analysis that turns the request into next-step priorities.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section--white">
        <div class="section__inner">
            <div class="section__header">
                <div>
                    <p class="eyebrow eyebrow--dark">Operating loop</p>
                    <h2 class="section__title">A clean path from intake to action.</h2>
                </div>
                <p class="section__text">
                    The workflow mirrors the strongest process optimization sites: assess the current state, define the gap, execute the sprint, and keep improving.
                </p>
            </div>

            <div class="process-list">
                @foreach ([
                    ['01', 'Diagnostic intake', 'Submit context, achievements, and expected results without forcing a premature solution.'],
                    ['02', 'Admin review', 'Keep human judgment in the loop before AI processing starts.'],
                    ['03', 'Prompt orchestration', 'Use ordered prompts to keep analysis consistent across every request.'],
                    ['04', 'Priority output', 'Prepare concise recommendations that can become a 30, 60, or 90 day operating plan.'],
                ] as [$step, $title, $description])
                    <div class="process-step">
                        <p class="process-step__number">{{ $step }}</p>
                        <h3 class="process-step__title">{{ $title }}</h3>
                        <p class="process-step__text">{{ $description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="final-cta">
            <div class="final-cta__glow" aria-hidden="true"></div>
            <div class="final-cta__content">
                <div>
                    <p class="eyebrow">Start with facts</p>
                    <h2 class="final-cta__title">Give the analyzer enough signal to find the highest leverage moves.</h2>
                </div>
                <a href="{{ route('public.request') }}" class="button button--light">
                    Submit request
                </a>
            </div>
        </div>
    </section>
</div>
