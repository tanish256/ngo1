$('#menul').click(function () {
    $('.container').toggleClass('active');
    $('#menuk').slideToggle();
  });
  $('.blue').click(function(){
    window.open('https://www.scec-technologies.com', 'name'); 
  });
  $(document).ready(function() {
    let currentIndex = 0;
    const galleryImages = $(".gallery-image");
    const modal = $("#modal");
    const modalImg = $("#modal-img");
    const closeBtn = $("#close");
    const prevBtn = $("#prev");
    const nextBtn = $("#next");
  
    // Open the modal when an image is clicked
    galleryImages.on("click", function() {
      currentIndex = galleryImages.index(this);
      modal.show();
      modalImg.attr("src", $(this).attr("src"));
    });
  
    // Close the modal when the "x" button is clicked
    closeBtn.on("click", function() {
      modal.hide();
    });
  
    // Navigate to the next image
    nextBtn.on("click", function() {
      currentIndex = (currentIndex + 1) % galleryImages.length;
      modalImg.attr("src", $(galleryImages[currentIndex]).attr("src"));
    });
  
    // Navigate to the previous image
    prevBtn.on("click", function() {
      currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
      modalImg.attr("src", $(galleryImages[currentIndex]).attr("src"));
    });
  
    // Close the modal if the user clicks outside the image
    $(window).on("click", function(event) {
      if ($(event.target).is(modal)) {
        modal.hide();
      }
    });
    const video = $('#myVideo')[0];
    let userInteracted = false;
    
    // Play video only when the user clicks it
    video.addEventListener('click', function () {
      if (!userInteracted) {
        userInteracted = true;
        video.play();
      }
    });
    
    // Intersection Observer to control playback only if user has interacted
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting && userInteracted) {
          video.play();
        } else {
          video.pause();
        }
      });
    }, { threshold: 0.5 });
    
    observer.observe(video);
    
  });
  $(document).ready(function () {
    // Function to animate the counter
    function animateCounter($this) {
      var target = $this.data('target');
      var current = 0;
      var duration = 2000; // Animation duration in ms
  
      var increment = target / (duration / 50); // Calculate how much to increment every 50ms
  
      function updateNumber() {
        current += increment;
        if (current >= target) {
          current = target;
          clearInterval(interval);
        }
        $this.text(Math.floor(current) + '+');
      }
  
      var interval = setInterval(updateNumber, 50);
    }
  
    // Waypoints to trigger when elements come into view
    $('.counter').waypoint(function (direction) {
      if (direction === 'down') {
        animateCounter($(this.element)); // Animate the counter when it comes into view
      }
    }, { offset: '100%' }); // Trigger animation when 75% of the element is in the viewport
  });
  