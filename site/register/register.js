$("form").submit((event) => {
    event.preventDefault();

    $.ajax({
        url:"register.php",
        type: "POST",
        dataType: "json",
        data: {
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            user_name: $("#username").val(),
            email: $("#email").val(),
            pwd: $("#pwd").val()
        },
        success: (res) => {
            console.log(res);
            if (res.success) window.location.replace("../../site/login_logout/login.html");
            else console.log("error");
                //alert(res.error);
        }
    });
});