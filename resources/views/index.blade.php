<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Analisis Kredit - Logic Project</title>
    
    @vite('resources/css/app.css')

    <style>
        /* Animasi slide-in untuk result box */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(24px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Animasi pulse untuk loading */
        @keyframes pulse-bg {
            0%, 100% { background-color: #A78BFA; }
            50%       { background-color: #C4B5FD; }
        }
        .animate-pulse-bg {
            animation: pulse-bg 1.2s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen bg-[#FEF2E8] flex items-center justify-center p-6 font-mono">
        <div class="bg-white border-[4px] border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] p-8 max-w-lg w-full">

            <!-- Header -->
            <div class="border-b-[4px] border-black pb-6 mb-8 relative">
                <div class="absolute -top-12 -right-4 bg-[#FF5C00] text-white border-[3px] border-black px-4 py-1 font-bold rotate-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    Logika Informatika
                </div>
                <h2 class="text-4xl font-black uppercase tracking-tighter text-black">Analisis Kredit</h2>
                <div class="flex gap-2 mt-3">
                    <span class="bg-[#4ADE80] border-[2px] border-black px-3 py-1 text-xs font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">RULE-BASED</span>
                    <span class="bg-[#60A5FA] border-[2px] border-black px-3 py-1 text-xs font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">LOGIC.PHP</span>
                </div>
            </div>

            <!-- Form -->
            <form action="/analyze" method="POST" class="space-y-6" id="creditForm"
                  oninvalid="event.preventDefault()" onsubmit="handleSubmit(event)">
                @csrf

                <!-- Penghasilan Bulanan -->
                <div class="space-y-2">
                    <label for="income" class="block text-sm font-black uppercase tracking-widest text-black">Penghasilan Bulanan</label>
                    <input type="number"
                           id="income"
                           name="income"
                           placeholder="7500000"
                           min="1"
                           max="999999999"
                           class="w-full bg-white border-[3px] border-black px-4 py-3 text-black font-bold focus:outline-none focus:bg-[#FFFAD1] transition-colors placeholder-gray-400 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]"
                           required
                           oninput="clearError('income-error')">
                    <!-- Error message kustom -->
                    <p id="income-error" class="text-[11px] font-bold text-red-600 hidden mt-1">⚠ Masukkan penghasilan yang valid (min. Rp 1)</p>
                </div>

                <!-- Grid: Tunggakan & Status Kerja -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Riwayat Tunggakan -->
                    <div class="space-y-2">
                        <label for="has_debt" class="block text-xs font-black uppercase text-black">Riwayat Tunggakan</label>
                        <select id="has_debt"
                                name="has_debt"
                                class="w-full bg-white border-[3px] border-black px-3 py-3 font-bold focus:outline-none shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] appearance-none">
                            <option value="tidak">TIDAK ADA</option>
                            <option value="ya">ADA</option>
                        </select>
                    </div>

                    <!-- Status Kerja -->
                    <div class="space-y-2">
                        <label for="is_permanent" class="block text-xs font-black uppercase text-black">Status Kerja</label>
                        <select id="is_permanent"
                                name="is_permanent"
                                class="w-full bg-white border-[3px] border-black px-3 py-3 font-bold focus:outline-none shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] appearance-none">
                            <option value="ya">TETAP</option>
                            <option value="tidak">KONTRAK</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        id="submitBtn"
                        class="w-full bg-[#A78BFA] hover:bg-[#C4B5FD] text-black font-black py-4 border-[3px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all active:shadow-none active:translate-x-1 active:translate-y-1 uppercase tracking-widest">
                    Jalankan Diagnosa ⚡
                </button>
            </form>

            <!-- Result Box -->
            @if(session('status'))
                <div class="mt-10 animate-slide-in">

                    <!-- Status Utama -->
                    <div class="p-6 bg-white border-[3px] border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2 underline decoration-[#FF5C00] decoration-2">Output Logika Proposisional</p>
                        <p class="text-2xl font-black {{ session('color') }} drop-shadow-[1px_1px_0px_#000]">
                            {{ session('status') }}
                        </p>
                        
                        @if(session('description'))
                            <p class="text-xs font-bold text-gray-600 mt-2">
                                {{ session('description') }}
                            </p>
                        @endif
                    </div>

                    <!-- Breakdown Kondisi -->
                    @if(session('breakdown'))
                        <div class="mt-4 border-[3px] border-black bg-[#FAFAFA] shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                            <div class="border-b-[2px] border-black px-4 py-2 bg-[#F0F0F0]">
                                <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-600">Breakdown Keputusan</p>
                            </div>
                            <div class="divide-y-[2px] divide-black">
                                @foreach(session('breakdown') as $item)
                                    <div class="flex items-center justify-between px-4 py-3">
                                        <span class="text-[11px] font-bold text-black">{{ $item['label'] }}</span>
                                        <span class="text-[10px] font-black px-3 py-1 border-[2px] border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]
                                            {{ $item['pass'] ? 'bg-[#4ADE80]' : 'bg-[#F87171]' }}">
                                            {{ $item['pass'] ? '✓ PASS' : '✗ FAIL' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Reset Button -->
                    <a href="/analyze/reset"
                       class="mt-4 block w-full text-center bg-[#E5E7EB] hover:bg-[#D1D5DB] text-black font-black py-3 border-[3px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all active:shadow-none active:translate-x-1 active:translate-y-1 uppercase tracking-widest text-xs">
                        ↺ Ulangi Analisis
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function handleSubmit(e) {
            const input = document.getElementById('income');
            const val = parseInt(input.value, 10);

            // Custom validation
            if (!val || val < 1 || val > 999999999) {
                e.preventDefault();
                document.getElementById('income-error').classList.remove('hidden');
                input.focus();
                return;
            }

            // Loading state
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.textContent = 'Memproses...';
            btn.classList.remove('hover:bg-[#C4B5FD]');
            btn.classList.add('animate-pulse-bg', 'opacity-80', 'cursor-not-allowed');
        }

        function clearError(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>
</html>