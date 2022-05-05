<?php session_start(); ?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <!-- Nous chargeons les fichiers CDN de Leaflet. Le CSS AVANT le JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>
    <script src="affichage.js"></script>
    <link rel="stylesheet" href="style.css" />

    <style type="text/css">
        #map {
            height: 75vh;
        }

        #cont {
            height: auto;
        }
    </style>
    <title>Carte</title>

</head>

<body>
    <?php
    if (isset($_SESSION['id'])) {
    ?>
        <span hidden id="idUser"></span>
        <span hidden id="idDestMsg"></span>
        <span hidden id="lieuClique"></span>

        <div class="ui raised very padded text container segment" id="cont">
            <div class="ui segment">
                <h2 class="ui left floated header">Carte de la ville</h2>
                <div class="ui clearing divider"></div>
                <div class="ui segment" id="map">
                    <!-- Ici s'affichera la carte -->
                </div>
                <button class="ui icon right floated button" id="expand">
                    <i class="expand icon"></i>
                    <button class="ui icon right floated button" id="close">
                        <i class="map icon"></i>
                        <button class="ui toggle labeled icon active button btn" id="monument">
                            <i class="building icon"></i> Monuments
                        </button>
                        <button class="ui toggle labeled icon active button btn" id="parc">
                            <i class="tree icon"></i> Parcs et Jardins
                        </button>
                        <button class="ui toggle labeled icon active button btn" id="biblio">
                            <i class="book icon"></i> Bibliothèques
                        </button>
                        <button class="ui toggle labeled icon active button btn" id="culture">
                            <i class="ticket icon"></i> Espaces Culturels
                        </button>
            </div>
        </div>

        <!-- Fichiers Javascript -->
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
        <script type="text/javascript">
            var latU;
            var longU;
            var listeMarker = new Array();

            /*
            function setID(map) {
                var cpt = 1;
                for (const key of map.keys()) {
                    if (key != cpt) {
                        return cpt;
                    } else {
                        cpt++;
                    }
                }
                return cpt;;
            }
            */

            //var pseudo = prompt("Entrez votre pseudo");
            var pseudo = '<?php echo $_SESSION['pseudo']; ?>';
            var id = '<?php echo $_SESSION['id']; ?>';
            //--------------------------------------------------------------------------------------------
            //on recupere les données stockées dans le navigateur et on les tri dans des tableaux
            var tabDataMonument = localStorage.getItem("tabDataMonument");
            var tabDataMonument = tabDataMonument.split("|");
            tabDataMonument.pop(); //on retire le dernier element ca vide
            for (var i = 0; i < tabDataMonument.length; i++) {
                tabDataMonument[i] = tabDataMonument[i].split(";");
                //console.log(tabDataMonument[i]);
            }
            //console.log(tabDataMonument);

            //----------------------------------------------------------------------------------------
            //on va recuperer les utilisateurs deja connectés sur la map
            var tabUsers = localStorage.getItem("tabUsers");
            var tabUsers = tabUsers.split("|");
            tabUsers.pop(); //on retire le dernier element car vide
            var dictUsers = new Map();
            for (var i = 0; i < tabUsers.length; i++) {
                tabUsers[i] = tabUsers[i].split(";");
                //console.log(tabDataMonument[i]);

                dictUsers.set(tabUsers[i][0], [tabUsers[i][1], tabUsers[i][2], tabUsers[i][3]]);
            }

            //console.log(tabUsers);
            //console.log(dictUsers);
            //id = setID(dictUsers);

            $("#idUser").html(id);
            //------------------------------------------------

            // On initialise la latitude et la longitude de Albi (centre de la carte)
            var lat = 43.925338;
            var lon = 2.148530;
            var macarte = null;
            // Fonction d'initialisation de la carte
            function initMap() {
                //----------------------
                // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
                macarte = L.map('map').setView([lat, lon], 15);
                // Nous ajoutons le marquer de position

                // Nous ajoutons les marqeurs des monuments
                var iconBase = "images/monument_pin.png";
                //initialisation du nouvel icon pour les monuments
                var myIcon = L.icon({
                    iconUrl: iconBase,
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [-3, -76],
                });


                // Nous ajoutons les marqeurs des jardins
                var iconBaseJardin = "images/jardin_pin.png";
                //initialisation du nouvel icon pour les monuments
                var myIconJ = L.icon({
                    iconUrl: iconBaseJardin,
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [-3, -76],
                });

                var iconBaseBiblio = "images/bibliotheque_pin.png";
                var myIconBiblio = L.icon({
                    iconUrl: iconBaseBiblio,
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [-3, -76],
                });

                var iconBaseCulture = "images/culture_pin.png";
                var myIconCulture = L.icon({
                    iconUrl: iconBaseCulture,
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [-3, -76],
                });

                //on place les marqueurs avec le bon icon
                for (var i = 0; i < tabDataMonument.length; i++) {

                    if ((tabDataMonument[i][4]) == "Monuments - Sites touristiques") {
                        var longM = tabDataMonument[i][1];
                        var latM = tabDataMonument[i][2];
                        var marker = L.marker([latM, longM], {
                            icon: myIcon
                        }).addTo(macarte);
                        listeMarker.push(marker);
                        //mise en place des étoiles/notes
                        switch (tabDataMonument[i][5]) {
                            case "1":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i>    <b>1</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "2":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i>    <b>2</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "3":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>     <b>3</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "4":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>4</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "5":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>5</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            default:
                                marker.bindPopup(tabDataMonument[i][0]);
                        }

                    }
                    if ((tabDataMonument[i][4]) == "Parcs et jardins") {
                        var longM = tabDataMonument[i][1];
                        var latM = tabDataMonument[i][2];
                        var marker = L.marker([latM, longM], {
                            icon: myIconJ
                        }).addTo(macarte);
                        listeMarker.push(marker);
                        switch (tabDataMonument[i][5]) {
                            case "1":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i>    <b>1</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "2":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i>    <b>2</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "3":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>     <b>3</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "4":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>4</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "5":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>5</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            default:
                                marker.bindPopup(tabDataMonument[i][0]);
                        }
                    }
                    if ((tabDataMonument[i][4]) == "Mediatheques et Bibliotheques") {
                        var longM = tabDataMonument[i][1];
                        var latM = tabDataMonument[i][2];
                        var marker = L.marker([latM, longM], {
                            icon: myIconBiblio
                        }).addTo(macarte);
                        listeMarker.push(marker);
                        switch (tabDataMonument[i][5]) {
                            case "1":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i>    <b>1</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "2":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i>    <b>2</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "3":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>     <b>3</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "4":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>4</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "5":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>5</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            default:
                                marker.bindPopup(tabDataMonument[i][0]);
                        }
                    }
                    if ((tabDataMonument[i][4]) == "Espaces culturel") {
                        var longM = tabDataMonument[i][1];
                        var latM = tabDataMonument[i][2];
                        var marker = L.marker([latM, longM], {
                            icon: myIconCulture
                        }).addTo(macarte);
                        listeMarker.push(marker);
                        switch (tabDataMonument[i][5]) {
                            case "1":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i>    <b>1</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "2":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i>    <b>2</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "3":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>     <b>3</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "4":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>4</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            case "5":
                                marker.bindPopup(tabDataMonument[i][0] + "<br><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i><i class='star icon'></i>    <b>5</b>/5 <br> <a class='voirAvis' href='#'>Voir les avis</a><br><a class='noterLieu' href='#'>Noter l'établissement</a>");
                                break;
                            default:
                                marker.bindPopup(tabDataMonument[i][0]);
                        }
                    }



                }
                //var marker = L.marker([lat, lon]).addTo(macarte);

                // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    // Il est toujours bien de laisser le lien vers la source des données
                    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                    minZoom: 14,
                    maxZoom: 20
                }).addTo(macarte);


                L.Routing.control({
                    // Nous personnalisons le tracé
                    lineOptions: {
                        styles: [{
                            color: '#ff8f00',
                            opacity: 1,
                            weight: 7
                        }],
                    },

                    // Nous personnalisons la langue et le moyen de transport
                    router: new L.Routing.osrmv1({
                        language: 'fr',
                        profile: 'car' // car, bike, foot,

                    }),

                    geocoder: L.Control.Geocoder.nominatim()
                }).addTo(macarte);

            };





            window.onload = function() {
                // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
                initMap();
                //test geoloc
                if (!navigator.geolocation) {
                    alert("Votre navigateur ne prends pas en charge la geolocalisation")
                } else {
                    /*
                    setInterval(()=>{
                         
                        navigator.geolocation.getCurrentPosition(getPosition,showError,options);
                    },1000);
                    */

                    navigator.geolocation.watchPosition(getPosition);


                }

                var listeMarker = [];
                var marker, circle;

                function getPosition(position) {


                    var iconPosition = "images/position.png";
                    //initialisation du nouvel icon pour les monuments
                    var myIconP = L.icon({
                        iconUrl: iconPosition,
                        iconSize: [50, 50],
                        iconAnchor: [25, 50],
                        popupAnchor: [-3, -76],
                    });

                    //console.log(position);
                    latU = position.coords.latitude;
                    longU = position.coords.longitude;
                    var accuracy = position.coords.accuracy;


                    /*
                    ici on va s'occuper d'updater la position de l'utilisateur dans la BDD
                    */
                    $.ajax({
                        url: 'updatePos.php',
                        type: 'POST',
                        data: {
                            id: id,
                            pseudo: pseudo,
                            long: longU,
                            lat: latU
                        },
                        dataType: 'text',
                        success: function(resultat, statut) {
                            if (resultat != "") alert(resultat); //erreur dans la requete sql
                            else {
                                //console.log("données utilisateur mise a jour")
                                if (marker) {
                                    macarte.removeLayer(marker);
                                }
                                if (circle) {
                                    macarte.removeLayer(circle);
                                }

                                if (accuracy < 100) {
                                    marker = L.marker([latU, longU], {
                                        icon: myIconP
                                    }).addTo(macarte);
                                    circle = L.circle([latU, longU], {
                                        radius: accuracy
                                    });

                                    //marker.bindPopup("<button onclick='() => send()'>Contacter <b>bonjour</b></button>");

                                    //macarte.fitBounds(marker.getBounds());
                                } else {
                                    marker = L.marker([latU, longU], {
                                        icon: myIconP
                                    });
                                    circle = L.circle([latU, longU], {
                                        radius: accuracy
                                    });

                                    featureGroup = L.featureGroup([marker, circle]).addTo(macarte);

                                    macarte.fitBounds(featureGroup.getBounds());
                                }

                                //console.log("lat: " + latU + "\nlong: " + longU + "\nprecision: " + accuracy);
                            }
                            //mise a jour des autres users
                            $.ajax({
                                url: 'getUsers.php',
                                type: 'GET',
                                data: false,
                                dataType: 'text',
                                success: function(data2, statut) {
                                    var toDraw = data2.split("|");
                                    toDraw.pop(); //on retire le dernier element ca vide
                                    for (var i = 0; i < toDraw.length; i++) {
                                        toDraw[i] = toDraw[i].split(";");
                                        //console.log(tabDataMonument[i]);
                                    }
                                    //console.log(toDraw);

                                    //parcours de toDraw pour supprimer moi
                                    var index;
                                    for (var i = 0; i < toDraw.length; i++) {
                                        if (toDraw[i][0] == id) {
                                            index = i;

                                        }
                                    }
                                    toDraw.splice(index, 1);


                                    if (listeMarker) {
                                        for (var i = 0; i < listeMarker.length; i++) {
                                            //console.log("je remove");
                                            macarte.removeLayer(listeMarker[i]);
                                        }
                                    }


                                    for (var i = 0; i < toDraw.length; i++) {
                                        //console.log("id: " + toDraw[i][0]);
                                        var idSend = toDraw[i][0];
                                        var marker1 = L.marker([toDraw[i][3], toDraw[i][2]], {
                                            icon: myIconP
                                        }).addTo(macarte);
                                        listeMarker.push(marker1);
                                        let btn = document.createElement('button');
                                        btn.innerText = 'contacter ' + toDraw[i][1];
                                        btn.id = "test";
                                        //fonction pour l'envoie
                                        btn.onclick = function() {
                                            //faire en sorte de generer une boite de dialogue
                                            //alert("envoie de message");  
                                            $(".test").modal('show');
                                            $("#idDestMsg").html(idSend);
                                        }

                                        marker1.bindPopup(btn, {
                                            maxWidth: 'auto'
                                        });
                                    }




                                },
                                // erreur dans la requête http
                                error: function(resultat, statut, erreur) {
                                    console.log(resultat);
                                    alert(erreur);
                                }


                            });


                        },
                        //erreur dans la requete http
                        error: function(resultat, statut, erreur) {
                            console.log(resultat);
                            alert(erreur);
                        }


                    });





                }


            };
        </script>
        <!--Partie pour la pop up d'envoie de message-->
        <div class="ui modal test">
            <i class="close icon"></i>
            <div class="header">
                Envoyer un Message
            </div>

            <div class="ui form">
                <div class="field">
                    <label>Short Text</label>
                    <textarea id="contenuMsg" rows="2"></textarea>
                </div>
            </div>

            <div class="actions">
                <div class="ui black deny button">
                    Annuler
                </div>
                <div class="ui positive right labeled icon button" id="envoyerMessage">
                    Envoyer
                    <i class="checkmark icon"></i>
                </div>
            </div>
        </div>


        <!--Partie pour la pop up d'envoie de message-->
        <div class="ui modal receive">
            <i class="close icon"></i>
            <div class="header" id="mettrePseudo">
                Vous avez un Message de
            </div>

            <div class="ui form">
                <div class="ui visible message massive">
                    <p id="contenu"></p>
                </div>
            </div>

        </div>



        <!--partie pour la notation / commentaire-->
        <div class="ui modal notation">
            <i class="close icon"></i>
            <span id="nomLieuNote" hidden></span>
            <div class="ui visible message massive">
                <span id="noteF" hidden>0</span>
                <p>Attribuer Une Note</p>
                <i id="star1" class="star icon"></i><i id="star2" class="star icon"></i><i id="star3" class="star icon"></i><i id="star4" class="star icon"></i><i id="star5" class="star icon"></i>
                <br><br>
                <div class="ui form">
                    <div class="field">
                        <label>Laisser un commentaire (facultatif)</label>
                        <textarea id="contenuCommentaire" rows="2"></textarea>
                    </div>
                </div>
            </div>


            <div class="actions">
                <div class="ui positive right labeled icon button" id="envoyerNote">
                    Envoyer
                    <i class="checkmark icon"></i>
                </div>
            </div>
        </div>



        <div class="ui modal com">
            <i class="close icon"></i>
            <div class="header">
                Listes des avis
            </div>


        </div>


        <div class="ui modal listeLieux">
            <i class="close icon"></i>
            <div class="header">
                Creer son circuit
            </div>



            <div class="ui placeholder segment">
                <div class="ui two column very relaxed stackable grid">
                    <div class="column">
                        <div class="ui vertical menu">
                            <div class="ui left pointing dropdown link item">
                                <i class="dropdown icon"></i>
                                Monuments
                                <div id="menuMonuments" class="menu">
                                </div>
                            </div>
                            <div class="ui left pointing dropdown link item">
                                <i class="dropdown icon"></i>
                                Parcs et Jardins
                                <div id="menuParcs" class="menu">
                                </div>
                            </div>
                            <div class="ui left pointing dropdown link item">
                                <i class="dropdown icon"></i>
                                Bibliothèques
                                <div id="menuBiblio" class="menu">
                                </div>
                            </div>
                            <div class="ui left pointing dropdown link item">
                                <i class="dropdown icon"></i>
                                Escpaces Culturels
                                <div id="menuCulture" class="menu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle aligned column">
                        <div class="ui search">
                            <div class="ui icon input">
                                <input id="inputQuery" class="prompt" type="text" placeholder="Rechercher un Lieu">
                                <i class="search icon"></i>
                            </div>
                            <div id="resSearch">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui vertical divider">
                    Or
                </div>
            </div>

            <div class="content">
                <div class="ui list res">
                </div>
            </div>

            <div class="actions">
                <div class="ui black deny button" id="annulerCircuit">
                    Annuler
                </div>
                <div class="ui positive right labeled icon button" id="validerCircuit">
                    Valider
                    <i class="checkmark icon"></i>
                </div>
            </div>

        </div>

    <?php
    } else {
        header('Location: ../login-form-20/logine.php');
        exit();
    }
    ?>








</body>







</html>