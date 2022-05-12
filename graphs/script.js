window.onload = function () {
    //voteChart.destroy();
    //noteChart.destroy();
    //On récupère les 5 lieux les plus notés
    $.ajax({
        url: 'getTopNb.php',
        type: 'POST',
        success: function (data) {
            var tab = data;
            var tab = tab.split("|");
            tab.pop(); //On retire le dernier élément car vide
            for (var i = 0; i < tab.length; i++) {
                tab[i] = tab[i].split(";");
                tab[i].pop();
            }

            //On crée le graphique
            var ctxB = document.getElementById("voteChart").getContext('2d');
            var voteChart = new Chart(ctxB, {
                type: 'horizontalBar',
                data: {
                    labels: tab[0],
                    datasets: [{
                        label: '# de votes',
                        data: tab[1],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        //Erreur dans la requête http
        error: function (resultat, statut, erreur) {
            alert(erreur);
        }
    });

    //On récupère les 5 lieux les mieux notés
    $.ajax({
        url: 'getTopNote.php',
        type: 'POST',
        success: function (data) {
            var tab_note = data;
            var tab_note = tab_note.split("|");
            tab_note.pop(); //On retire le dernier élément car vide
            for (var i = 0; i < tab_note.length; i++) {
                tab_note[i] = tab_note[i].split(";");
                tab_note[i].pop();
            }

            //On crée le graphique
            var ctxB_note = document.getElementById("noteChart").getContext('2d');
            var noteChart = new Chart(ctxB_note, {
                type: 'horizontalBar',
                data: {
                    labels: tab_note[0],
                    datasets: [{
                        label: 'Note moyenne',
                        data: tab_note[1],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        //Erreur dans la requête http
        error: function (resultat, statut, erreur) {
            alert(erreur);
        }
    });

};


