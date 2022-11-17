@extends('layouts.master')
@section('PageTitle', $breadcrumb['title'])
@section('css')
{{--
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    --}}
    <link href="{{ url('/assets/css/datatable/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/datatable/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <style>
        .select2-selection--multiple {
            padding-top: 20px!important;
        }
        #branchesTable > tbody > tr > td:nth-child(14),
        #branchesTable > tbody > tr > td:nth-child(15),
        #branchesTable > tbody > tr > td:nth-child(16),
        #branchesTable > tbody > tr > td:nth-child(17),
        #branchesTable > tbody > tr > td:nth-child(18),
        #branchesTable > tbody > tr > td:nth-child(19),
        #branchesTable > tbody > tr > td:nth-child(20),
        #branchesTable > tbody > tr > td:nth-child(21),
        #branchesTable > tbody > tr > td:nth-child(22),
        #branchesTable > tbody > tr > td:nth-child(23),
        #branchesTable > tbody > tr > td:nth-child(24),
        #branchesTable > tbody > tr > td:nth-child(25),
        #branchesTable > tbody > tr > td:nth-child(26),
        #branchesTable > tbody > tr > td:nth-child(27),
        #branchesTable > tbody > tr > td:nth-child(28),
        #branchesTable > tbody > tr > td:nth-child(29),
        #branchesTable > tbody > tr > td:nth-child(30),
        #branchesTable > tbody > tr > td:nth-child(31),
        #branchesTable > tbody > tr > td:nth-child(32),
        #branchesTable > tbody > tr > td:nth-child(33),
        #branchesTable > tbody > tr > td:nth-child(34),
        #branchesTable > tbody > tr > td:nth-child(35)
        {
            /* display: none */
        }
    </style>
