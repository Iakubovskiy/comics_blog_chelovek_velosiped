<?php

namespace App\Http\Controllers;

use App\Models\Tom;
use Illuminate\Http\Request;

class TomController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $toms = Tom::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return view('admin.toms.index', compact('toms'));
    }

    public function create()
    {
        return view('admin.toms.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:toms,name',
        ]);

        Tom::create($validatedData);

        return redirect()->route('admin.toms.index')->with('success', 'Том успішно створено');
    }

    public function edit($id)
    {
        $tom = Tom::findOrFail($id);
        return view('admin.toms.edit', compact('tom'));
    }

    public function update(Request $request, $id)
    {
        $tom = Tom::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:toms,name,' . $tom->id,
        ]);

        $tom->update($validatedData);

        return redirect()->route('admin.toms.index')->with('success', 'Том успішно оновлено');
    }

    public function destroy($id)
    {
        $tom = Tom::findOrFail($id);
        $tom->delete();

        return redirect()->route('admin.toms.index')->with('success', 'Том успішно видалено');
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $toms = Tom::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return response()->json(['toms' => $toms]);
    }
}
