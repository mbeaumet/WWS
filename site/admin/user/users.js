// Si l'utilisateur n'est pas admin je le redirige vers la page de connexion
if(user.admin == 0) window.location.replace("../../login_logout/login.html");

function createRow(data) {
    data.forEach(elem => {
        console.log(elem);
        // je crée une nouvelle ligne
        const tr = $("<tr></tr>");

        const firstname = $("<td></td>").text(elem.firstname);
        const lastname = $("<td></td>").text(elem.lastname);
        const email = $("<td></td>").text(elem.email);
        const user_name = $("<td></td>").text(elem.user_name);

        tr.append(firstname,lastname,email,user_name);
        $("tbody").append(tr);
    })
}

$.ajax({
    url:"user_admin.php", // url cible 
    type:"GET", // méthode de requète HTTP
    dataType:"json", // Type de réponse attendu
    data: { // donnée a envoyer
        choice: "select"
    },
    success: (res) => {
        createRow(res.users); // j'ajoute a mon tableau les utilisateurs qui matche avec la recherche
    }
})


