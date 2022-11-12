<?php

namespace App\Http\Controllers\UpsInstallation;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsInstallations\CreateUpsInstallationsRequest;
use App\Http\Requests\UpsInstallations\UpdateUpsInstallationsRequest;
use App\Models\UpsInstallation;
use Illuminate\Http\Request;

class UpsInstaltionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-ups-installation'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-ups-installation'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-ups-installation'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-ups-installation'],['only' => ['destroy']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Ups Installation lists"),
            'items' =>  [
                [
                    'title' =>  __("Ups Installation Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = UpsInstallation::orderBy('id', 'desc')->paginate();
        return view('pages.ups-installations.index', [
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
            'title' =>  __("Create New Ups Installation"),
            'items' =>  [
                [
                    'title' =>  __(" Ups Installation Lists"),
                    'url'   => route('ups-installations.index'),
                ],
                [
                    'title' =>  __("Create New  Ups Installation"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.ups-installations.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpsInstallationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpsInstallationsRequest $request)
    {
        UpsInstallation::create($request->all());
        return redirect()->route('ups-installations.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  UpsInstallation $ups
     * @return \Illuminate\Http\Response
     */
    public function show(UpsInstallation $ups)
    {
        $breadcrumb = [
            'title' =>  __("Show Modal"),
            'items' =>  [
                [
                    'title' =>  __(" Ups Installation Lists"),
                    'url'   => route('ups-installations.index'),
                ],
                [
                    'title' =>  __("Show Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.ups-installations.show', [
            'breadcrumb'    =>  $breadcrumb,
            'ups'         =>  $ups,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UpsInstallation $UpsInstallation
     * @return \Illuminate\Http\Response
     */
    public function edit(UpsInstallation $UpsInstallation)
    {

        $breadcrumb = [
            'title' =>  __("Edit Modal"),
            'items' =>  [
                [
                    'title' =>  __(" ups installations Lists"),
                    'url'   => route('ups-installations.index'),
                ],
                [
                    'title' =>  __("Edit ups installations "),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.ups-installations.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $UpsInstallation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUpsInstallationsRequest  $request
     * @param  UpsInstallation $UpsInstallation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUpsInstallationsRequest $request, UpsInstallation $UpsInstallation)
    {
        $UpsInstallation->update($request->all());
        return redirect()->route('ups-installations.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UpsInstallation $modal
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpsInstallation $UpsInstallation)
    {
        $UpsInstallation->delete();
        return redirect()->route('ups-installations.index')->with('success', __("This row has been deleted."));
    }
}
