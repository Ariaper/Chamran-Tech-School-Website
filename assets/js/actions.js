// let toggledark = document.getElementById("bodydark");
// let bodyElem = document.body;
// let navElem = document.getElementById("navdark");
// let cardbodyelem = document.querySelectorAll(".card-body");
// let navitemfooter = document.querySelectorAll(".nav flex-column");
// console.log(navitemfooter);
// toggledark.addEventListener("click", function () {
//   bodyElem.classList.toggle("bg-dark");
//   bodyElem.classList.toggle("text-light");
//   navdark.classList.remove("navbar-light");
//   navdark.classList.toggle("navbar-dark");
//   navdark.classList.toggle("bg-dark;");
//   if (bodyElem.className.includes("bg-dark")) {
//     localStorage.setItem("theme", "bg-dark");
//   } else {
//     localStorage.setItem("theme", "bg-light");
//   }
//   cardbodyelem.forEach(function (allcard) {
//     allcard.classList.toggle("bg-dark");
//   });
// });

const loaderElem = document.querySelector(".loader");
window.addEventListener("load", function () {
  loaderElem.classList.add("hidden");
});

// window.onload = function () {
//   let stroagetheme = localStorage.getItem("theme");
//   console.log(stroagetheme);
//   if (stroagetheme === "bg-dark") {
//     bodyElem.classList.add("bg-dark");
//     bodyElem.classList.add("text-light");
//     navdark.classList.remove("navbar-light");
//     navdark.classList.add("navbar-dark");
//     navdark.classList.add("bg-dark;");
//     cardbodyelem.forEach(function (allcard) {
//       allcard.classList.add("bg-dark");
//     });
//   }
// };
// let navbarelem = document.querySelector(".navbar");
// document.addEventListener("scroll", function () {
//   if (document.documentElement.scrollTop > 0) {
//     navbarelem.classList.add("stickynav");
//   } else {
//     navbarelem.classList.remove("stickynav");
//   }
// });
