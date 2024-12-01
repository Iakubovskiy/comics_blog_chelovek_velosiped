<?php

namespace App\Http\Controllers\UserPart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TomService;

class TomController extends Controller
{
    protected $tomService;

    public function __construct(TomService $tomService)
    {
        $this->tomService = $tomService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $toms = $this->tomService->getAllToms();
        if ($search) {
            $toms = $toms->filter(function ($tom) use ($search) {
                return stripos($tom->name, $search) !== false; 
            });
        }

        return view('toms.index', compact('toms'));
    }

    public function show(int $id)
    {
        $tom = $this->tomService->getTomById($id);
        return view('toms.show', compact('tom'));
    }
}
