$(function () {
    //on recupere les données des monuments à la connexion
    //localStorage.clear();
    localStorage.removeItem("tabUsers");
    $.ajax({
        url: 'data.php',
        type: 'GET',
        data: false,
        dataType: 'text',
        success: function (data2, statut) {
            localStorage.setItem("tabDataMonument", data2);//on stocke les données dans le navigateur pour pouvoir y acceder dans le index.html
        },
        // erreur dans la requête http
        error: function (resultat, statut, erreur) {
            console.log(resultat);
            alert(erreur);
        }
    });



    //on recupere les utilisateurs deja connectés
    $.ajax({
        url: 'getUsers.php',
        type: 'GET',
        data: false,
        dataType: 'text',
        success: function (data2, statut) {
            localStorage.setItem("tabUsers", data2);//on stocke les données dans le navigateur pour pouvoir y acceder dans le index.html
        },
        // erreur dans la requête http
        error: function (resultat, statut, erreur) {
            console.log(resultat);
            alert(erreur);
        }
    });


    function triCompare(logged, loggedTmp, listeID) {
        for (const [key, value] of loggedTmp) {
            //console.log(`${key} = ${value}`);
            //on teste si la clé est présente dans la 1ere map
            if (logged.has(key)) {
                //on teste si les coordonnées son différentes
                //si c'est le cas ca veux dire que l'utilisateurs a récemment bougé
                //sinon ca veux dire qu'il est inactif

                var t0 = logged.get(key);
                var t1 = loggedTmp.get(key);
                console.log("t0[1]: " + t0[1] + " t1[1]: " + t1[1]);
                console.log("t0[2]: " + t0[2] + " t1[2]: " + t1[2]);
                if (t0[1] != t1[1] || t0[2] != t1[2]) {
                    //utilisateurs actif
                    logged.set(key, t1);
                }
                if (t0[1] == t1[1] && t0[2] == t1[2]) {
                    //utilisateurs inactif
                    listeID.push(key);
                    logged.delete(key);
                    loggedTmp.delete(key);
                }
            } else {
                logged.set(key, loggedTmp.get(key));
            }
        }
    }


    const logged = new Map();
    // id | pseudo | latitude | longitude
    function updateUsers() {
        var tmp;
        const loggedTmp = new Map();
        var listeID = new Array();

        $.ajax({
            url: 'getUsers.php',
            type: 'GET',
            data: false,
            dataType: 'text',
            success: function (data2, statut) {
                //on tri et on stocke le resultat de la requete dans tmp
                tmp = data2.split("|");
                tmp.pop();//on retire le dernier element car vide
                for (var i = 0; i < tmp.length; i++) {
                    tmp[i] = tmp[i].split(";");
                    loggedTmp.set(tmp[i][0], [tmp[i][1], tmp[i][2], tmp[i][3]]);
                }
                //console.log(loggedTmp);
                //test map
                triCompare(logged, loggedTmp, listeID);
                console.log(listeID);
                //partie delete
                for (var i = 0; i < listeID.length; i++) {
                    var id = listeID[i];
                    $.ajax({
                        url: 'deleteUser.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'text',
                        success: function (data2, statut) {
                            console.log("succes!");
                        },
                        // erreur dans la requête http
                        error: function (resultat, statut, erreur) {
                            console.log(resultat);
                            alert(erreur);
                        }
                    });
                }
            },
            // erreur dans la requête http
            error: function (resultat, statut, erreur) {
                console.log(resultat);
                alert(erreur);
            }
        });

    }

    var intervalID = setInterval(updateUsers, 60000);






});