@endsection
@section('PageContent')
    @includeIf('layouts.inc.breadcrumb')

    <div
        style="margin-bottom: 14px; position: relative; display: flex; justify-content: space-between; align-items: center;">
        @if (auth()->user()->can('Branche_import-branches'))
            <form method="POST" enctype="multipart/form-data" action="{{ route('branches.import') }}"
                style="display: flex; justify-content: space-between; gap: 10px">
                @csrf
                <div style="height: 40px;">
                    <input required type="file" class="form-control" name="file" />
                </div>
                <button type="submit" class="btn btn-success">@lang('Import')</button>
                <a role="button" href="{{ route('branches.downloadTemplate') }}" class="btn btn-primary">@lang('Download Template File')</a>
            </form>
        @endif

        @if (auth()->user()->can('Branche_create-branches'))
            <a type="button" class="btn btn-primary float-start"
                href="{{ route('branches.create') }}">@lang('Create new branche')</a>
        @endif
    </div>
    @if (auth()->user()->can('Branche_search-filter-branches'))
        <div class="filter ">
                <div class="card">

                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 pt-2">
                                <div class="form-floating">
                                    <input onkeyup="reloadData()" id="keyword" type="text" class="form-control" style="height: 58px;" name="keyword"
                                        value="{{ request('keyword') }}" placeholder="@lang('Search...') }}" />
                                    <label style="margin-top: -10px;">@lang('Search...')</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    @endif
    @if (auth()->user()->can('Branche_filter-branches'))
        <div class="filter">
            <form method="GET" action="{{ route('branches.index') }}" __onsubmit="$('#exportInput').val('0')">
                <div class="card">
                    <div class="card-header">
                        <button type="button" id="filter" class="btn btn-default">
                            <b class="h4" >@lang('Filter')</b>
                        </button>
                    </div>
                    <div class="card-body " id="filter-body" _style="display: none" >
                        <div class="row">

                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <select id="project_id" multiple class="form-control select2" name="project_id"placeholder="@lang('Project')">
                                        @foreach ($projects as $project)
                                            <option
                                                {{ !empty(request('project_id')) ? (in_array($project->id, request('project_id')) ? 'selected' : '') : '' }}
                                                value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Project')</label>

                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <select id="ups_installation_id" multiple class="form-control select2"name="ups_installation_id"placeholder="@lang('UPS installation') ">
                                        @foreach ($upsInstallations as $ups)
                                            <option
                                                {{ !empty(request('ups_installation_id')) ? (in_array($ups->id, request('ups_installation_id')) ? 'selected' : '') : '' }}
                                                value="{{ $ups->id }}">{{ $ups->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Ups Installation')</label>

                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <select id="line_type_id" multiple class="form-control select2"
                                        name="line_type_id"placeholder="@lang('Line Type') " >
                                        @foreach ($lineTypes as $line)
                                            <option
                                                {{ !empty(request('line_type_id')) ? (in_array($line->id, request('line_type_id')) ? 'selected' : '') : '' }}
                                                value="{{ $line->id }}">{{ $line->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Line Type')</label>

                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <select id="sector" multiple class="form-control select2" name="sector" placeholder="@lang('Sector')"
                                        >
                                        @foreach ($sectors as $key => $sector)
                                            <option
                                                {{ !empty(request('sector')) ? (in_array($sector, request('sector')) ? 'selected' : '') : '' }}
                                                value="{{ $sector }}">{{ $sector }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Sector')</label>

                                </div>
                            </div>



                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <select id="area" multiple class="form-control select2" name="area" placeholder="@lang('Area')"
                                        >
                                        @foreach ($areas as $key => $area)
                                            <option
                                                {{ !empty(request('area')) ? (in_array($area, request('area')) ? 'selected' : '') : '' }}
                                                value="{{ $area }}">{{ $area }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Area')</label>
                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <div class="form-floating">
                                    <style>
                                        .select2-selection__rendered {
                                            text-align: center !important
                                        }
                                    </style>
                                    <select multiple id="work_day" class="form-control select2" name="work_day"placeholder="@lang('Working Days') "
                                    >
                                        @foreach ($days as $key => $val)
                                            <option
                                            {{ !empty(request('work_day')) ? (in_array($key, request('work_day')) ? 'selected' : '') : '' }}
                                                value="{{ $key }}">{{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>@lang('Working Days')</label>

                                </div>
                            </div>
                            <div class="col-md-4 pt-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input id="start_time" type="time" class="form-control" name="start_time"
                                                value="{{ request()->start_time }}">
                                            <label>@lang('Start Time')</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input id="end_time" type="time" class="form-control" name="end_time"
                                                value="{{ request()->end_time }}">
                                            <label>@lang('End Time')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" id="exportInput" name="export">
                        <button onclick="reloadData()" type="button"  class="btn btn-success">@lang('Search')</button>
                        <a href="{{ route('branches.index') }}"  class="btn bg-light btn-default">@lang('Clear')</a>
                        {{-- @if (auth()->user()->can('Branche_export-branches'))
                        <button type="submit" onclick="exportFile()" class="btn btn-primary">@lang('Export')</button>
                        @endif --}}
                    </div>
                </div>
            </form>
        </div>
    @endif
    @if ($lists->count() > 0)

        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless" id="branchesTable">
                            <thead>
                                <tr style="background-color: lightgray" >
                                    <th scope="col">@lang('Action')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Area')</th>
                                    <th scope="col">@lang('Sector')</th>
                                    <th scope="col">@lang('Address')</th>
                                    <th scope="col">@lang('Main Order ID')</th>
                                    <th scope="col">@lang('Backup Order ID')</th>
                                    <th scope="col">@lang('Project')</th>
                                    <th scope="col">@lang('Wan IP')</th>
                                    <th scope="col">@lang('Tunnel Ip')</th>
                                    <th scope="col">@lang('Lan IP')</th>
                                    <th scope="col">@lang('Additional Ips ')</th>
                                    <th scope="col">@lang('IP Notes')</th>
                                    <th scope="col">@lang('Notes ')</th>
                                    <th scope="col">@lang('Network ')</th>
                                    <th scope="col">@lang('Line Type')</th>
                                    <th scope="col">@lang('Line Capacity ')</th>
                                    <th scope="col">@lang('Technical Support Name')</th>
                                    <th scope="col">@lang('Technical Support Phone')</th>
                                    <th scope="col">@lang('Branch Manager Name')</th>
                                    <th scope="col">@lang('Branch Manager Phone')</th>
                                    <th scope="col">@lang('Telephone')</th>
                                    <th scope="col">@lang('Viop No')</th>
                                    <th scope="col">@lang('Branc Level ')</th>
                                    <th scope="col">@lang('Working Days')</th>
                                    <th scope="col">@lang('Start Time')</th>
                                    <th scope="col">@lang('End Time')</th>
                                    <th scope="col">@lang('Financial Code')</th>
                                    <th scope="col">@lang('Post Number')</th>
                                    <th scope="col">@lang('Modeling')</th>
                                    <th scope="col">@lang('Ups Installations')</th>
                                    <th scope="col">@lang('Entuity Status ')</th>
                                    <th scope="col">@lang('Add On Entuity ')</th>
                                    <th scope="col">@lang('Router Serial ')</th>
                                    <th scope="col">@lang('Router Model ')</th>
                                    <th scope="col">@lang('Entuity System Name ')</th>
                                    <th scope="col">@lang('Switch Serial ')</th>
                                    <th scope="col">@lang('Switch Model ')</th>
                                    <th scope="col">@lang('Switch IP')</th>
                                    <th scope="col">@lang('Switch Notes')</th>
                                    <th scope="col">@lang('Atm Exists')</th>
                                    <th scope="col">@lang('Atm Ip')</th>
                                    <th scope="col">@lang('Installation And Commissioning')</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{ $lists->links('layouts.inc.paginator') }} --}}
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
@push('scripts')
<script src="{{ asset('assets/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/dataTables.bootstrap5.min.js') }}"></script>

<script type="text/javascript" src="{{ url('/') }}/assets/js/datatable/dataTables.buttons.min.js"></script>
<script src="{{ url('/') }}/assets/js/datatable/buttons.bootstrap.js"></script>
<script type="text/javascript" src="{{ url('/') }}/assets/js/datatable/buttons.html5.min.js"></script>
<script src="{{ asset('assets/js/datatable/jszip.min.js') }}"></script>
<script src="{{ url('/') }}/assets/js/datatable/buttons.print.js"></script>
<script src="{{ asset('assets/js/datatable/dataTables.buttons.min.js') }}"></script>


    <script>
        $('#filter').on('click', function() {
            $('#filter-body').slideToggle('slow');
        });

        $('#filter-body').slideToggle('slow');

        $('.select2').select2({});



        function exportFile() {
            $('#exportInput').val('1');
            setTimeout(() => {
                $('#exportInput').val('0');
            }, 1000);
        }

        function clearFilter() {
            $("#project_id").val('');
            $("#ups_installation_id").val('');
            $("#line_type_id").val('');
            $("#sector").val('');
            $("#area").val('');
            $("#work_day").val('');
            $("#start_time").val('');
            $("#end_time").val('');
            $("#keyword").val('');
            $(".select2").select2();
            var url = "{{ route('branches.getData') }}";
            BranchesDatatable.ajax.url(url).load();
        }


        function reloadData() {
            var url = "{{ route('branches.getData') }}";
            var data = {
                project_id: $("#project_id").val(),
                ups_installation_id: $("#ups_installation_id").val(),
                line_type_id: $("#line_type_id").val(),
                sector: $("#sector").val(),
                area: $("#area").val(),
                work_day: $("#work_day").val(),
                start_time: $("#start_time").val(),
                end_time: $("#end_time").val(),
                keyword: $("#keyword").val(),
            };
            console.log(data);
            //var url = "{{ route('branches.getData') }}?project_id=" + project_id+"&ups_installation_id="+ ups_installation_id+"&line_type_id="+line_type_id+"&sector="+sector+"&work_days="+work_days+"&start_time="+start_time+"&end_time="+end_time;
            BranchesDatatable.ajax.url(url + "?" + $.param(data)).load();
        }

        var BranchesDatatable = null;
        function setBranchesDataTable() {
            var url = "{{ route('branches.getData') }}";
            BranchesDatatable = $('#branchesTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    //"pageLength": 5,
                    "bFilter": false,
                    "lengthMenu": [[10, 25, 50, 100,200,300 , 500 , 1000 , 2000 , 5000 , 10000], [10, 25, 50, 100,200,300 , 500 , 1000 , 2000 , 5000 , 10000]],
                    @if (auth()->user()->can('Branche_export-branches'))
                   dom: 'lBfrtip',
                    buttons: [
                            // 'copyHtml5',
                            {
                            extend: 'excelHtml5',
                            className: 'btn buttons-excel  buttons-html5 btn-primary',
                            text: 'Export',

                            },
                            // 'csvHtml5',
                            // 'pdfHtml5'
                    ],
                    @endif
                    "sorting": [0, 'DESC'],
                    "ajax": url,
                    "columns":[
                    { "data": "action" },
                    { "data": "name" },
                    { "data": "area" },
                    { "data": "sector" },
                    { "data": "address" },
                    { "data": "main_order_id" },
                    { "data": "backup_order_id" },
                    { "data": "project_id" },
                    { "data": "wan_ip" },
                    { "data": "tunnel_ip" },
                    { "data": "lan_ip" },
                    { "data": "additional_ips" },
                    { "data": "ip_notes" },
                    { "data": "notes" },
                    { "data": "network_id" },
                    { "data": "line_type_id" },
                    { "data": "line_capacity_id" },
                    { "data": "technical_support_name" },
                    { "data": "technical_support_phone" },
                    { "data": "branch_manager_name" },
                    { "data": "branch_manager_phone" },
                    { "data": "telephone" },
                    { "data": "viop_no" },
                    { "data": "brance_level_id" },
                    { "data": "working_days" },
                    { "data": "start_time" },
                    { "data": "end_time" },
                    { "data": "financial_code" },
                    { "data": "post_number" },
                    { "data": "modeling" },
                    { "data": "ups_installation_id" },
                    { "data": "entuity_status_id" },
                    { "data": "added_on_entuity" },
                    { "data": "router_serial" },
                    { "data": "router_model_id" },
                    { "data": "entuity_systemname" },
                    { "data": "switch_serial" },
                    { "data": "switch_model_id" },
                    { "data": "switch_ip" },
                    { "data": "switch_nots" },
                    { "data": "atm_exists" },
                    { "data": "atm_ip" },
                    { "data": "installation_and_commissioning" },

                    ]
            });
        }

        $(function() {
            setBranchesDataTable();
        });
    </script>
@endpush
