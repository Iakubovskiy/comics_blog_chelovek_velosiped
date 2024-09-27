<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Tom;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $chapters = Chapter::with('tom')->when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        $toms = Tom::all();
        return view('admin.chapters.create', compact('toms'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'tom_id' => 'required|exists:toms,id',
        ]);

        Chapter::create($validatedData);

        return redirect()->route('admin.chapters.index')->with('success', 'Глава успішно створена');
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $toms = Tom::all();
        return view('admin.chapters.edit', compact('chapter', 'toms'));
    }

    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'tom_id' => 'required|exists:toms,id',
        ]);

        $chapter->update($validatedData);

        return redirect()->route('admin.chapters.index')->with('success', 'Глава успішно оновлена');
    }

    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();

        return redirect()->route('admin.chapters.index')->with('success', 'Глава успішно видалена');
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $chapters = Chapter::with('tom')->when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return response()->json(['chapters' => $chapters]);
    }
}
