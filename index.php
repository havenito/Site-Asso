<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="events.css">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Mira events et nos missions</h1>

    <div class="presentation">
        <div class="texte">
            <h2>Présentation de l'asso et ses missions</h2>
            <p>Mira Events est une association dédiée à l'organisation d'événements, en particulier des combats de boxe entre personnes handicapées. Nous visons à promouvoir l'inclusion et à offrir une plateforme où les athlètes peuvent démontrer leur talent et leur détermination.</p>
            <p>Notre mission est de créer des opportunités pour tous, en mettant l'accent sur l'accessibilité et l'égalité dans le sport.</p>
            <p>Nous organisons régulièrement des événements pour sensibiliser le public et célébrer les réussites de nos participants.</p>
            <p>Rejoignez-nous pour soutenir nos événements et nos athlètes, et découvrez comment nous faisons une différence dans la communauté.</p>
            <p>Nous croyons que chacun mérite une chance de briller et de montrer ce dont il est capable, indépendamment de ses capacités physiques.</p>
            <p>Notre équipe est passionnée et dévouée à la cause de l'inclusion par le sport.</p>
            <p>Nous vous invitons à participer à nos événements et à contribuer à notre mission en faisant un don ou en devenant membre de notre association.</p>
            <p>Ensemble, nous pouvons changer les perceptions et ouvrir des portes pour les personnes handicapées dans le monde du sport.</p>
            <p>Merci pour votre soutien et votre engagement envers Mira Events.</p>
        </div>
        <div class="slider">
            <h2>Slider des events à venir</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <h3>Combat de Boxe: Couteau N'aoM vs. Hippi Houda</h3>
                        <p>Un combat intense entre deux boxeurs talentueux.</p>
                        <p>Le 20/07/2024 à 16h00, Gymnase des Arts Martiaux</p>
                    </div>
                    <div class="swiper-slide">
                        <h3>Combat de Boxe: Baradji Aboubacar vs. Lopes Kylian</h3>
                        <p>Assistez à un duel de titans!</p>
                        <p>Le 20/07/2024 à 18h00, Gymnase des Arts Martiaux</p>
                    </div>
                    <div class="swiper-slide">
                        <h3>Combat de Boxe: Kongolo Jean-Claude vs. Brabs Brian</h3>
                        <p>Qui sera le champion ?</p>
                        <p>Le 20/07/2024 à 20h00, Gymnase des Arts Martiaux</p>
                    </div>
                    <div class="swiper-slide">
                        <h3>Combat de Boxe: Attou Zyane vs. Baradjo Mamadou</h3>
                        <p>Un combat que vous ne voudrez pas manquer.</p>
                        <p>Le 20/07/2024 à 22h00, Gymnase des Arts Martiaux</p>
                    </div>
                </div>

                <div class="swiper-pagination"></div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>

    <div class="avis">
        <h2>Vous appréciez nos événements ?</h2><br>
        <button onclick="window.location.href='questionnaire.php'">Donnez votre avis !</button>
    </div>

    <div class="temoignages">
        <h2>Témoignages</h2>
        <div class="temoignage">
            <p>“Merci à Mira Events pour ces événements incroyables qui nous permettent de dépasser nos limites et de montrer nos capacités.”</p>
            <p>Jean-Pierre, participant</p>
            <img src="https://i.pinimg.com/564x/04/72/4d/04724df7addac39e2f8ea468577def0b.jpg" alt="Jean-Pierre's Photo" class="photo">
        </div>
        <div class="temoignage reverse">
            <img src="https://i.pinimg.com/564x/a3/c6/67/a3c6676270aabd870ddaeffd1370c1b1.jpg" alt="Marie's Photo" class="photo">
            <p>“Les combats sont toujours bien organisés et offrent une visibilité exceptionnelle aux athlètes handicapés.”</p>
            <p>Marie, spectatrice</p>
        </div>
    </div>

    <div class="don">
        <button onclick="window.location.href='https://www.helloasso.com/associations/mira-events/adhesions/formulaire-d-adhesion-mira-events-association'">Faire un don via HelloAsso</button>
    </div>
<h3>f</h3>
    <script>
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 10000,
            },
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    </script>
</body>
</html>
<?php include 'footer.php'; ?>