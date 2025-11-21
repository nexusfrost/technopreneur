<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorHub - Messages</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE
         * =================================================================
         */
        :root {
            --background: #F0EBE2; /* Off-white/Cream */
            --foreground: #1A2A57; /* Dark Blue */
            --primary: #B83A3F;    /* Red */
            --primary-foreground: #ffffff; /* White */
            --muted: #e6e3dd;      /* Slightly darker cream for body bg */
            --muted-foreground: #2E4980; /* Medium Blue */
            --border: #6A8094;     /* Desaturated Blue/Grey */
            --chat-bubble-received: #ffffff;
        }

        body {
            background-color: var(--muted);
            color: var(--foreground);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: var(--border);
            border-radius: 20px;
            border: 3px solid transparent;
            background-clip: content-box;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: var(--foreground);
        }

        .input-field {
            background-color: var(--background);
            border-color: var(--border);
        }
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(184, 58, 63, 0.2);
        }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden">

    <!-- Navbar Placeholder (Optional) -->
    <header class="h-16 border-b border-[var(--border)]/30 bg-[var(--background)] flex items-center px-6 shrink-0">
        <a href="/dashboard" class="flex items-center gap-2 text-[var(--foreground)] hover:opacity-80 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span class="font-semibold">Back to Dashboard</span>
        </a>
        <h1 class="ml-6 font-bold text-xl">Messages</h1>
    </header>

    <!-- Main Chat Container -->
    <div class="flex-1 flex overflow-hidden"
         x-data="{
            mobileChatOpen: false,
            activeChat: 1,
            messageInput: '',
            contacts: [
                { id: 1, name: 'Dr. Sarah Reed', avatar: 'https://i.pravatar.cc/150?img=5', lastMessage: 'That sounds perfect! See you then.', time: '10:30 AM', unread: 0, online: true },
                { id: 2, name: 'Ben Carter', avatar: 'https://i.pravatar.cc/150?img=11', lastMessage: 'Can we reschedule our session?', time: 'Yesterday', unread: 2, online: false },
                { id: 3, name: 'Mathematics Dept', avatar: 'https://i.pravatar.cc/150?img=3', lastMessage: 'Your booking is confirmed.', time: 'Mon', unread: 0, online: false }
            ],
            messages: [
                { id: 1, sender: 'them', text: 'Hi! I noticed you booked a session for Calculus II.', time: '10:00 AM' },
                { id: 2, sender: 'me', text: 'Yes, I am really struggling with integrals.', time: '10:05 AM' },
                { id: 3, sender: 'them', text: 'No worries at all. We can start from the basics. Do you have a specific textbook?', time: '10:06 AM' },
                { id: 4, sender: 'me', text: 'I am using Stewart Calculus, 8th Edition.', time: '10:15 AM' },
                { id: 5, sender: 'them', text: 'Perfect. Bring some practice problems and we will work through them together.', time: '10:28 AM' },
                { id: 6, sender: 'them', text: 'That sounds perfect! See you then.', time: '10:30 AM' }
            ],
            sendMessage() {
                if (this.messageInput.trim() === '') return;
                this.messages.push({
                    id: Date.now(),
                    sender: 'me',
                    text: this.messageInput,
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });
                this.messageInput = '';
                this.$nextTick(() => this.scrollToBottom());
            },
            scrollToBottom() {
                const container = document.getElementById('message-container');
                container.scrollTop = container.scrollHeight;
            }
         }"
         x-init="scrollToBottom()">

        <!-- Sidebar (Contact List) -->
        <aside class="w-full md:w-80 lg:w-96 bg-[var(--background)] border-r border-[var(--border)]/30 flex flex-col"
               :class="mobileChatOpen ? 'hidden md:flex' : 'flex'">

            <!-- Search -->
            <div class="p-4 border-b border-[var(--border)]/20">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-2.5 text-[var(--muted-foreground)]"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Search messages..." class="w-full h-10 pl-10 pr-4 rounded-lg border border-[var(--border)]/50 bg-[var(--muted)] text-sm focus:outline-none focus:ring-1 focus:ring-[var(--primary)]">
                </div>
            </div>

            <!-- List -->
            <div class="flex-1 overflow-y-auto">
                <template x-for="contact in contacts" :key="contact.id">
                    <button @click="activeChat = contact.id; mobileChatOpen = true; scrollToBottom()"
                            class="w-full p-4 flex items-center gap-4 hover:bg-[var(--muted)] transition-colors text-left border-b border-[var(--border)]/10 relative"
                            :class="activeChat === contact.id ? 'bg-[var(--muted)]/80 border-l-4 border-l-[var(--primary)]' : 'border-l-4 border-l-transparent'">

                        <div class="relative shrink-0">
                            <img :src="contact.avatar" class="w-12 h-12 rounded-full object-cover border border-[var(--border)]/30">
                            <span x-show="contact.online" class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[var(--background)] rounded-full"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-semibold text-[var(--foreground)] truncate" x-text="contact.name"></h3>
                                <span class="text-xs text-[var(--muted-foreground)] shrink-0" x-text="contact.time"></span>
                            </div>
                            <p class="text-sm text-[var(--muted-foreground)] truncate" x-text="contact.lastMessage"></p>
                        </div>

                        <div x-show="contact.unread > 0" class="absolute right-4 top-10 min-w-[1.25rem] h-5 flex items-center justify-center rounded-full bg-[var(--primary)] text-[var(--primary-foreground)] text-xs font-bold px-1">
                            <span x-text="contact.unread"></span>
                        </div>
                    </button>
                </template>
            </div>
        </aside>

        <!-- Chat Area -->
        <main class="flex-1 flex flex-col bg-[var(--muted)] relative"
              :class="mobileChatOpen ? 'flex' : 'hidden md:flex'">

            <!-- Chat Header -->
            <div class="h-16 bg-[var(--background)] border-b border-[var(--border)]/30 flex items-center justify-between px-4 sm:px-6 shrink-0 z-10 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="mobileChatOpen = false" class="md:hidden text-[var(--muted-foreground)] hover:text-[var(--foreground)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>

                    <div class="relative">
                        <img :src="contacts.find(c => c.id === activeChat).avatar" class="w-10 h-10 rounded-full object-cover">
                        <span x-show="contacts.find(c => c.id === activeChat).online" class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-[var(--background)] rounded-full"></span>
                    </div>
                    <div>
                        <h2 class="font-bold text-[var(--foreground)]" x-text="contacts.find(c => c.id === activeChat).name"></h2>
                        <p class="text-xs text-[var(--muted-foreground)] flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block" x-show="contacts.find(c => c.id === activeChat).online"></span>
                            <span x-text="contacts.find(c => c.id === activeChat).online ? 'Online' : 'Offline'"></span>
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <!-- Action Buttons (Video Call / Options) -->
                    <button class="p-2 rounded-md hover:bg-[var(--muted)] text-[var(--muted-foreground)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7 16 12 23 17 23 7z"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    </button>
                    <button class="p-2 rounded-md hover:bg-[var(--muted)] text-[var(--muted-foreground)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>
                </div>
            </div>

            <!-- Messages Feed -->
            <div id="message-container" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 scroll-smooth">
                <!-- Date Separator -->
                <div class="flex justify-center my-4">
                    <span class="px-3 py-1 rounded-full bg-[var(--border)]/20 text-xs text-[var(--muted-foreground)] font-medium">
                        Today
                    </span>
                </div>

                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex w-full" :class="msg.sender === 'me' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[75%] sm:max-w-[60%] flex flex-col" :class="msg.sender === 'me' ? 'items-end' : 'items-start'">

                            <!-- Message Bubble -->
                            <div class="px-4 py-2 rounded-2xl shadow-sm text-sm leading-relaxed break-words"
                                 :class="msg.sender === 'me'
                                    ? 'bg-[var(--primary)] text-[var(--primary-foreground)] rounded-tr-none'
                                    : 'bg-[var(--chat-bubble-received)] text-[var(--foreground)] border border-[var(--border)]/20 rounded-tl-none'">
                                <p x-text="msg.text"></p>
                            </div>

                            <!-- Timestamp -->
                            <span class="text-[10px] text-[var(--muted-foreground)] mt-1 px-1 opacity-80" x-text="msg.time"></span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-[var(--background)] border-t border-[var(--border)]/30 shrink-0">
                <form @submit.prevent="sendMessage" class="flex items-end gap-3 max-w-4xl mx-auto">
                    <!-- Attach Button -->
                    <button type="button" class="p-2.5 rounded-full text-[var(--muted-foreground)] hover:bg-[var(--muted)] hover:text-[var(--primary)] transition-colors mb-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </button>

                    <!-- Text Input -->
                    <div class="flex-1 relative">
                        <input type="text"
                               x-model="messageInput"
                               placeholder="Type your message..."
                               class="w-full py-3 pl-4 pr-12 rounded-full border border-[var(--border)] bg-[var(--muted)]/30 focus:bg-white focus:border-[var(--primary)] focus:ring-2 focus:ring-[var(--primary)]/20 transition-all outline-none placeholder:text-[var(--muted-foreground)]/60">

                        <!-- Emoji Button (Optional) -->
                        <button type="button" class="absolute right-3 top-3 text-[var(--muted-foreground)] hover:text-[var(--foreground)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                        </button>
                    </div>

                    <!-- Send Button -->
                    <button type="submit"
                            :disabled="messageInput.trim() === ''"
                            class="p-3 rounded-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-md mb-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="translate-x-0.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </div>
        </main>

    </div>

</body>
</html>
