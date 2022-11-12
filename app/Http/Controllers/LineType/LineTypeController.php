<?php

namespace App\Http\Controllers\LineType;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineType\CreateLineTypeRequest;
use App\Http\Requests\LineType\UpdateLineTypeRequest;
use App\Models\LineType;
use Illuminate\Http\Request;

class LineTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Branche_read-line-type'],['only' => ['index', 'show']]);
        $this->middleware(['permission:Branche_create-line-type'],['only' => ['create', 'store']]);
        $this->middleware(['permission:Branche_update-line-type'],['only' => ['edit', 'update']]);
        $this->middleware(['permission:Branche_delete-line-type'],['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Line Type lists"),
            'items' =>  [
                [
                    'title' =>  __("Line Type Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = LineType::orderBy('id', 'desc')->paginate();
        return view('pages.line-types.index', [
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
            'title' =>  __("Create New Line Type"),
            'items' =>  [
                [
                    'title' =>  __("Line Type Lists"),
                    'url'   => route('line-types.index'),
                ],
                [
                    'title' =>  __("Create New Line Type"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('pages.line-types.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLineTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLineTypeRequest $request)
    {
        LineType::create($request->all());
        return redirect()->route('line-types.index')->with('success', __("This row has been created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  LineType $lineType
     * @return \Illuminate\Http\Response
     */
    public function show(LineType $lineType)
    {
        $breadcrumb = [
            'title' =>  __("Show Line Type"),
            'items' =>  [
                [
                    'title' =>  __("Line Type Lists"),
                    'url'   => route('line-types.index'),
                ],
                [
                    'title' =>  __("Show Line Type"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.line-types.show', [
            'breadcrumb'    =>  $breadcrumb,
            'LineType'         =>  $lineType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  LineType $lineType
     * @return \Illuminate\Http\Response
     */
    public function edit(LineType $lineType)
    {
        $breadcrumb = [
            'title' =>  __("Edit Line Type"),
            'items' =>  [
                [
                    'title' =>  __("Line Type Lists"),
                    'url'   => route('line-types.index'),
                ],
                [
                    'title' =>  __("Edit Line Type"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('pages.line-types.edit', [
            'breadcrumb'    =>  $breadcrumb,
            'data'         =>  $lineType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLineTypeRequest  $request
     * @param  LineType $lineType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLineTypeRequest $request, LineType $lineType)
    {
        $lineType->update($request->all());
        return redirect()->route('line-types.index')->with('success', __("This row has been updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  LineType $lineType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineType $lineType)
    {
        $lineType->delete();
        return redirect()->route('line-types.index')->with('success', __("This row has been deleted."));
    }
}
