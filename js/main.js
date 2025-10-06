const carousel = document.querySelector('.carousel');
const indicators = document.querySelectorAll('.indicator');
let currentIndex = 0;

function goToSlide(index) {
  // perditeson indeksin
  currentIndex = index;

  carousel.style.transform = `translateX(-${index * 100}%)`;

  indicators.forEach((indicator, i) => {
    if (i === index) {
      indicator.classList.add('active');
    } else {
      indicator.classList.remove('active');
    }
  });
}

// event listener mbi butonat per te ndryshuar imazhin
indicators.forEach((indicator, index) => {
  indicator.addEventListener('click', () => {
    goToSlide(index);
  });
});

//ndryshon imazhin ne ate pasardhes cdo 5 sek
setInterval(() => {
  currentIndex = (currentIndex + 1) % indicators.length;
  goToSlide(currentIndex);
}, 5000);


document.addEventListener('DOMContentLoaded', function () {
  const paragraphs = document.querySelectorAll('.values p');

  paragraphs.forEach((p, index) => {
    // Apply a margin-left based on the index (increasing by 20px for each <p>)
    p.style.marginLeft = (index + 1) * 20 + 'px';
  });
});

/*async src="https://www.youtube.com/iframe_api";*/

function onYouTubeIframeAPIReady() {
  var player;
  player = new YT.Player('muteYouTubeVideoPlayer', {
    videoId: 'YOUR_VIDEO_ID', // YouTube Video ID
    width: 560,               // Player width (in px)
    height: 316,              // Player height (in px)
    playerVars: {
      autoplay: 1,        // Auto-play the video on load
      controls: 1,        // Show pause/play buttons in player
      showinfo: 0,        // Hide the video title
      modestbranding: 1,  // Hide the Youtube Logo
      loop: 1,            // Run the video in a loop
      fs: 0,              // Hide the full screen button
      cc_load_policy: 0, // Hide closed captions
      iv_load_policy: 3,  // Hide the Video Annotations
      autohide: 0         // Hide video controls when playing
    },
    events: {
      onReady: function (e) {
        e.target.mute();
      }
    }
  });
}


document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('report-modal');
  const hiddenInput = document.getElementById('reported-user-id');

  const userIdDisplay = document.getElementById('user-id-display');  // Reference to the new <p> element
  const reviewIdDisplay = document.getElementById('review-id-display');  // Reference for review ID display

  const hiddenUserInput = document.getElementById('reported-user-id');
  const hiddenReviewInput = document.getElementById('reported-review-id');

  // Toggle dropdowns
  document.querySelectorAll('.menu-toggle').forEach(button => {
    button.addEventListener('click', (e) => {
      e.stopPropagation();
      const items = button.nextElementSibling;
      document.querySelectorAll('.items').forEach(el => {
        if (el !== items) el.style.display = 'none';
      });
      items.style.display = items.style.display === 'block' ? 'none' : 'block';
    });
  });

  // Close dropdowns on outside click
  document.addEventListener('click', () => {
    document.querySelectorAll('.items').forEach(el => el.style.display = 'none');
  });

  // Show modal with user ID
  document.querySelectorAll('.report-btn').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      // Get user ID and review ID from the closest .menu div
      const userId = link.closest('.menu').getAttribute('data-user-id');
      const reviewId = link.closest('.menu').getAttribute('data-review-id');  // Get review ID

      // Set the hidden inputs and update the modal display
      hiddenUserInput.value = userId;
      hiddenReviewInput.value = reviewId;

      modal.classList.add('show');
    });
  });


  // Close modal on outside click
  window.addEventListener('click', (e) => {
    const modal = document.getElementById('report-modal');
    if (e.target === modal) {
      modal.classList.remove('show');
    }
  });

});

