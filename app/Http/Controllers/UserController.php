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

class UserController extends Controller
{
    public function index()
    {
        try{
            $users = User::with(['role', 'subscription.subscriptionTypes'])->get();
        }
        catch (\Exception $e) {
            $users = User::with(['role'])->get();
        }
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function filter(Request $request)
    {
        $query = $request->query('query');
        $role = $request->query('role');

        $users = User::with('role')
            ->when($query, function ($q) use ($query) {
                return $q->where('login', 'like', "%{$query}%");
            })
            ->when($role, function ($q) use ($role) {
                return $q->where('role_id', $role);
            })
            ->get();

        return response()->json(['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        $subscriptionTypes = SubscriptionType::all();

        return view('admin.users.create', compact('roles', 'subscriptionTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'login' => 'required|unique:users,login',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone',
            'role_id' => 'required|exists:roles,id',
            'subscription_type_id' => 'nullable|exists:subscription_types,id',
        ]);
        $subscriptionData = [
            'subscription_type_id' => $validatedData['subscription_type_id'],
            'beginning_date' => now(),
            'end_date' => now()->addYear(),
        ];
        $subscription = new Subscription($subscriptionData);
        try{

            $subscription->save();
        }
        catch (\Exception $e) {

        }


        $validatedData['password'] = Hash::make($validatedData['password']);

        $userData = Arr::except($validatedData, ['subscription_type_id']);
        if ($subscription) {
            $userData['subscription_id'] = $subscription->id;
        }
        $user = User::create($userData);



        return redirect()->route('admin.users.index')->with('success', 'Користувача додано успішно');
    }

    public function edit($id)
    {
        $user = User::with('subscription')->findOrFail($id);
        $roles = Role::all();
        $subscriptionTypes = SubscriptionType::all();

        return view('admin.users.edit', compact('user', 'roles', 'subscriptionTypes'));
    }



    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'login' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8',
            'phone' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'role_id' => 'required|exists:roles,id',
            'subscription_type_id' => 'nullable|exists:subscription_types,id',
        ]);

        if ($validatedData['subscription_type_id'] !== null) {
            if ($user->subscription) {
                $user->subscription->update([
                    'subscription_type_id' => $validatedData['subscription_type_id'],
                    'beginning_date' => now(),
                    'end_date' => now()->addYear(),
                ]);
            } else {
                $subscription = new Subscription([
                    'subscription_type_id' => $validatedData['subscription_type_id'],
                    'beginning_date' => now(),
                    'end_date' => now()->addYear(),
                ]);
                $subscription->save();
                $validatedData['subscription_id'] = $subscription->id;
            }
        }
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Користувача оновлено успішно');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Користувача видалено успішно');
    }
}
