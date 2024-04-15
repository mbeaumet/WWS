// Je récupère les paramètres de mon url 
const ParamUrl = new URLSearchParams(window.location.search); 


// On définit une variable qui servira à savoir si nous voulons inserez ou mettre à jour un article
let article_id = null 

// fonction pour insérer une paire de Sneakers 
function insertSneakers(size,brand,states,price,image,stock){
    const fd = new FormData();
    fd.append('opt',"insert");
    fd.append('size',size);
    fd.append('brand',brand);
    fd.append('state',states);
    fd.append('price',price);
    fd.append('image',image);
    fd.append('stocks',stock);

    $.ajax({
        url: "../sneakers.php",
        type:"POST",
        dataType:"json",
        data:fd,
        contentType: false,
        processData:false,
        cache:false,
        success: (res)=>{
            console.log(res);
            console.log("ok");
            const sneakers = $("<div></div>");
            sneakers.addClass("css_sneakers");
            sneakers.attr("id","sneakers_"+res.id);

            // constante de mise en avant du nom de la chaussure / marque
            const brand_html = $("<h3></h3>").text(brand);

            // contenaire pour le prix + état + taille + stock
            const ctn_desc = $("<div></div>");

            // ajout du prix de la sneakers
            const price_html = $("<p></p>").text(price);
            price_html.addClass("price");

            // ajout de l'état de la sneakers 
            const states_html = $("<p></p>").text(states);

            //ajout de la taille 
            const size_html = $("<p></p>").text(size);

            // ajout du stock 
            const stocks_html = $("<p></p>").text(stock);
            
            // ajout de l'image
            let img; // Je déclare la variable img sans valeur;
            if (res.image) img = $("<img>").attr("src", "/assets/product_img/" + res.image); // Je crée une image et j'affecte la source

            
            // ajout dans le contenaire des élements qui le compose
            ctn_desc.append(price_html,states_html,size_html,stocks_html);
        }
    })
}

$("form").submit((event)=>{
    event.preventDefault(); // J'empèche le rechargement automatique de la page lors de la soumission du formulaire
    console.log("submit");
    // Je récupère les valeurs rentrer dans le formulaire
    const brand = $("#brand").val(); 
    const price = $("#price").val();
    const states = $("#state").val();
    const size = $("#size").val();
    const stock = $("#stock").val();
    const img = $("#image")

    insertSneakers(size,brand,states,price,image,stock);
})
