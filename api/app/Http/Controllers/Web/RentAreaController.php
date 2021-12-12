<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentAreaStoreRequest;
use App\Models\RentArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RentAreaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_rent_area'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rentAreas = RentArea::all();

        return view('rentarea.index', compact('rentAreas'));
    }

    public function create()
    {
        abort_if(Gate::denies('manage_rent_area'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('rentarea.create');
    }

    public function store(RentAreaStoreRequest $rentAreaStoreRequest)
    {
        RentArea::create($rentAreaStoreRequest->validated());

        return redirect()->route('rentarea.index');
    }

    public function edit(RentArea $rentArea)
    {
        abort_if(Gate::denies('manage_rent_area'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('rentarea.edit', compact('rentArea'));
    }

    public function update(RentAreaStoreRequest $rentAreaStoreRequest, RentArea $rentArea)
    {
        $rentArea->update($rentAreaStoreRequest->validated());

        return redirect()->route('rentarea.index');
    }

    public function destroy(RentArea $rentArea)
    {
        abort_if(Gate::denies('manage_rent_area'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rentArea->delete();

        return redirect()->route('rentarea.index');
    }
}
