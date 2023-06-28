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
    slider.scrollTo({
      left: scrollLeft - scroll,
      behavior: 'smooth'
    });
    const links = document.querySelectorAll('.scroll-div a');
    links.forEach((link) => {
      link.style.pointerEvents = 'none';
    });
  });

  slider.addEventListener('mousedown', startDragging, false);
  slider.addEventListener('mouseup', stopDragging, false);
  slider.addEventListener('mouseleave', stopDragging, false);
});