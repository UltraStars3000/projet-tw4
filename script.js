$(function () {
    //on recupere les données des monuments à la connexion

    $.ajax({
        url: 'data.php',
        type: 'GET',
        data: false,
        dataType: 'text',
        success: function (data2, statut) {
            localStorage.setItem("tabDataMonument",data2);//on stocke les données dans le navigateur pour pouvoir y acceder dans le index.html
        },
        // erreur dans la requête http
        error: function (resultat, statut, erreur) {
            console.log(resultat);
            alert(erreur);
        }
    });



});