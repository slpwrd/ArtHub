function toggleAdminMenu() {
  const menu = document.getElementById("adminMenu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Закрывать меню при клике вне его
document.addEventListener("click", (event) => {
  const menu = document.getElementById("adminMenu");
  const btn = document.querySelector(".admin-menu-btn");
  if (!menu.contains(event.target) && !btn.contains(event.target)) {
    menu.style.display = "none";
  }
});
