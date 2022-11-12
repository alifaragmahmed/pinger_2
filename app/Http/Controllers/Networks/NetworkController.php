<?php

namespace App\Http\Controllers\Networks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Network\CreateNetworkRequest;
use App\Http\Requests\Network\UpdateNetworkRequest;
use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-network'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-network'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-network'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-network'],['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Networks lists"),
            'items' =>  [
                [
                    'title' =>  __("Networks Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Network::orderBy('id', 'desc')->paginate();
        return view('pages.networks.index', [
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
            'title' =>  __("Create New Network"),
            'items' =>  [
                [
                    'title' =>  __("Networks Lists"),
                    'url'   => route('networks.index'),
                ],
                [
                    'title' =>  __("Create New Network"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.networks.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNetworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNetworkRequest $request)
    {
        Network::create($request->all());
        return redirect()->route('networks.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  Network $network
     * @return \Illuminate\Http\Response
     */
    public function show(Network $network)
    {
        $breadcrumb = [
            'title' =>  __("Show Network"),
            'items' =>  [
                [
                    'title' =>  __("Networks Lists"),
                    'url'   => route('networks.index'),
                ],
                [
                    'title' =>  __("Show Network"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.networks.show', [
            'breadcrumb'    =>  $breadcrumb,
            'network'         =>  $network,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Network $network
     * @return \Illuminate\Http\Response
     */
    public function edit(Network $network)
    {
        $breadcrumb = [
            'title' =>  __("Edit Network"),
            'items' =>  [
                [
                    'title' =>  __("Networks Lists"),
                    'url'   => route('networks.index'),
                ],
                [
                    'title' =>  __("Edit Network"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.networks.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $network,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateNetworkRequest  $request
     * @param  Network $network
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNetworkRequest $request, Network $network)
    {
        $network->update($request->all());
        return redirect()->route('networks.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Network $network
     * @return \Illuminate\Http\Response
     */
    public function destroy(Network $network)
    {
        $network->delete();
        return redirect()->route('networks.index')->with('success', __("This row has been deleted."));
    }
}
