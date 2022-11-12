<?php

namespace App\Http\Controllers\Level;

use App\Http\Controllers\Controller;
use App\Http\Requests\Level\CreateLevelRequest;
use App\Http\Requests\Level\UpdateLevelRequest;
use App\Models\BranchLevel;

class LevelController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-level'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-level'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-level'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-level'],['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Branch level lists"),
            'items' =>  [
                [
                    'title' =>  __("Branch level Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = BranchLevel::orderBy('id', 'desc')->paginate();
        return view('pages.levels.index', [
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
            'title' =>  __("Create New BranchLevel"),
            'items' =>  [
                [
                    'title' =>  __("Branch level Lists"),
                    'url'   => route('levels.index'),
                ],
                [
                    'title' =>  __("Create New BranchLevel"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.levels.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLevelRequest $request)
    {
        BranchLevel::create($request->all());
        return redirect()->route('levels.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  BranchLevel $level
     * @return \Illuminate\Http\Response
     */
    public function show(BranchLevel $level)
    {
        $breadcrumb = [
            'title' =>  __("Show BranchLevel"),
            'items' =>  [
                [
                    'title' =>  __("Branch level Lists"),
                    'url'   => route('levels.index'),
                ],
                [
                    'title' =>  __("Show BranchLevel"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.levels.show', [
            'breadcrumb'    =>  $breadcrumb,
            'BranchLevel'         =>  $level,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BranchLevel $level
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchLevel $level)
    {
        $breadcrumb = [
            'title' =>  __("Edit BranchLevel"),
            'items' =>  [
                [
                    'title' =>  __("Branch level Lists"),
                    'url'   => route('levels.index'),
                ],
                [
                    'title' =>  __("Edit BranchLevel"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.levels.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $level,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLevelRequest  $request
     * @param  BranchLevel $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLevelRequest $request, BranchLevel $level)
    {
        $level->update($request->all());
        return redirect()->route('levels.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BranchLevel $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchLevel $level)
    {
        $level->delete();
        return redirect()->route('levels.index')->with('success', __("This row has been deleted."));
    }
}
