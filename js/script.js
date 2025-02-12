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
  });