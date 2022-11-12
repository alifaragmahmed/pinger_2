<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-project'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-project'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-project'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-project'],['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Projects lists"),
            'items' =>  [
                [
                    'title' =>  __("Projects Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Project::orderBy('id', 'desc')->paginate();
        return view('pages.projects.index', [
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
            'title' =>  __("Create New Project"),
            'items' =>  [
                [
                    'title' =>  __("Projects Lists"),
                    'url'   => route('projects.index'),
                ],
                [
                    'title' =>  __("Create New Project"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.projects.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        Project::create($request->all());
        return redirect()->route('projects.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  Project $Project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $Project)
    {
        $breadcrumb = [
            'title' =>  __("Show Project"),
            'items' =>  [
                [
                    'title' =>  __("Projects Lists"),
                    'url'   => route('projects.index'),
                ],
                [
                    'title' =>  __("Show Project"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.projects.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Project'         =>  $Project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project $Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $Project)
    {
        $breadcrumb = [
            'title' =>  __("Edit Project"),
            'items' =>  [
                [
                    'title' =>  __("Projects Lists"),
                    'url'   => route('projects.index'),
                ],
                [
                    'title' =>  __("Edit Project"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.projects.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $Project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project $Project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $Project)
    {
        $Project->update($request->all());
        return redirect()->route('projects.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project $Project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $Project)
    {
        $Project->delete();
        return redirect()->route('projects.index')->with('success', __("This row has been deleted."));
    }
}
