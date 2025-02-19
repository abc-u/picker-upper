document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.getElementById("menuButton");
    const menuList = document.querySelector(".header-links_menu");

    menuButton.addEventListener("click", function () {
        // メニューが隠れているかどうかでクラスを切り替える
        if (menuList.classList.contains("out")) {
            menuList.classList.remove("out");
            menuList.classList.add("in");
        } else {
            menuList.classList.remove("in");
            menuList.classList.add("out");
        }
    });
});
