<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $client = new \GuzzleHttp\Client([
                'base_uri' => 'http://localhost',  
                'timeout' => 60,
                'debug' => true,
                'verify' => false,
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
    
            $response = $client->get('/api/roles');
            $roles = json_decode($response->getBody()->getContents(), true);
            
            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            dd([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
            ]);
        }
        //$roles = $response->json();

        //return view('admin.roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $response = Http::post(env('API_URL') . '/roles', $data);

        if ($response->successful()) {
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
        }

        return back()->with('error', 'Error creating role');
    }

    public function edit($id)
    {
        $response = Http::get(env('API_URL') . '/roles/' . $id);
        $role = $response->json();

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $response = Http::put(env('API_URL') . '/roles/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
        }

        return back()->with('error', 'Error updating role');
    }

    public function delete($id)
    {
        $response = Http::delete(env('API_URL') . '/roles/' . $id);

        if ($response->successful()) {
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
        }

        return back()->with('error', 'Error deleting role');
    }
}
