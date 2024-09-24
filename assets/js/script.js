/**
 * header sticky 
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  if (window.scrollY >= 100) {
    header.classList.add("active");  
  } else {
    header.classList.remove("active");
  }
});
