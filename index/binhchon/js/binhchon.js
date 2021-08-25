function Menu() {
    document.getElementById("container").classList.toggle("change"); // thay đổi dấu 3 gạch cạnh menu
    if (document.getElementById("container").classList.value == "container change") {
        document.getElementById("container").classList.toggle("on");
    } else {
        document.getElementById("container").classList.toggle("on");
        document.getElementById("container").classList.toggle("off");
    }
    if (document.getElementById("menu").classList.value == "menu") {
        document.getElementById("menu").classList.toggle("on");
    } else {
        document.getElementById("menu").classList.toggle("on");
        document.getElementById("menu").classList.toggle("off");
    }
    if (document.getElementById("khung_body").classList.value == "khung_body") {
        document.getElementById("khung_body").classList.toggle("on");
    } else {
        document.getElementById("khung_body").classList.toggle("on");
        document.getElementById("khung_body").classList.toggle("off");
    }
};