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
            //console.log(resultat);
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
            //console.log(resultat);
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
                //console.log("t0[1]: " + t0[1] + " t1[1]: " + t1[1]);
                //console.log("t0[2]: " + t0[2] + " t1[2]: " + t1[2]);
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
                //console.log(listeID);
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


    $(".test").modal({
		closable: true
	});

    $("#envoyerMessage").click(function(){
        var sender = $("#idUser").text();
        var receiver = $("#idDestMsg").text();
        var msg = $("#contenuMsg").val();

        console.log("envoie message");
        console.log("de: "+sender);
        console.log("à: "+receiver);
        console.log("contenu: "+msg);

        //envoie du message dans la bdd
        $.ajax({
            url: 'sendMsg.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver,
                msg: msg
            },
            dataType: 'text',
            success: function (data2, statut) {
                console.log("message envoyé avec succes!");
            },
            // erreur dans la requête http
            error: function (resultat, statut, erreur) {
                console.log(resultat);
                alert(erreur);
            }
        });
    });



    //reception des massages
    function receiveMsg() {
        var id = $("#idUser").text();

        //reception des massages qui me sont destinés
        $.ajax({
            url: 'receiveMsg.php',
            type: 'GET',
            data: {
                id: id 
            },
            dataType: 'text',
            success: function (data2, statut) {
                //afficher le message
                //console.log(data2);
                    var message;
                    //console.log("je passe par la");
                    var tab = data2.split(";")
                    var pseudo = tab[0];
                    message = tab[1];

                    if(message){
                        console.log("pseudo: "+pseudo);
                        console.log("message: "+message);
                        $("#mettrePseudo").html("Vous avez un message de "+pseudo);
                        $("#contenu").html(message);
                        $(".receive").modal('show');
                    }

                    
                
            },
            // erreur dans la requête http
            error: function (resultat, statut, erreur) {
                //console.log(resultat);
                alert(erreur);
            }
        });
    }

    var intervalID2 = setInterval(receiveMsg, 10000);

   

    function updateNote(){
        //on recupere les notes de tout les lieux
        //une fois récupéré, on traverse le dom pour mettre a jour le nombre d'étoile et l'affichage de la note
        var lieuxNote = new Map();
        $.ajax({
            url: 'getNote.php',
            type: 'GET',
            data: false,
            dataType: 'text',
            success: function (data2, statut) {
                var tab = data2;
                var tab = tab.split("|");
                tab.pop();//on retire le dernier element ca vide
                for (var i = 0; i < tab.length; i++) {
                    tab[i] = tab[i].split(";");
                }

                /*
                tab[i][0] = nom du lieu
                tab[i][1] = categorie
                tab[i][2] = note
                */
               //on rempli le dictionnaire
               for(var i=0; i<tab.length; i++){
                    lieuxNote.set(tab[i][0],(parseInt(tab[i][2]/tab[i][3])).toString())   
                    //console.log((parseInt(tab[i][2]/tab[i][3])).toString());
               }

                //var listePin = $('.leaflet-marker-icon');
                for(var i = 0; i<listeMarker.length; i++){
                    //console.log((listeMarker[i]).getPopup().getContent());
                    var content = (listeMarker[i]).getPopup().getContent();
                    content = content.split("<");
                    var nomLieu = content[0];
                    var nouvelleNote = lieuxNote.get(nomLieu);
                    //console.log(nomLieu+","+nouvelleNote);
                    
                    switch (nouvelleNote){
                        case "1":
                            (listeMarker[i]).getPopup().setContent(nomLieu+"<br><i class='star icon'></i>    <b>1</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                            break;
                        case "2":
                            (listeMarker[i]).getPopup().setContent(nomLieu+"<br><i class='star icon'></i><i class='star icon'></i>    <b>2</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                            break;
                        case "3":
                            (listeMarker[i]).getPopup().setContent(nomLieu+"<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>     <b>3</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                            break;
                        case "4":
                            (listeMarker[i]).getPopup().setContent(nomLieu+"<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>4</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                            break;
                        case "5":
                            (listeMarker[i]).getPopup().setContent(nomLieu+"<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>5</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                            break;
                        default:
                            (listeMarker[i]).getPopup().setContent(nomLieu);
                    }
                    (listeMarker[i]).getPopup().update();
                }

  
                
            },
            // erreur dans la requête http
            error: function (resultat, statut, erreur) {
                //console.log(resultat);
                alert(erreur);
            }
        });

    }
    var intervalID4 = setInterval(updateNote, 10000);


    var txt;
    var commentaire;
    var note;
    $(".leaflet-pane").click(function(e){
        //selection de noter l'établissement
        txt = ($(this)[0]);
        //console.log($(txt).text());
        txt = $(txt).text()
        txt = txt.split("/");
        txt = txt[0];
        txt = txt.substring(0, txt.length - 2);
       
        $("#nomLieuNote").html(txt);

        $(".noterLieu").click(function(){
            $(".notation").modal('show');
            //gestion animation etoile
            $(".star.icon").hover(function(){
                var idE = $(this).attr("id");
                //console.log(idE);
                var note = idE.substr(-1);
                switch(note){
                    case '1':
                        $("#star1").addClass("yellow");
                        $("#star2").removeClass("yellow");
                        $("#star3").removeClass("yellow");
                        $("#star4").removeClass("yellow");
                        $("#star5").removeClass("yellow");
                        $("#noteF").html(note);
                        break;
                    case '2':
                        $("#star1").addClass("yellow");
                        $("#star2").addClass("yellow");
                        $("#star3").removeClass("yellow");
                        $("#star4").removeClass("yellow");
                        $("#star5").removeClass("yellow");
                        $("#noteF").html(note);
                        break;
                    case '3':
                        $("#star1").addClass("yellow");
                        $("#star2").addClass("yellow");
                        $("#star3").addClass("yellow");
                        $("#star4").removeClass("yellow");
                        $("#star5").removeClass("yellow");
                        $("#noteF").html(note);
                        break;
                    case '4':
                        $("#star1").addClass("yellow");
                        $("#star2").addClass("yellow");
                        $("#star3").addClass("yellow");
                        $("#star4").addClass("yellow");
                        $("#star5").removeClass("yellow");
                        $("#noteF").html(note);
                        break;
                    case '5':
                        $("#star1").addClass("yellow");
                        $("#star2").addClass("yellow");
                        $("#star3").addClass("yellow");
                        $("#star4").addClass("yellow");
                        $("#star5").addClass("yellow");
                        $("#noteF").html(note);
                        break;
                    default:
                        $("#star1").removeClass("yellow");
                        $("#star2").removeClass("yellow");
                        $("#star3").removeClass("yellow");
                        $("#star4").removeClass("yellow");
                        $("#star5").removeClass("yellow");
                        $("#noteF").html(note);
                        
                }

            })

        });


        $(".voirAvis").click(function(){
            //console.log("test");
            $(".com").modal('show');
            $("#lieuClique").html(txt);

            var nom = $("#lieuClique").text();
            
            //on recupere les commentaires pour ce lieux
            $.ajax({
                url: 'getCom.php',
                type: 'GET',
                data: false,
                dataType: 'text',
                success: function (data2, statut) {
                    var resCom = data2.split("|");
                    resCom.pop();
                    for (var i = 0; i < resCom.length; i++) {
                        resCom[i] = resCom[i].split(";");
                        
                    }

                    var enfants = $(".ui.modal.com").children();
                    for(var i=2; i<enfants.length; i++){
                        $(enfants)[i].remove();
                    }

                    for (var i = 0; i < resCom.length; i++) {
                        //console.log(nom);
                        //console.log(resCom[i][0]);
                        if(nom.trim() == (resCom[i][0]).trim()){
                            console.log(nom+" "+resCom[i][1]+" "+resCom[i][2]+" "+resCom[i][3]);

                            var el = "<div class='ui raised card'> <div class='content'> <div class='meta'> <span class='right floated time'>le "+resCom[i][3]+"</span></div> <div class='description'><p>"+resCom[i][1]+"</p></div></div> <div class='extra content'> <div class='right floated author'><span>Par "+resCom[i][2]+"</span></div> </div> </div> <br>";
                            $(".ui.modal.com").append(el);

                        }
                    }
                    $(".ui.modal.com").append("<br>");

                
                    
                        
                },
                // erreur dans la requête http
                error: function (resultat, statut, erreur) {
                    //console.log(resultat);
                    alert(erreur);
                }
            });
            
    
        });

      
    });

    $("#envoyerNote").mousedown(function(){
        //confirmation avec le boutton
        var nom = txt;
        commentaire = $("#contenuCommentaire").val();
        note = $("#noteF").text();
        //on poste la note
        //console.log(nom);
        $.ajax({
            url: 'sendNote.php',
            type: 'POST',
            data: {
                nom: nom,
                note: note
            },
            dataType: 'text',
            success: function (data2, statut) {
                console.log("note envoyé avec succes!");
            },
            // erreur dans la requête http
            error: function (resultat, statut, erreur) {
                console.log(resultat);
                alert(erreur);
            }
        });

        console.log("nom :"+nom+" comm :"+commentaire+" pseudo :"+pseudo);
        if(commentaire != ""){
            $.ajax({
                url: 'sendCom.php',
                type: 'POST',
                data: {
                    nom: nom,
                    commentaire: commentaire,
                    pseudo: pseudo
                },
                dataType: 'text',
                success: function (data2, statut) {
                    console.log("commentaire envoyé avec succes!");
                },
                // erreur dans la requête http
                error: function (resultat, statut, erreur) {
                    console.log(resultat);
                    alert(erreur);
                }
            });
        }


      }) ;


    

      function subs(src, sub) {
        var index = src.indexOf(sub);
        if (index !== -1) {
            return true
        }
        else {
            return false
        }
    }

    


    //gestion des itineraires
    $(".leaflet-routing-container").get(0).style.visibility = "hidden";
    $('#close').click(function () {
        $(".listeLieux").modal('show');
        
        
        $('.ui.dropdown')
        .dropdown()
      ;

      $(".ui.left.pointing.dropdown.link.item").click(function(){
        $("#resSearch").empty();
      });

      console.log(tabDataMonument);
      for(var i = 0; i<tabDataMonument.length; i++){
          if(tabDataMonument[i][4]=="Monuments - Sites touristiques"){
            $("#menuMonuments").append("<div class='item lieux'>"+tabDataMonument[i][0]+"</div>");
          }

          if(tabDataMonument[i][4]=="Parcs et jardins"){
            $("#menuParcs").append("<div class='item lieux'>"+tabDataMonument[i][0]+"</div> ");
          }

          if(tabDataMonument[i][4]=="Mediatheques et Bibliotheques"){
            $("#menuBiblio").append("<div class='item lieux'>"+tabDataMonument[i][0]+"</div> ");
          }

          if(tabDataMonument[i][4]=="Espaces culturel"){
            $("#menuCulture").append("<div class='item lieux'>"+tabDataMonument[i][0]+"</div> ");
          }

      }


      $("#inputQuery").click(function(e){
        $(this).keyup(function(){
            $("#resSearch").empty();
            //console.log($("#inputQuery").val());
            var toSearch = $("#inputQuery").val();
            //parcour de tout les monuments
            for(var i = 0; i<tabDataMonument.length; i++){
                var testS = true;
                for(var j = 0; j<toSearch.length; j++){
                    if((toSearch[j]).toLowerCase() == ((tabDataMonument[i][0])[j]).toLowerCase()){
                        testS = testS && true;
                    }else{
                        testS = false;
                    }
                }
                if(testS && toSearch.length != 0){
                    //console.log(tabDataMonument[i][0]);
                    var t = "<div class='item lieux test'>"+tabDataMonument[i][0]+"</div>";  
                    $("#resSearch").append(t);
                }
            }
            $(".item.lieux.test").click(function(e){
                var val = $(this).text();
                $(".ui.list.res").append("<div class='item ListeRes'> <i class='marker icon'></i> <div class='content'>"+val+"</div> </div>");
               
                $(".item.ListeRes").click(function(){
                    $(this).remove();
                  });
            });
        }); 
      });

      $(".item.lieux").click(function(e){
        //console.log($(this).text());
        var val = $(this).text();
        $(".ui.list.res").append("<div class='item ListeRes'> <i class='marker icon'></i> <div class='content'>"+val+"</div> </div> ");
        $(".item.ListeRes").click(function(){
            $(this).remove();
          });
      });

      
      $("#annulerCircuit").click(function(){
        $(".ui.list.res").empty();
        $("#menuMonuments").empty();
        $("#menuParcs").empty();
        $("#menuBiblio").empty();
        $("#menuCulture").empty();
        $(".leaflet-routing-container").get(0).style.visibility = "hidden";
      });


      $("#validerCircuit").click(function(){
        let tabEtapes = $(".ui.list.res").children();
        let tabNomEtapes = [];
        for(var i = 0; i<tabEtapes.length; i++){
            tabNomEtapes.push($(tabEtapes[i]).text())
        }
        for(var i = 0; i<tabNomEtapes.length; i++){
            tabNomEtapes[i] = tabNomEtapes[i].substring(2,tabNomEtapes[i].length - 1)
        }

        //on recupere les coordonnées de chaque lieu
        var dictLieu = new Map();
        var cpt = 1;
        for(var i = 0; i<tabDataMonument.length; i++){
           
            for(var j = 0; j<tabNomEtapes.length; j++){
                if(tabNomEtapes[j] == (tabDataMonument[i][0])){
                    dictLieu.set(cpt,tabDataMonument[i][2]+","+tabDataMonument[i][1])
                    cpt ++;
                }
            }
        }

        console.log(dictLieu);
        //on a une map ou les clés sont les nom de lieux et les valeurs sont les coordonnées
        //on commence par entrer les coordonnées de l'utilisateur dans l'input start

        for(var i = 0; i<dictLieu.size - 1; i++){
            $(".leaflet-routing-add-waypoint ").click();

        }

        var crdU = latU+","+longU;
        var inputD = $(".leaflet-routing-geocoders").children();
        var inputDepart = $(inputD[0]).children();
        inputDepart = inputDepart[0];
        inputDepart.value = crdU;


        //parcour du dictionnaire avec les coords des lieux
        var e = jQuery.Event("keypress");
        e.which = 13; //choose the one you want
        e.keyCode = 13;
        
        for(const [keys, values] of dictLieu.entries()){
            console.log(values);
            var inputDepart = $(inputD[keys]).children();
            inputDepart = inputDepart[0];
            inputDepart.value = values;
        
            
       
              
        }
        

    });

      if ($(".leaflet-routing-container").get(0).style.visibility == "hidden") {
        $(".leaflet-routing-container").get(0).style.visibility = "visible";
        
        }
        else {
            $(".leaflet-routing-container").get(0).style.visibility = "hidden";
        } 
    });

 
    
    
    
    
});

