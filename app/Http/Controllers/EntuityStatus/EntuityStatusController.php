<?php

namespace App\Http\Controllers\EntuityStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntuityStatus\CreateEntuityStatusRequest;
use App\Http\Requests\EntuityStatus\UpdateEntuityStatusRequest;
use App\Models\EntuityStatus;
use Illuminate\Http\Request;

class EntuityStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Entuity Status lists"),
            'items' =>  [
                [
                    'title' =>  __("Entuity Status Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = EntuityStatus::orderBy('id', 'desc')->paginate();
        return view('pages.Entuity-Status.index', [
            'breadcrumb' => $breadcrumb,
            'lists'      => $lists,
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
            'title' =>  __("Create New entuity status"),
            'items' =>  [
                [
                    'title' =>  __(" entuity status Lists"),
                    'url'   => route('entuity-status.index'),
                ],
                [
                    'title' =>  __("Create New  entuity status"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.Entuity-Status.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEntuityStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEntuityStatusRequest $request)
    {
        EntuityStatus::create($request->all());
        return redirect()->route('entuity-status.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  EntuityStatus $EntuityStatus
     * @return \Illuminate\Http\Response
     */
    public function show(EntuityStatus $EntuityStatus)
    {
        $breadcrumb = [
            'title' =>  __("Show Modal"),
            'items' =>  [
                [
                    'title' =>  __(" entuity status Lists"),
                    'url'   => route('entuity-status.index'),
                ],
                [
                    'title' =>  __("Show Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.routers.show', [
            'breadcrumb'    =>  $breadcrumb,
            'Router'         =>  $EntuityStatus,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EntuityStatus $EntuityStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(EntuityStatus $EntuityStatus)
    {

        $breadcrumb = [
            'title' =>  __("Edit Modal"),
            'items' =>  [
                [
                    'title' =>  __(" entuity status Lists"),
                    'url'   => route('entuity-status.index'),
                ],
                [
                    'title' =>  __("Edit Modal"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.Entuity-Status.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $EntuityStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEntuityStatusRequest  $request
     * @param  EntuityStatus $EntuityStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntuityStatusRequest $request, EntuityStatus $EntuityStatus)
    {
        $EntuityStatus->update($request->all());
        return redirect()->route('entuity-status.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EntuityStatus $EntuityStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntuityStatus $EntuityStatus)
    {
        $EntuityStatus->delete();
        return redirect()->route('entuity-status.index')->with('success', __("This row has been deleted."));
    }
}
