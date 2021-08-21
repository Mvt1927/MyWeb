document.getElementById("input_user").onmousedown = function() {
    delete_error()
};
document.getElementById("input_pass").onmousedown = function() {
    delete_error()
};

function delete_error() {
    document.getElementById("khung_ngoai").classList.remove("noti");
    document.getElementById("label_pass").classList.remove("error");
    document.getElementById("label_user").classList.remove("error");
    document.getElementById("input_pass").classList.remove("error");
    document.getElementById("input_user").classList.remove("error");
};