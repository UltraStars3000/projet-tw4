<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no" />
    <meta name="description" content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI." />
    <meta name="keywords" content="Semantic-UI, Theme, Design, Template" />
    <meta name="author" content="PPType" />
    <meta name="theme-color" content="#ffffff" />
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>
<?php
include "../login-form-20/connexion.php";

?>

<body id="root">
    <div class="ui large top fixed hidden menu">
        <div class="ui container">
            <a href="../index.php" class="item">Accueil</a> <a href="../map/index.php" class="item">Carte</a>
            <a href="#" class="active item">Statistiques</a> <a href="../index.php#contactForm" class="item">Nous contacter</a>
        </div>
    </div>
    <!--Sidebar Menu-->
    <div class="ui vertical inverted sidebar menu">
        <a href="../index.php" class="item">Accueil</a> <a href="../map/index.php" class="item">Carte</a>
        <a href="#" class="active item">Statistiques</a> <a href="../index.php#contactForm" class="item">Nous contacter</a>
    </div>
    <!--Page Contents-->
    <div class="pusher">
        <div class="ui inverted vertical masthead center aligned segment" style="background-image: url('../login-form-20/images/bg-blur.jpg')">
            <div class="ui container">
                <div class="ui large secondary inverted  menu">
                    <a href="../index.php" class="item">Accueil</a> <a href="../map/index.php" class="item">Carte</a>
                    <a href="#" class="active item">Statistiques</a> <a href="../index.php#contactForm" class="item">Nous contacter</a>
                </div>
            </div>
            <div class="ui text container">
                <h1 class="ui inverted header">Statistiques</h1>
                <h2>Accédez aux données en temps réel sur l'utilisation de la carte interactive</h2>
            </div>
        </div>

        <div class="ui container segments">
            <div class="ui horizontal segments">
                <div class="ui center aligned segment">
                    <h3>Membres inscrits</h3>
                    <?php
                    // compte les membres inscrits
                    $sql = "SELECT COUNT(*) FROM membres";
                    $req = $bdd->prepare($sql);
                    $req->execute();
                    $membres = $req->fetchColumn();
                    echo "<h1 id='membres'>$membres</h1>";
                    ?>
                </div>
                <div class="ui center aligned segment">
                    <h3>Utilisateurs connectés</h3>
                    <?php
                    // compte les membres connectés
                    $sql2 = "SELECT COUNT(*) FROM utilisateurs";
                    $req2 = $bdd->prepare($sql2);
                    $req2->execute();
                    $utilisateurs = $req2->fetchColumn();
                    echo "<h1 id='connect'>$utilisateurs</h1>";
                    ?>
                </div>
            </div>

            <div class="ui raised very padded container segment">
                <canvas id="voteChart"></canvas>
            </div>
            <div class="ui raised very padded container segment">
                <canvas id="noteChart"></canvas>
            </div>
        </div>


        <div id="contactForm" class="ui vertical stripe segment">

        </div>
        <div class="ui inverted vertical footer segment">
            <div class="ui container">
                <div class="ui stackable inverted divided equal height stackable grid">
                    <div class="three wide column">
                        <h4 class="ui inverted header">À propos</h4>
                        <div class="ui inverted link list">
                            <a class="item" href="https://github.com/UltraStars3000/projet-tw4">GitHub</a>
                            <a class="item" href="#root">Contactez-nous</a>
                        </div>
                    </div>
                    <div class="seven wide column">
                        <h4 class="ui inverted header">bla bla bla</h4>
                        <p>
                            mettre un truc intéressant ici
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
    <script type="text/javascript" src="../login-form-20/js/jquery.min.js"></script>
    <script type="text/javascript" src="../login-form-20/js/popper.js"></script>
    <script type="text/javascript" src="../login-form-20/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../login-form-20/js/mdb.min.js"></script>
    <!-- Plugin file -->
    <script src="addons/datatables.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            // fix menu when passed
            $(".masthead").visibility({
                once: false,
                onBottomPassed: function() {
                    $(".fixed.menu").transition("fade in");
                },
                onBottomPassedReverse: function() {
                    $(".fixed.menu").transition("fade out");
                }
            });

            // create sidebar and attach to menu open
            $(".ui.sidebar").sidebar("attach events", ".toc.item");
        });
    </script>


</body>

</html>