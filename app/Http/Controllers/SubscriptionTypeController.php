<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionType;
use Illuminate\Http\Request;

class SubscriptionTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $subscriptionTypes = SubscriptionType::when($query, function ($q) use ($query) {
            return $q->where('type', 'like', "%{$query}%");
        })->get();

        return view('admin.subscriptionTypes.index', compact('subscriptionTypes'));
    }

    public function create()
    {
        return view('admin.subscriptionTypes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|unique:subscription_types,type',
            'price' => 'required|numeric',
            'features' => 'nullable|string',
        ]);

        SubscriptionType::create($validatedData);

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки успішно створено');
    }

    public function edit($id)
    {
        $subscriptionType = SubscriptionType::findOrFail($id);
        return view('admin.subscriptionTypes.edit', compact('subscriptionType'));
    }

    public function update(Request $request, $id)
    {
        $subscriptionType = SubscriptionType::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required|unique:subscription_types,type,' . $subscriptionType->id,
            'price' => 'required|numeric',
            'features' => 'nullable|string',
        ]);

        $subscriptionType->update($validatedData);

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки успішно оновлено');
    }

    public function destroy($id)
    {
        $subscriptionType = SubscriptionType::findOrFail($id);
        $subscriptionType->delete();

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки успішно видалено');
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $subscriptionTypes = SubscriptionType::when($query, function ($q) use ($query) {
            return $q->where('type', 'like', "%{$query}%");
        })->get();

        return response()->json(['subscriptionTypes' => $subscriptionTypes]);
    }
}
