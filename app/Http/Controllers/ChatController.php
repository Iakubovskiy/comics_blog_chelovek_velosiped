<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    private $database;
    
    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('firebase-credentials.json'))
            ->withDatabaseUri(config('services.firebase.database_url'));
            
        $this->database = $factory->createDatabase();
    }
    
    public function index()
    {
        $user = auth()->user();
        $users = User::where('id', '!=', $user->id)->get();
        
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'login' => $user->login,
            'role' => $user->role->name ?? 'user',
        ];
        
        $firebaseConfig = [
            'apiKey' => config('services.firebase.api_key'),
            'authDomain' => config('services.firebase.auth_domain'),
            'databaseURL' => config('services.firebase.database_url'),
            'projectId' => config('services.firebase.project_id'),
            'storageBucket' => config('services.firebase.storage_bucket'),
            'messagingSenderId' => config('services.firebase.messaging_sender_id'),
            'appId' => config('services.firebase.app_id'),
        ];
        
        return view('chat.chat', compact('userData', 'firebaseConfig', 'users'));
    }
    
    public function getChatRoom($userId1, $userId2)
    {
        $users = [$userId1, $userId2];
        sort($users);
        return 'room_' . implode('_', $users);
    }
    
    public function getMessages(Request $request, $roomId)
    {
        Log::info("getting messages");
        $messages = $this->database
            ->getReference('chats/' . $roomId . '/messages')->getValue();
            
        return response()->json($messages ?? []);
    }
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'room_id' => 'required'
        ]);
        
        $user = auth()->user();
        
        $message = [
            'user_id' => $user->id,
            'message' => $request->message,
            'timestamp' => time(),
            'username' => $user->name,
            'user_login' => $user->login,
            'user_role' => $user->role->name ?? 'user',
        ];
        
        $this->database
            ->getReference('chats/' . $request->room_id . '/messages')
            ->push($message);
            
        return response()->json(['status' => 'success']);
    }
}
