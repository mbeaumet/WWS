const user = JSON.parse(localStorage.getItem("user")); // Je récupère les données utilisateur dans mon localStorage

if (!user) {
    window.location.replace("/login_logout/login.html");
}