@if ($crud->hasAccess('update'))
    <form method="POST" action="{{ route('request-submissions.process-data', $entry) }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-sm btn-primary" title="Process Data">
            Process Data
        </button>
    </form>
@endif
