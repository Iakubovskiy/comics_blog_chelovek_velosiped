<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-database.js"></script>
</head>
<body>
    <div class="container">
        <div class="users-sidebar">
            <div class="current-user">
                <strong>{{ $userData['login'] }}</strong>
                <span class="role-badge">{{ $userData['role'] }}</span>
            </div>
            <div class="users-list">
                <h3>Користувачі</h3>
                @foreach($users as $user)
                    <div class="user-item" onclick="selectUser({{ $user->id }}, '{{ $user->login }}')">
                        <span class="user-login">{{ $user->login }}</span>
                        <span class="role-badge">{{ $user->role->name ?? 'user' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div id="chat-container" style="display: none;">
            <div class="chat-header">
                Чат з <span id="selected-user">Виберіть користувача</span>
            </div>
            <div id="messages"></div>
            <div class="input-container">
                <input type="text" id="message-input" placeholder="Введіть повідомлення...">
                <button onclick="sendMessage()">Надіслати</button>
            </div>
        </div>
    </div>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyA8ZyZqhUwUgFVMX9k2Gh8hTT1CbIC0V3A",
            authDomain: "pvichat-4f0a0.firebaseapp.com",
            databaseURL: "https://pvichat-4f0a0-default-rtdb.europe-west1.firebasedatabase.app",
            projectId: "pvichat-4f0a0",
            storageBucket: "pvichat-4f0a0.firebasestorage.app",
            messagingSenderId: "811224832393",
            appId: "1:811224832393:web:148501027a60ee6c43e958",
            measurementId: "G-J46C43DE2C"
        };
        const currentUser = @json($userData);
        firebase.initializeApp(firebaseConfig);
        let currentRoom = null;
        let selectedUserId = null;
        const database = firebase.database();
        
        function selectUser(userId, userLogin) {
            selectedUserId = userId;
            document.getElementById('selected-user').textContent = userLogin;
            document.getElementById('chat-container').style.display = 'flex';
            
            if (currentRoom) {
                database.ref('chats/' + currentRoom + '/messages').off();
                document.getElementById('messages').innerHTML = '';
            }
            
            currentRoom = 'room_' + [currentUser.id, userId].sort().join('_');
            database.ref('chats/' + currentRoom + '/messages').on('child_added', (snapshot) => {
                console.log("Новий запис:", snapshot.val());
                const message = snapshot.val();
                displayMessage(message);
            });
            
            loadMessages();
        }
        
        function loadMessages() {
            console.log(currentRoom);
            fetch(/chat/messages/${currentRoom})
                .then(response => {
                    if (!response.ok) {
                        throw new Error(Server returned ${response.status});
                    }
                    return response.json();
                })
                .then(messages => {
                    document.getElementById('messages').innerHTML = '';
                    if (messages && Object.keys(messages).length > 0) {
                        Object.values(messages).forEach(displayMessage);
                    } else {
                        console.log('Немає повідомлень для цієї кімнати.');
                    }
                })
                .catch(err => {
                    console.error('Не вдалося завантажити повідомлення:', err);
                    alert('Не вдалося завантажити повідомлення: ' + err.message);
                });
        }

        function displayMessage(message) {
            const messagesDiv = document.getElementById('messages');
            const messageElement = document.createElement('div');
            
            const isCurrentUser = message.user_id === currentUser.id;
            
            messageElement.className = message ${isCurrentUser ? 'message-own' : 'message-other'};
            messageElement.innerHTML = 
                <div class="message-header">
                    <strong>${message.user_login}</strong>
                    <span class="role-badge">${message.user_role}</span>
                </div>
                <div class="message-content">${message.message}</div>
                <div class="message-time">
                    ${new Date(message.timestamp * 1000).toLocaleString()}
                </div>
            ;
            messagesDiv.appendChild(messageElement);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            
            if (message && currentRoom) {
                fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message,
                        room_id: currentRoom
                    })
                })
                .then(response => response.json())
                .then(data => {
                    input.value = '';
                })
                .catch(err => console.error('Не вдалося надіслати повідомлення:', err));
            }
        }
        
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>

    <style>
        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            gap: 20px;
            height: 80vh;
        }
        
        .users-sidebar {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
        
        .current-user {
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .users-list {
            overflow-y: auto;
            max-height: calc(100% - 60px);
        }
        
        .user-item {
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            margin-bottom: 8px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-item:hover {
            background: #f5f5f5;
        }
        
        #chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
        
        .chat-header {
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            max-width: 80%;
        }
        
        .message-own {
            background-color: #e3f2fd;
            margin-left: auto;
        }
        
        .message-other {
            background-color: #f5f5f5;
            margin-right: auto;
        }
        
        .role-badge {
            font-size: 0.8em;
            background: #ddd;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 8px;
        }
        
        .input-container {
            display: flex;
            gap: 10px;
        }
        
        input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        button {
            padding: 10px 20px;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background: #1565c0;
        }
    </style>
</body>
</html>
