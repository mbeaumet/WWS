const urlParams = new URLSearchParams(window.location.search);

if(urlParams.get("logout")) {
    $.ajax({
        url: "logout.php",
        type:"GET",
        dataType: "json",
        success: (res) => {
            //if (res.sucess) 
            localStorage.removeitem("user");
        }
    });
}

$("form").submit((event) => {
    event.preventDefault();
    $.ajax({
        url:"login.php",
        type: "POST",
        dataType:"json",
        data: {
            username_email: $("#username_email").val(),
            pwd: $("#pwd").val(),
        },
        success: (res) => {
            if (res.success) {
                console.log(res);
                console.log(res.user);
                localStorage.setItem("user",JSON.stringify(res.user));
                window.location.replace("http://localhost/Site-World-Wide-Sneakers-bac-2-DWWM-develop/site/welcome_page/welcome_page.html");
            }else{
                alert(res.error);
            }
        }
    })
})