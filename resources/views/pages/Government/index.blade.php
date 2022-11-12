@extends('layouts.master')
@section('PageTitle', $breadcrumb['title'])
@section('PageContent')
    @includeIf('layouts.inc.breadcrumb')
    @if (auth()->user()->can('Branche_create-government'))
    <div style=" margin-bottom: 14px; position: relative; text-align: right; ">
        <a type="button" class="btn btn-primary" href="{{ route('government.create') }}">@lang('Create new government')</a>
    </div>
    @endif

    @if ($lists->count() > 0)

        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Code')</th>
                                    <th scope="col">@lang('Created At')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>
                                            <a _href="{{ route('government.edit', $list->id) }}">
                                                {{ $list->name ?? '' }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $list->code }}
                                        </td>
                                        <td>
                                            {{ $list->created_at }}
                                        </td>
                                        <td style="display: inline-flex;">
                                            @if (auth()->user()->can('Branche_update-government'))
                                            <a style="margin-right: 5px;" class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('government.edit', $list->id) }}">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->can('Branche_delete-government'))
                                            {!! action_table_delete(route('government.destroy', $list->id), $list->id) !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{ $lists->links('layouts.inc.paginator') }}
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="row justify-content-center mt-5">
                        <div class="col-sm-4">
                            <div class="maintenance-img">
                                <img src="{{ url('assets/images/123.svg') }}" alt=""
                                    class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-5">@lang("Let's get started")</h4>
                    <p class="text-muted">@lang("Oops, We don't have data").</p>
                </div>
            </div>
        </div>


    @endif

@endsection
