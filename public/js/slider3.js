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
    margin: 30,
    responsiveClass: true,
    onTranslated: function (event) {
      var currentItem = event.item.index;

      // Hilangkan zoom
      $(".owl-item").not(".cloned").removeClass("zoom")
        .find(".gem-container").css({
          transform: "scale(0.9)",
          opacity: "1",
          transition: "transform 0.4s ease, opacity 0.4s ease",
          "z-index": "10",
        });

      // Tambahkan zoom di item aktif
      $(".owl-item").eq(currentItem).addClass("zoom")
        .find(".gem-container").css({
          transform: "scale(1.2)",
          opacity: "1",
          transition: "transform 0.4s ease, opacity 0.4s ease",
          "z-index": "20",
        });
    },
  });

  // Trigger zoom awal di item pertama
  setTimeout(function () {
    var firstItem = carousel.find(".owl-item").eq(0);
    firstItem.addClass("zoom").find(".gem-container").css({
      transform: "scale(1.2)",
      opacity: "1",
      transition: "transform 0.4s ease, opacity 0.4s ease",
      "z-index": "20",
    });
  }, 0);

  // Hide dots
  $(".owl-dots").hide();

  // Custom nav
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