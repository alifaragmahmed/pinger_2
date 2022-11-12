<?php

namespace App\Http\Controllers\SwitchModel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelSwith\CreateSwitchModalRequest;
use App\Http\Requests\ModelSwith\UpdateSwitchModalRequest;
use App\Models\SwitchModel;
use Illuminate\Http\Request;

class SwitchModelController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-switch-model'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-switch-model'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-switch-model'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-switch-model'],['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Switch models lists"),
            'items' =>  [
                [
                    'title' =>  __("Switch models Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = SwitchModel::orderBy('id', 'desc')->paginate();
        return view('pages.switch-model.index', [
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
            'title' =>  __("Create New Switch model"),
            'items' =>  [
                [
                    'title' =>  __(" Switch model Lists"),
                    'url'   => route('switch-model.index'),
                ],
                [
                    'title' =>  __("Create New  Switch model"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.switch-model.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSwitchModalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSwitchModalRequest $request)
    {
        SwitchModel::create($request->all());
        return redirect()->route('switch-model.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  SwitchModel $model
     * @return \Illuminate\Http\Response
     */
    public function show(SwitchModel $model)
    {
        $breadcrumb = [
            'title' =>  __("Show model"),
            'items' =>  [
                [
                    'title' =>  __(" Switch model Lists"),
                    'url'   => route('switch-model.index'),
                ],
                [
                    'title' =>  __("Show model"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Router'         =>  $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SwitchModel $model
     * @return \Illuminate\Http\Response
     */
    public function edit(SwitchModel $SwitchModel)
    {

        $breadcrumb = [
            'title' =>  __("Edit model"),
            'items' =>  [
                [
                    'title' =>  __(" Switch model Lists"),
                    'url'   => route('switch-model.index'),
                ],
                [
                    'title' =>  __("Edit model"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.switch-model.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $SwitchModel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSwitchModalRequest  $request
     * @param  SwitchModel $model
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSwitchModalRequest $request, SwitchModel $SwitchModel)
    {
        $SwitchModel->update($request->all());
        return redirect()->route('switch-model.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SwitchModel $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(SwitchModel $SwitchModel)
    {
        $SwitchModel->delete();
        return redirect()->route('switch-model.index')->with('success', __("This row has been deleted."));
    }
}
