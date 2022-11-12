<?php

namespace App\Http\Controllers\LineCapaties;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineCapacity\CreateLineCapacityRequest;
use App\Http\Requests\LineCapacity\UpdateLineCapacityRequest;
use App\Models\LineCapacitie;
use Illuminate\Http\Request;

class LineCapacityController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-line-capacity'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-line-capacity'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-line-capacity'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-line-capacity'],['only' => ['destroy']]);
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("line capacities lists"),
            'items' =>  [
                [
                    'title' =>  __("line capacities Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = LineCapacitie::orderBy('id', 'desc')->paginate();
        return view('pages.line-capacities.index', [
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
            'title' =>  __("Create New line capacities"),
            'items' =>  [
                [
                    'title' =>  __(" line capacities Lists"),
                    'url'   => route('line-capacities.index'),
                ],
                [
                    'title' =>  __("Create New  line capacities"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.line-capacities.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLineCapacityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLineCapacityRequest $request)
    {
        LineCapacitie::create($request->all());
        return redirect()->route('line-capacities.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  LineCapacitie LineCapacitie
     * @return \Illuminate\Http\Response
     */
    public function show(LineCapacitie $line_capacity)
    {
        $breadcrumb = [
            'title' =>  __("Show Modal"),
            'items' =>  [
                [
                    'title' =>  __(" line capacities Lists"),
                    'url'   => route('line-capacities.index'),
                ],
                [
                    'title' =>  __("Show Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Router'         =>  $line_capacity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LineCapacitie $line_capacity
     * @return \Illuminate\Http\Response
     */
    public function edit(LineCapacitie $line_capacity)
    {
        $breadcrumb = [
            'title' =>  __("Edit Line"),
            'items' =>  [
                [
                    'title' =>  __(" line capacities Lists"),
                    'url'   => route('line-capacities.index'),
                ],
                [
                    'title' =>  __("Edit Line"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.line-capacities.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $line_capacity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLineCapacityRequest  $request
     * @param  LineCapacitie $line_capacity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLineCapacityRequest $request, LineCapacitie $line_capacity)
    {
        $line_capacity->update($request->all());
        return redirect()->route('line-capacities.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  LineCapacitie $line_capacity
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineCapacitie $line_capacity)
    {
        $line_capacity->delete();
        return redirect()->route('line-capacities.index')->with('success', __("This row has been deleted."));
    }
}
