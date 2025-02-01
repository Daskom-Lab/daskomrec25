<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Gem</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

  {{-- Laravel Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
  class="bg-Gems bg-cover bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-white overflow-hidden cursor-Wand"
>
  <!-- Background Image -->
  <img src="assets/Wall2.webp" alt="Wall" class="fixed left-0 h-full w-auto">
  <img src="assets/Wall-Mobile.webp" alt="Wall" class="fixed inset-0 w-[200px] sm:hidden">
  <img src="assets/Crystal 3.webp" alt="Crystal" class="fixed w-[530px] top-2 -left-[340px]">
  <img src="assets/Shine.webp" alt="Shine" class="fixed w-[150px] top-0 left-0 -rotate-[7deg]">
  <img src="assets/Shine.webp" alt="Shine" class="fixed w-[150px] top-20 left-20 -rotate-[10deg]">
  <img src="assets/Crystal 1.webp" alt="Crystal" class="fixed w-[220px] bottom-0 -left-1">
  <img src="assets/Flower 1.webp" alt="Flower" class="fixed bottom-0 left-0 w-[150px]">
  <img src="assets/Crystal 5.webp" alt="Crystal" class="fixed w-[170px] bottom-0 left-[250px]">
  <img src="assets/Flower 2.webp" alt="Flower" class="fixed bottom-0 left-[250px] w-[140px]">
  <img src="assets/Sparkle.webp" alt="Dust" class="absolute min-w-max right-0 -top-5 transform scale-x-[-1]">

  {{-- Layer Overlay --}}
  <div class="absolute flex items-center justify-center bg-BlackLayer w-full h-full z-20">
    <div class="container h-full mx-auto font-im-fell-english max-w-full sm:max-w-[80%] md:max-w-[90%] lg:max-w-[70%]">
      <div class="mt-16 relative justify-center">
        <div class="text-center">
          <h1 class="text-lg font-crimson-text pb-2">Discover the light within</h1>
          <h1 class="text-3xl">Pick Your Gem</h1>
        </div>

        {{-- Owl Carousel --}}
        <div class="owl-carousel owl-theme justify-evenly mx-auto my-4 -translate-x-6">
          @foreach($gems as $gem)
            <div class="relative h-[410px] w-[200px] xs:w-[400px] flex flex-col justify-center items-center mx-auto gem-container">
              <img
                src="{{ $gem->image ?: asset('assets/noimage.webp') }}"
                alt="Gem Card"
                class="max-w-[250px] rounded gem-image"
              >
              <p class="mt-2 text-white font-bold text-sm z-20 gem-quota-text">
                Sisa Quota: {{ $gem->quota }}
              </p>
              {{-- Simpan role_id di hidden --}}
              <input type="hidden" class="gem-id-hidden" value="{{ $gem->id }}">
            </div>
          @endforeach
        </div>

        {{-- Prev / Save / Next Buttons --}}
        <div class="flex justify-center h-[60px] space-x-2">
          <button
            class="owl-prev hover:scale-105 hover:brightness-110 active:scale-95 cursor-Wand"
            type="button"
          >
            <img src="{{ asset('assets/Prev.webp') }}" alt="Prev" class="h-[60px]">
          </button>

          <button
            class="text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-150 active:scale-95 cursor-Wand relative"
            onclick="showGemPopup()"
          >
            <img
              src="{{ asset('assets/Button Pink.webp') }}"
              alt="Save"
              class="h-[75%]"
            >
            <p class="absolute inset-0 flex items-center justify-center text-xl font-bold">
              Save
            </p>
          </button>

          <button
            class="owl-next hover:scale-105 hover:brightness-110 active:scale-95 cursor-Wand"
            type="button"
          >
            <img src="{{ asset('assets/Next.webp') }}" alt="Next" class="h-[60px]">
          </button>
        </div>

        {{-- Popup Konfirmasi --}}
        <x-confirm-gem></x-confirm-gem>

      </div>
    </div>
  </div>

  {{-- Sidebar & Home button (jika ada komponen) --}}
  <x-sidebar></x-sidebar>
  <x-home-button></x-home-button>

  {{-- jQuery dan Owl Carousel JS --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
  ></script>

  {{-- Script slider (slider3.js) Rencananya simpen di situ --}}
  <script>
    $(document).ready(function () {
    var carousel = $(".owl-carousel");
  
    carousel.owlCarousel({
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 3,
        },
      },
      loop: false,
      center: true,
      margin: 30, // tambahkan margin biar tidak mepet
      responsiveClass: true,
      onTranslated: function (event) {
        var currentItem = event.item.index;
  
        // Hilangkan zoom dari semua item (non-cloned)
        $(".owl-item").not(".cloned").removeClass("zoom")
          .find(".gem-container").css({
            transform: "scale(0.9)",
            opacity: "1",
            transition: "transform 0.4s ease, opacity 0.4s ease",
            "z-index": "10",
          });
  
        // Tambahkan zoom pada item aktif
        $(".owl-item").eq(currentItem).addClass("zoom")
          .find(".gem-container").css({
            transform: "scale(1.2)",
            opacity: "1",
            transition: "transform 0.4s ease, opacity 0.4s ease",
            "z-index": "20",
          });
      },
    });
  
    // Trigger zoom awal di item pertama (opsional)
    setTimeout(function () {
      var firstItem = carousel.find(".owl-item").eq(0);
      firstItem.addClass("zoom").find(".gem-container").css({
        transform: "scale(1.2)",
        opacity: "1",
        transition: "transform 0.4s ease, opacity 0.4s ease",
        "z-index": "20",
      });
    }, 0);
  
    // Hide dots jika tidak mau pakai
    $(".owl-dots").hide();
  
    // Custom nav buttons
    $(".owl-prev").click(function () {
      carousel.trigger("prev.owl.carousel");
    });
    $(".owl-next").click(function () {
      carousel.trigger("next.owl.carousel");
    });
  });
  

    // Pemilihan gem & konfirmasi
    let selectedGemId = null;

    function updateSelectedGemId() {
      // cari item zoom
      let $activeItem = $('.owl-item.zoom .gem-id-hidden').first();
      if ($activeItem.length) {
        selectedGemId = $activeItem.val();
      } else {
        // fallback
        let $activeFallback = $('.owl-item.active .gem-id-hidden').first();
        selectedGemId = $activeFallback.val() || null;
      }
    }

    function showGemPopup() {
      updateSelectedGemId();
      document.getElementById('popupPickGem').classList.remove('hidden');
    }

    function hideGemPopup() {
      document.getElementById('popupPickGem').classList.add('hidden');
    }

    // AJAX pick gem
    function pickGem() {
      if (!selectedGemId) {
        alert("Tidak ada Gem yang dipilih!");
        return;
      }
      $.ajax({
        url: "{{ route('caas.pick-gem') }}",
        type: "POST",
        data: {
          role_id: selectedGemId,
          _token: "{{ csrf_token() }}"
        },
        success: function(res) {
          window.location.href = "{{ route('caas.fix-gem') }}";
        },
        error: function(xhr) {
          if(xhr.responseJSON && xhr.responseJSON.error) {
            alert(xhr.responseJSON.error);
          } else {
            alert("Something went wrong, please try again.");
          }
        }
      });
    }
  </script>
</body>
</html>
