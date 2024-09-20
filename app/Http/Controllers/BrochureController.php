<?php

namespace App\Http\Controllers;

use App\Models\Brochure;

class BrochureController extends Controller
{
    public function index()
    {
        return view('brochures.index', [
            'brochures' => Brochure::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        return view('brochures.create', [
            'brochure' => new Brochure
        ]);
    }

    public function edit(Brochure $brochure)
    {
        return view('brochures.edit', [
            'brochure' => $brochure
        ]);
    }

    public function store()
    {
        request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        Brochure::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => request('body'),
            'order' => Brochure::count()
        ]);

        return redirect()->route('brochures.index');
    }

    public function update(Brochure $brochure)
    {
        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string', 'max:255'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $brochure->update($data);

        return redirect()->route('brochures.index');
    }

    public function destroy(Brochure $brochure)
    {
        $brochure->delete();

        return redirect()->back();
    }
}
