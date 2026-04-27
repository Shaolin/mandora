function toggleMode() {
    document.body.classList.toggle("light");
  }
  

 



function toggleMenu() {
  document.getElementById("mobileMenu").classList.toggle("active");
  document.getElementById("overlay").classList.toggle("active");
}



  function toggleMode() {
    document.body.classList.toggle("light");
  
    const btn = document.querySelector(".toggle");
    if (document.body.classList.contains("light")) {
      btn.textContent = "🌞";
    } else {
      btn.textContent = "🌙";
    }
  }

  function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({
      behavior: "smooth"
    });
  }

  
  document.addEventListener("DOMContentLoaded", function () {

    const openBtn = document.getElementById("open-apply-form");
    const modal = document.getElementById("apply-modal");
  
    if (openBtn && modal) {
      openBtn.addEventListener("click", function () {
        modal.style.display = "flex";
      });
    }
  
    const closeBtn = document.querySelector(".close-modal");
  
    if (closeBtn && modal) {
      closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
      });
    }
  
  });