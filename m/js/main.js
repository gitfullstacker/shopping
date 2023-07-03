const sliders = document.querySelectorAll('.scroll-div');
let mouseDown = false;
let startX, scrollLeft;

sliders.forEach((slider) => {
  let startDragging = function (e) {
    mouseDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  };

  let stopDragging = function (event) {
    mouseDown = false;
    const links = document.querySelectorAll('.scroll-div a');
    links.forEach((link) => {
      link.style.pointerEvents = 'auto';
    });
  };

  slider.addEventListener('mousemove', (e) => {
    e.preventDefault();
    if (!mouseDown) {
      return;
    }
    const x = e.pageX - slider.offsetLeft;
    const scroll = x - startX;
    slider.scrollLeft = scrollLeft - scroll;
    const links = document.querySelectorAll('.scroll-div a');
    links.forEach((link) => {
      link.style.pointerEvents = 'none';
    });
  });

  slider.addEventListener('mousedown', startDragging, false);
  slider.addEventListener('mouseup', stopDragging, false);
  slider.addEventListener('mouseleave', stopDragging, false);
});

$('.my_slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3000,
  dots: true,
  infinite: true,
  adaptiveHeight: true,
  arrows: false
}).on('wheel', (function (e) {
  e.preventDefault();
  if (e.originalEvent.deltaY < 0) {
    $(this).slick('slickNext');
  } else {
    $(this).slick('slickPrev');
  }
}));