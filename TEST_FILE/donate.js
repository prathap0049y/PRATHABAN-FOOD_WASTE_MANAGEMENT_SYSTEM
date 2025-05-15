document.getElementById("openModal").addEventListener("click", function () {
  document.getElementById("imageModal").style.display = "block";
});

document.querySelector(".close").addEventListener("click", function () {
  document.getElementById("imageModal").style.display = "none";
});

window.addEventListener("click", function (event) {
  if (event.target == document.getElementById("imageModal")) {
    document.getElementById("imageModal").style.display = "none";
  }
});
