<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tom;
use App\Services\TomService;
use Illuminate\Http\Request;

class TomController extends Controller
{
    private TomService $tomService;
    public function __construct(TomService $tomService) {
        $this->tomService = $tomService;
    }

    public function index()
    {
        $toms = $this->tomService->getAllToms();
        return view('admin.toms.index', compact('toms'));
    }

    public function create()
    {
        return view('admin.toms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $uploadedFiles = $request->file('images', []);
        $this->tomService->createTom($data, $uploadedFiles);
        return redirect()->route('admin.toms.index')->with('success', 'Tom created successfully.');
    }

    public function edit(int $id)
    {
        $tom = $this->tomService->getTomById($id);
        $images = $tom->photos;
        return view('admin.toms.edit', compact('tom','images'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $uploadedFiles = $request->file('images', []);
        $this->tomService->updateTom($id, $data, $uploadedFiles);
        return redirect()->route('admin.toms.index')->with('success', 'Tom updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->tomService->deleteTom($id);
        return redirect()->route('admin.toms.index')->with('success', 'Tom deleted successfully.');
    }
}
