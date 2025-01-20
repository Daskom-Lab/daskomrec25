<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Shift</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-Shift bg-cover bg-center bg-no-repeat max-w-full min-h-screen overflow-hidden ">

    <div class="absolute flex flex-col items-center justify-center bg-BlackLayer w-full h-full z-30 font-im-fell-english overflow-hidden">
        <div class="inset-0 text-white text-center mt-12">
            <h2 class="font-crimson-text text-lg lg:text-xl md:text-xl pb-1 font-bold">Discover the light within</h2>
            <h1 class="text-2xl md:text-3xl lg:text-3xl">Choose Your Shift</h1>
        </div>
        <div class="bg-Table mx-auto my-5 w-[95%] h-full rounded-2xl text-shift text-xs lg:text-xl md:text-xl">
            <div class="flex m-5 justify-between h-5 lg:h-8 md:h-8">
                <div class="flex space-x-2 items-center">
                    <p>Show</p>
                    <div class="w-12 h-full text-center bg-white border-black border-[1px] rounded-full">
                        <p>10</p>
                    </div>
                    <p>Entries</p>
                </div>
                <input type="text" id="shift" class="w-36 lg:w-60 md:w-60 h-full px-4 bg-white border-black border-[1px] rounded-full" placeholder="Search">
            </div>
            <div class="flex m-5 bg-white text-center">
                <table class="table-auto border-black border-[1px] w-full border-spacing-0">
                    <thead>
                        <tr class="h-10 lg:h-12 md:h-12">
                            <th class="border-[1px] border-black">No</th>
                            <th class="border-[1px] border-black">Shift</th>
                            <th class="border-[1px] border-black">Date</th>
                            <th class="border-[1px] border-black">Time</th>
                            <th class="border-[1px] border-black">Quota</th>
                            <th class="border-[1px] border-black">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="h-10 lg:h-14 md:h-14">
                            <td class="border-[1px] border-black">1.</td>
                            <td class="border-[1px] border-black">Interview 1</td>
                            <td class="border-[1px] border-black">18/12/2024</td>
                            <td class="border-[1px] border-black">10.00-12.00</td>
                            <td class="border-[1px] border-black">5</td>
                            <td class="border-[1px] border-black">
                                <button class="bg-AddButton px-1.5 py-1 text-center rounded-lg " onclick="showShift()">
                                    <p class="text-white">Add</p>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <x-confirm-shift></x-confirm-shift>
            </div>
        </div>
    </div>
    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    

</body>
</html>