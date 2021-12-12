<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentAreaStoreRequest;
use App\Models\RentArea;
use Illuminate\Http\Request;

class RentAreaController extends Controller
{
    public function index()
    {
        $rentAreas = RentArea::all();

        return view('rentarea.index', compact('rentAreas'));
    }

    public function create()
    {
        return view('rentarea.create');
    }

    public function store(RentAreaStoreRequest $rentAreaStoreRequest)
    {
        RentArea::create($rentAreaStoreRequest->validated());

        return redirect()->route('rentarea.index');
    }

    public function edit(RentArea $rentArea)
    {
        return view('rentarea.edit', compact('rentArea'));
    }

    public function update(RentAreaStoreRequest $rentAreaStoreRequest, RentArea $rentArea)
    {
        $rentArea->update($rentAreaStoreRequest->validated());

        return redirect()->route('rentarea.index');
    }

    public function destroy(RentArea $rentArea)
    {
        $rentArea->delete();

        return redirect()->route('rentarea.index');
    }
}
