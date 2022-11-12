@if ($type == 'action')
    @if (auth()->user()->can('Branche_terminal-branches'))
        <a style="margin-right: 5px;" class="btn btn-outline-secondary btn-sm edit"
            href="{{ route('branches.commander', $branch->id) }}">
            <i class="bx bx-terminal"></i>
        </a>
    @endif
    @if (auth()->user()->can('Branche_read-branches'))
        <a style="margin-right: 5px;" class="btn btn-outline-secondary btn-sm edit"
            href="{{ route('branches.show', $branch->id) }}">
            <i class="bx bx-zoom-in"></i>
        </a>
    @endif
    @if (auth()->user()->can('Branche_update-branches'))
        <a style="margin-right: 5px;" class="btn btn-outline-secondary btn-sm edit"
            href="{{ route('branches.edit', $branch->id) }}">
            <i class="bx bx-pencil"></i>
        </a>
    @endif
    @if (auth()->user()->can('Branche_delete-branches'))
        {!! action_table_delete(route('branches.destroy', $branch->id)) !!}
    @endif
@endif
