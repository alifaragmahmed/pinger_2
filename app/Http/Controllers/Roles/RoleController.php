<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-roles'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-roles'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-roles'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-roles'],['only' => ['destroy']]);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Roles lists"),
            'items' =>  [
                [
                    'title' =>  __("Roles Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Role::orderBy('id', 'desc')->paginate();
        return view('pages.roles.index', [
            'breadcrumb' => $breadcrumb,
            'lists'     => $lists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = [
            'title' =>  __("Create Role"),
            'items' =>  [
                [
                    'title' =>  __("Roles Lists"),
                    'url'   => route('roles.index'),
                ],
                [
                    'title' =>  __("Create Role"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.roles.create', [
            'breadcrumb' => $breadcrumb,
            'permissions' => Permission::get()->groupBy('category'),

        ]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store the data in db
        $validator = validator($request->all(),$this->rules());
        if($validator->fails()){
            session()->flash('error', $validator->errors());
            return back();
        }
        try {
            $data = $request->except('permissions');
            $data['guard_name'] = 'web';
            DB::beginTransaction();
            $resource = Role::create($data);

            $resource->syncPermissions($request->permissions);
            DB::commit();

            return redirect()->route('roles.index')->with('success', __("This row has been created."));
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $breadcrumb = [
            'title' =>  __("Edit Role"),
            'items' =>  [
                [
                    'title' =>  __("Roles Lists"),
                    'url'   => route('roles.create'),
                ],
                [
                    'title' =>  __("Edit Role"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.roles.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $role,
            'permissions' => Permission::get()->groupBy('category'),
            'rolePermissions' => $role->permissions->pluck('id')->all(),


        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Network $network
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = validator($request->all(),$this->rules());
        if($validator->fails()){
            session()->flash('error', $validator->errors());
            return back();
        }

        try {
            $data = $request->except('permissions');
            $data['guard_name'] = 'web';
            DB::beginTransaction();
            $role->update($data);

            $role->syncPermissions($request->permissions);
            DB::commit();

            return redirect()->route('roles.index')->with('success', __("This row has been updated."));
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', __("This row has been deleted."));
    }

    public function rules() {
        // set all rules of validation
        return [
            'name'=>'required|string|max:150',
        ];
    }
}
