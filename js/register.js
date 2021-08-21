document.getElementById("input_name").onmousedown = function() {
    delete_error()
};
document.getElementById("input_user").onmousedown = function() {
    delete_error()
};
document.getElementById("input_email").onmousedown = function() {
    delete_error()
};
document.getElementById("input_pass").onmousedown = function() {
    delete_error()
};
document.getElementById("input_repass").onmousedown = function() {
    delete_error()
};

function delete_error() {
    document.getElementById("khung_ngoai").classList.remove("noti");
    document.getElementById("label_name").classList.remove("error");
    document.getElementById("label_user").classList.remove("error");
    document.getElementById("label_email").classList.remove("error");
    document.getElementById("label_pass").classList.remove("error");
    document.getElementById("label_repass").classList.remove("error");
    document.getElementById("input_name").classList.remove("error");
    document.getElementById("input_user").classList.remove("error");
    document.getElementById("input_email").classList.remove("error");
    document.getElementById("input_pass").classList.remove("error");
    document.getElementById("input_repass").classList.remove("error");

};