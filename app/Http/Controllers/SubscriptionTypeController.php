<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Role;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class SubscriptionTypeController extends Controller
{
    public function index()
    {
        try {
            $subscriptionTypes = SubscriptionType::all();
        } catch (\Exception $e) {
            // Можна обробити помилку, якщо потрібно
            return back()->withErrors(['error' => 'Не вдалося отримати типи підписки.']);
        }
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
            'features' => 'required',
        ]);

        SubscriptionType::create($validatedData);

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки додано успішно');
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
            'type' => [
                'required',
                Rule::unique('subscription_types')->ignore($subscriptionType->id),
            ],
            'price' => 'required|numeric',
            'features' => 'required',
        ]);

        $subscriptionType->update($validatedData);

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки оновлено успішно');
    }

    public function destroy($id)
    {
        $subscriptionType = SubscriptionType::findOrFail($id);
        $subscriptionType->delete();

        return redirect()->route('admin.subscriptionTypes.index')->with('success', 'Тип підписки видалено успішно');
    }
}
