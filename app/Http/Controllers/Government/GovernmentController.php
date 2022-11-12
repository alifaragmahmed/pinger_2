<?php

namespace App\Http\Controllers\Government;

use App\Http\Controllers\Controller;
use App\Http\Requests\Governments\CreateGovernmentRequest;
use App\Http\Requests\Governments\UpdateGovernmentRequest;
use App\Models\Government;
use Illuminate\Http\Request;

class GovernmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-government'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-government'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-government'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-government'],['only' => ['destroy']]);
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Government lists"),
            'items' =>  [
                [
                    'title' =>  __("Government Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Government::orderBy('id', 'desc')->paginate();
        return view('pages.Government.index', [
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
            'title' =>  __("Create New government"),
            'items' =>  [
                [
                    'title' =>  __(" government Lists"),
                    'url'   => route('government.index'),
                ],
                [
                    'title' =>  __("Create New  government"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.Government.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGovernmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGovernmentRequest $request)
    {
        Government::create($request->all());
        return redirect()->route('government.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  Government $Government
     * @return \Illuminate\Http\Response
     */
    public function show(Government $Government)
    {
        $breadcrumb = [
            'title' =>  __("Show Modal"),
            'items' =>  [
                [
                    'title' =>  __(" government Lists"),
                    'url'   => route('government.index'),
                ],
                [
                    'title' =>  __("Show Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Government'         =>  $Government,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Government $Government
     * @return \Illuminate\Http\Response
     */
    public function edit(Government $Government)
    {

        $breadcrumb = [
            'title' =>  __("Edit Modal"),
            'items' =>  [
                [
                    'title' =>  __(" government Lists"),
                    'url'   => route('government.index'),
                ],
                [
                    'title' =>  __("Edit Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.government.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $Government,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGovernmentRequest  $request
     * @param  Government $Government
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGovernmentRequest $request, Government $Government)
    {
        $Government->update($request->all());
        return redirect()->route('government.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Government $Government
     * @return \Illuminate\Http\Response
     */
    public function destroy(Government $Government)
    {
        $Government->delete();
        return redirect()->route('government.index')->with('success', __("This row has been deleted."));
    }
}
