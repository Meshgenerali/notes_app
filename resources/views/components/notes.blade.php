@props(['notes' => [], 'note' => null])
<div>
        <!-- Add Note Modal -->
    <div id="addNoteModal" class="hidden fixed inset-0 bg-gray-900/50 dark:bg-black/70 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border border-[#e3e3e0] dark:border-[#3E3E3A] w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl shadow-lg rounded-lg bg-white dark:bg-[#1b1b18]">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Create New Note</h3>
                <button onclick="closeAddModal()" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="new_title" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Title</label>
                    <input 
                        type="text" 
                        id="new_title"
                        name="title"
                        placeholder="Enter note title" 
                        required
                        class="w-full px-4 py-2.5 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent transition-all"
                    >
                </div>
                
                <div class="mb-6">
                    <label for="new_content" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Content</label>
                    <textarea 
                        id="new_content"
                        name="content"
                        placeholder="Start writing your note..."
                        rows="10"
                        required
                        class="w-full px-4 py-2.5 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:border-transparent resize-none transition-all"
                    ></textarea>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button 
                        type="button"
                        onclick="closeAddModal()"
                        class="px-5 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg text-[#1b1b18] dark:text-[#EDEDEC] hover:border-black dark:hover:border-white transition-all text-sm font-medium"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-5 py-2 bg-[#1b1b18] dark:bg-[#EDEDEC] hover:bg-black dark:hover:bg-white text-white dark:text-[#1b1b18] rounded-lg transition-all text-sm font-medium"
                    >
                        Create Note
                    </button>
                </div>
            </form>
        </div>
    </div>

        <!-- Success Messages -->
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 pt-6 sm:px-6 lg:px-8">
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 min-h-[calc(100vh-56px)]">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Sidebar - Note List -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-[#1b1b18] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-sm">
                        <div class="p-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <button onclick="openAddModal()" class="w-full bg-[#1b1b18] dark:bg-[#EDEDEC] hover:bg-black dark:hover:bg-white text-white dark:text-[#1b1b18] font-medium py-2.5 px-4 rounded-lg transition-all text-sm">
                                + New Note
                            </button>
                        </div>
                        
                        <!-- Notes List -->
                        <div class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A] max-h-[calc(100vh-16rem)] overflow-y-auto">
                            @forelse($notes ?? [] as $item)
                            <a href="{{ route('notes.show', $item->id) }}" class="block p-4 hover:bg-[#FDFDFC] dark:hover:bg-[#161615] cursor-pointer transition-all border-l-2 {{ isset($note) && $note->id == $item->id ? 'border-[#1b1b18] dark:border-[#EDEDEC] bg-[#FDFDFC] dark:bg-[#161615]' : 'border-transparent' }}">
                                <h3 class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1 truncate">{{ $item->title }}</h3>
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2 line-clamp-2">{{ Str::limit($item->content, 60) }}</p>
                                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $item->updated_at->diffForHumans() }}</p>
                            </a>
                            @empty
                            <div class="p-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                <svg class="mx-auto h-12 w-12 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-2">No notes yet</p>
                                <p class="text-sm">Click "New Note" to create your first note</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Content - Note Editor -->
                <div class="lg:col-span-2">
                    @if(isset($note))
                    <div class="bg-white dark:bg-[#1b1b18] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-sm">
                        <form action="{{ route('notes.update', $note->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Note Header -->
                            <div class="p-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                <input 
                                    type="text" 
                                    name="title"
                                    placeholder="Note Title" 
                                    value="{{ old('title', $note->title) }}"
                                    class="w-full text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] bg-transparent border-none focus:outline-none focus:ring-0 placeholder:text-[#706f6c] dark:placeholder:text-[#A1A09A]"
                                    required
                                >
                                @error('title')
                                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                <div class="flex items-center justify-between mt-3">
                                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Last edited {{ $note->updated_at->diffForHumans() }}</p>
                                    <div class="flex gap-2">
                                        <button type="button" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] p-2 rounded hover:bg-[#FDFDFC] dark:hover:bg-[#161615] transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="deleteNote({{ $note->id }})" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Note Content -->
                            <div class="p-6">
                                <textarea 
                                    name="content"
                                    placeholder="Start writing your note..."
                                    rows="15"
                                    class="w-full text-[#1b1b18] dark:text-[#EDEDEC] bg-transparent border-none focus:outline-none focus:ring-0 resize-none placeholder:text-[#706f6c] dark:placeholder:text-[#A1A09A]"
                                    required
                                >{{ old('content', $note->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Note Footer -->
                            <div class="p-4 border-t border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#FDFDFC] dark:bg-[#161615]">
                                <div class="flex justify-between items-center">
                                    <div class="flex gap-2">
                                        <button type="button" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] px-3 py-2 rounded hover:bg-white dark:hover:bg-[#1b1b18] transition-all text-sm font-medium">
                                            Bold
                                        </button>
                                        <button type="button" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] px-3 py-2 rounded hover:bg-white dark:hover:bg-[#1b1b18] transition-all text-sm font-medium">
                                            Italic
                                        </button>
                                        <button type="button" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] px-3 py-2 rounded hover:bg-white dark:hover:bg-[#1b1b18] transition-all text-sm font-medium">
                                            List
                                        </button>
                                    </div>
                                    <button 
                                        type="submit"
                                        class="bg-[#1b1b18] dark:bg-[#EDEDEC] hover:bg-black dark:hover:bg-white text-white dark:text-[#1b1b18] font-medium py-2.5 px-6 rounded-lg transition-all text-sm"
                                    >
                                        Save Note
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-[#1b1b18] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-sm h-full flex items-center justify-center p-12">
                        <div class="text-center">
                            <svg class="mx-auto h-24 w-24 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">No note selected</h3>
                            <p class="mt-2 text-[#706f6c] dark:text-[#A1A09A]">Select a note from the list or create a new one to get started</p>
                            <button onclick="openAddModal()" class="mt-6 bg-[#1b1b18] dark:bg-[#EDEDEC] hover:bg-black dark:hover:bg-white text-white dark:text-[#1b1b18] font-medium py-2.5 px-6 rounded-lg transition-all text-sm">
                                Create New Note
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
        </main>

    <!-- Delete Note Form (hidden) -->
    <form id="deleteNoteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>