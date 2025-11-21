<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TutorHub - Messages</title>

    <!-- Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Reverb/Echo Dependencies -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- Updated Echo Version -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <style>
        :root {
            --background: #F0EBE2;
            --foreground: #1A2A57;
            --primary: #B83A3F;
            --primary-foreground: #ffffff;
            --muted: #e6e3dd;
            --muted-foreground: #2E4980;
            --border: #6A8094;
            --chat-bubble-received: #ffffff;
        }
        body { background-color: var(--muted); color: var(--foreground); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background-color: var(--border); border-radius: 20px; }
        .message-enter { animation: slideIn 0.2s ease-out forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden">

    <!-- Header -->
    <header class="h-16 border-b border-[var(--border)]/30 bg-[var(--background)] flex items-center px-6 shrink-0">
        <a href="/dashboard" class="flex items-center gap-2 text-[var(--foreground)] hover:opacity-80 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span class="font-semibold">Dashboard</span>
        </a>
        <h1 class="ml-6 font-bold text-xl">Messages</h1>
    </header>

    <!-- Main Chat Application -->
    <div class="flex-1 flex overflow-hidden"
         x-data="chatApp({{ auth()->id() }}, {{ json_encode($users) }})"
         x-init="initEcho(); checkUrlForContact()">

        <!-- Sidebar (Contacts) -->
        <aside class="w-full md:w-80 lg:w-96 bg-[var(--background)] border-r border-[var(--border)]/30 flex flex-col"
               :class="mobileChatOpen ? 'hidden md:flex' : 'flex'">

            <div class="p-4 border-b border-[var(--border)]/20">
                <input type="text" placeholder="Search contacts..." class="w-full h-10 px-4 rounded-lg border border-[var(--border)]/50 bg-[var(--muted)] text-sm focus:outline-none focus:border-[var(--primary)]">
            </div>

            <div class="flex-1 overflow-y-auto">
                <template x-for="contact in contacts" :key="contact.id">
                    <button @click="selectContact(contact)"
                            class="w-full p-4 flex items-center gap-4 hover:bg-[var(--muted)] transition-colors text-left border-b border-[var(--border)]/10 relative"
                            :class="activeChat && activeChat.id === contact.id ? 'bg-[var(--muted)]/80 border-l-4 border-l-[var(--primary)]' : 'border-l-4 border-l-transparent'">

                        <div class="relative shrink-0">
                            <img :src="'https://i.pravatar.cc/150?u=' + contact.id" class="w-12 h-12 rounded-full object-cover border border-[var(--border)]/30">
                            <span x-show="contact.hasUnread" class="absolute top-0 right-0 w-3 h-3 bg-[var(--primary)] rounded-full border-2 border-[var(--background)]"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-semibold text-[var(--foreground)] truncate" x-text="contact.name"></h3>
                            </div>
                            <p class="text-sm text-[var(--muted-foreground)] truncate" x-text="contact.email"></p>
                        </div>
                    </button>
                </template>
            </div>
        </aside>

        <!-- Chat Area -->
        <main class="flex-1 flex flex-col bg-[var(--muted)] relative"
              :class="mobileChatOpen ? 'flex' : 'hidden md:flex'">

            <div x-show="!activeChat" class="flex-1 flex items-center justify-center flex-col text-[var(--muted-foreground)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-4 opacity-50"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p>Select a contact to start chatting</p>
            </div>

            <div x-show="activeChat" class="flex-1 flex flex-col h-full">
                <div class="h-16 bg-[var(--background)] border-b border-[var(--border)]/30 flex items-center justify-between px-4 shrink-0 z-10 shadow-sm">
                    <div class="flex items-center gap-3">
                        <button @click="mobileChatOpen = false" class="md:hidden text-[var(--muted-foreground)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        </button>
                        <div class="relative">
                            <img :src="'https://i.pravatar.cc/150?u=' + (activeChat ? activeChat.id : 0)" class="w-10 h-10 rounded-full object-cover">
                        </div>
                        <h2 class="font-bold text-[var(--foreground)]" x-text="activeChat ? activeChat.name : ''"></h2>
                    </div>
                </div>

                <div id="message-container" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex w-full message-enter" :class="msg.sender_id === myUserId ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[75%] flex flex-col" :class="msg.sender_id === myUserId ? 'items-end' : 'items-start'">
                                <div class="px-4 py-2 rounded-2xl shadow-sm text-sm leading-relaxed break-words"
                                     :class="msg.sender_id === myUserId
                                        ? 'bg-[var(--primary)] text-[var(--primary-foreground)] rounded-tr-none'
                                        : 'bg-[var(--chat-bubble-received)] text-[var(--foreground)] border border-[var(--border)]/20 rounded-tl-none'">
                                    <p x-text="msg.text"></p>
                                </div>
                                <span class="text-[10px] text-[var(--muted-foreground)] mt-1 px-1 opacity-80"
                                      x-text="formatTime(msg.created_at || msg.time)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="p-4 bg-[var(--background)] border-t border-[var(--border)]/30 shrink-0">
                    <form @submit.prevent="sendMessage" class="flex items-end gap-3 max-w-4xl mx-auto">
                        <input type="text" x-model="newMessage" placeholder="Type your message..."
                               class="flex-1 py-3 pl-4 pr-4 rounded-full border border-[var(--border)] bg-[var(--muted)]/30 focus:bg-white focus:border-[var(--primary)] focus:ring-2 focus:ring-[var(--primary)]/20 transition-all outline-none">
                        <button type="submit" :disabled="!newMessage.trim()"
                                class="p-3 rounded-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="translate-x-0.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function chatApp(authId, usersList) {
            return {
                myUserId: authId,
                contacts: usersList.map(u => ({ ...u, hasUnread: false })),
                activeChat: null,
                messages: [],
                newMessage: '',
                mobileChatOpen: false,

                checkUrlForContact() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const userId = urlParams.get('user_id');
                    if (userId) {
                        const contact = this.contacts.find(c => c.id == userId);
                        if (contact) this.selectContact(contact);
                    }
                },

                initEcho() {
                    if (window.Echo) {
                        // 1. Reverb Configuration
                        // We use 'reverb' broadcaster which handles the connection
                        window.Echo = new Echo({
                            broadcaster: 'reverb',
                            key: '{{ env("REVERB_APP_KEY") }}',
                            wsHost: '{{ env("REVERB_HOST", "localhost") }}',
                            wsPort: {{ env("REVERB_PORT", 8080) }},
                            wssPort: {{ env("REVERB_PORT", 8080) }},
                            forceTLS: '{{ env("REVERB_SCHEME", "http") }}' === 'https',
                            enabledTransports: ['ws', 'wss'],
                        });

                        console.log('Echo initialized for Reverb on channel: chat.user.' + this.myUserId);

                        // 2. Subscribe
                        window.Echo.private('chat.user.' + this.myUserId)
                            .listen('MessageSent', (e) => {
                                console.log('Event received:', e);

                                // Logic: Update chat if open, otherwise show dot
                                if (this.activeChat && (this.activeChat.id === e.sender_id || e.sender_id == this.myUserId)) {
                                    this.messages.push({
                                        id: e.id,
                                        text: e.text,
                                        sender_id: e.sender_id,
                                        created_at: e.time
                                    });
                                    this.$nextTick(() => this.scrollToBottom());
                                } else {
                                    const contact = this.contacts.find(c => c.id === e.sender_id);
                                    if (contact) contact.hasUnread = true;
                                }
                            });
                    }
                },

                async selectContact(user) {
                    this.activeChat = user;
                    this.activeChat.hasUnread = false;
                    this.mobileChatOpen = true;
                    this.messages = [];

                    try {
                        const response = await fetch(`/chat/${user.id}`);
                        if(response.ok) {
                            this.messages = await response.json();
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    } catch (error) {
                        console.error('Error fetching messages:', error);
                    }
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    const tempText = this.newMessage;

                    this.messages.push({
                        id: Date.now(),
                        text: tempText,
                        sender_id: this.myUserId,
                        created_at: new Date().toISOString()
                    });

                    this.newMessage = '';
                    this.$nextTick(() => this.scrollToBottom());

                    try {
                        const response = await fetch(`/chat/${this.activeChat.id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ text: tempText })
                        });
                    } catch (error) {
                        console.error('Error sending message:', error);
                    }
                },

                scrollToBottom() {
                    const container = document.getElementById('message-container');
                    if (container) container.scrollTop = container.scrollHeight;
                },

                formatTime(dateString) {
                    if (!dateString) return '';
                    if (dateString.length === 5 && dateString.includes(':')) return dateString;
                    const date = new Date(dateString);
                    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
            }
        }
    </script>
</body>
</html>
