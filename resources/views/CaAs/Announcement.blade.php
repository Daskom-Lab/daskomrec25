<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $announcement = App\Models\Announcement::find(1);

    // Pesan default
    $message = "Unknown";
    $link = "";

    // Jika ada record Announcement
    if ($announcement) {
        // Cek status user: jika "Fail" tampilkan fail_message, kalau selain itu tampilkan success_message
        $message = ($user->caasStage->status === "Fail")
            ? $announcement->fail_message
            : $announcement->success_message;
        
        // Link hanya aktif bila user tidak gagal
        if ($user->caasStage->status !== "Fail") {
            $link = $announcement->link ?? '';
        }
    }

    // Nama user (jika tidak ada profile->name, fallback ke nim)
    $name = $user->profile->name ?? $user->nim;

    // Tentukan header text & warna berdasarkan status
    $status = $user->caasStage->status ?? 'Unknown';
    $stageName = $user->caasStage->stage->name ?? 'Unknown';

    $headerText = 'Congratulations';   // default
    $headerColor = 'text-green-600';   // default warna hijau

    if (strtolower($status) === 'fail') {
        $headerText = "We are Sorry";
        $headerColor = 'text-red-600';
    }
@endphp
<body class="bg-Announcement bg-cover bg-center bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-primary overflow-hidden flex items-center justify-center relative">

    <img src="assets/Shadow Right.webp" alt="Shadow" class="fixed right-0 top-0 w-1/2 h-full">
    <img src="assets/BatsAnimated.webp" alt="Bats" class="fixed -top-72 -left-72 w-[750px] scale-x-[-1] opacity-60">
    <img src="assets/Crystals.webp" alt="Crystal" class="fixed w-[1400px] h-auto min-w-[1000px] ml-[150px] bottom-0">
    <img src="assets/Waterfall.webp" alt="Waterfall" class="fixed min-w-[800px] h-full top-0 md:h-full">
    <img src="assets/Magic Tree.webp" alt="Magic Tree" class="fixed w-[650px] h-auto min-w-max lg:-right-28 -right-52 bottom-5">
    <img src="assets/Lower.webp" alt="Wall" class="fixed -bottom-5 w-full lg:h-full h-[500px]">

    <div class="container max-w-xl mx-auto py-5 font-crimson-text">
        <div class="flex relative justify-center">
            <img src="assets/AnnouncementStone.png" alt="" class="h-[700px] h-md:h-[600px] h-sm:h-[550px] min-h-max">
            <div class="absolute text-justify mt-32 ml-[160px] mr-[150px]">
                <h1 class="text-center lg:text-3xl text-3xl font-bold">Announcement</h1>
                <hr class="mt-2 border-primary w-3/5 mx-auto mb-2 lg:mb-2">
                 <!-- Header conditional (Congratulations / Sorry) -->
                 <h2 class="text-md lg:text-lg font-bold mt-5 mb-5">
                    <span class="{{ $headerColor }}">{{ $headerText }},</span>
                    <br>
                    <span class="text-black">{{ $name }}</span>
                </h2>
                <p class="text-sm lg:text-sm text-justify font-im-fell-english">
                    {!! $message !!}
                    <br>
                    <a href="{{ e($link) }}" class="text-blue-500 underline hover:text-blue-700">{{ $link }}</a>
                </p>
            </div>
            
            <!-- 
                Bagian untuk SHIFT/GEMS button:
                - Tampil hanya jika user tidak "Fail"
                - Stage = 'Coding & Writing Test', 'Interview', atau 'Teaching Test' => SHIFT
                - Stage = 'Upgrading' => GEMS
                - Selain itu => tidak ada tombol
            -->
            <div class="absolute bottom-28 mr-16">
                @if (strtolower($status) !== 'fail')
                    @php
                        $buttonConfig = [
                            'Coding & Writing Test' => ['route' => 'caas.choose-shift', 'text' => 'Shift'],
                            'Interview' => ['route' => 'caas.choose-shift', 'text' => 'Shift'],
                            'Teaching Test' => ['route' => 'caas.choose-shift', 'text' => 'Shift'],
                            'Upgrading' => ['route' => 'caas.choose-gem', 'text' => 'Gems'],
                        ];
                        
                        $config = $buttonConfig[$stageName] ?? null;
                    @endphp
                    
                    @if ($config)
                    <button onclick="window.location.href='{{ route($config['route']) }}'" class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-150 active:scale-95 list-none">
                            <img src="assets/Button Pink.webp" alt="{{ $config['text'] }}Button" class="w-[150px]">
                            <p class="absolute inset-0 flex items-center justify-center text-lg font-bold">
                                {{ $config['text'] }}
                            </p>
                    </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    
</body>
</html>