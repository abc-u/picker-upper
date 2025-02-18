document.addEventListener("DOMContentLoaded", function () {
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownButton.addEventListener("click", function () {
        // メニューが隠れているかどうかでクラスを切り替える
        if (dropdownMenu.classList.contains("dropdown-hidden")) {
            dropdownMenu.classList.remove("dropdown-hidden");
            dropdownMenu.classList.add("dropdown-visible");
        } else {
            dropdownMenu.classList.remove("dropdown-visible");
            dropdownMenu.classList.add("dropdown-hidden");
        }
    });
});
