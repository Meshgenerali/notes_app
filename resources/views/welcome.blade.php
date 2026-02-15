<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] font-sans antialiased">
        <!-- Header with Navigation -->
        <header class="w-full border-b border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#1b1b18]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-14">
                    <h1 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">My Notes</h1>
                    
                    @if (Route::has('login'))
                        <nav class="flex items-center gap-3">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-flex px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] hover:border-black dark:hover:border-white text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm text-sm leading-normal transition-all"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex px-5 py-1.5 text-[#1b1b18] dark:text-[#EDEDEC] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition-all"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] hover:border-black dark:hover:border-white text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm text-sm leading-normal transition-all"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <x-notes :notes="$notes" :note="$note ?? null"></x-notes>

    <script>
        function openAddModal() {
            document.getElementById('addNoteModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addNoteModal').classList.add('hidden');
        }

        function deleteNote(noteId) {
            if (confirm('Are you sure you want to delete this note?')) {
                const form = document.getElementById('deleteNoteForm');
                form.action = `/notes/${noteId}`;
                form.submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('addNoteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
            }
        });
    </script>
</body>
</html>