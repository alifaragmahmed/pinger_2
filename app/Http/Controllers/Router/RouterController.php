<?php

namespace App\Http\Controllers\Router;

use App\Http\Controllers\Controller;
use App\Http\Requests\Router\CreateRouterRequest;
use App\Http\Requests\Router\UpdateRouterRequest;
use App\Models\Router;
use Illuminate\Http\Request;

class RouterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-router-type'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-router-type'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-router-type'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-router-type'],['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Router lists"),
            'items' =>  [
                [
                    'title' =>  __("Router Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Router::orderBy('id', 'desc')->paginate();
        return view('pages.routers.index', [
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
            'title' =>  __("Create New Router"),
            'items' =>  [
                [
                    'title' =>  __("Router Lists"),
                    'url'   => route('routers.index'),
                ],
                [
                    'title' =>  __("Create New Router"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.routers.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRouterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRouterRequest $request)
    {
        Router::create($request->all());
        return redirect()->route('routers.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  Router $router
     * @return \Illuminate\Http\Response
     */
    public function show(Router $router)
    {
        $breadcrumb = [
            'title' =>  __("Show Router"),
            'items' =>  [
                [
                    'title' =>  __("Router Lists"),
                    'url'   => route('routers.index'),
                ],
                [
                    'title' =>  __("Show Router"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Router'         =>  $router,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Router $router
     * @return \Illuminate\Http\Response
     */
    public function edit(Router $router)
    {
        $breadcrumb = [
            'title' =>  __("Edit Router"),
            'items' =>  [
                [
                    'title' =>  __("Router Lists"),
                    'url'   => route('routers.index'),
                ],
                [
                    'title' =>  __("Edit Router"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $router,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRouterRequest  $request
     * @param  Router $router
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRouterRequest $request, Router $router)
    {
        $router->update($request->all());
        return redirect()->route('routers.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Router $router
     * @return \Illuminate\Http\Response
     */
    public function destroy(Router $router)
    {
        $router->delete();
        return redirect()->route('routers.index')->with('success', __("This row has been deleted."));
    }
}
