<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ASENXO - DOST Region VI Digital Platform">

  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">


  <!-- CSS -->
  <link rel="stylesheet" href="src/css/index-style.css">

  <title>ASENXO</title>
</head>

<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="container nav-inner">

    <!-- LEFT -->
    <div class="nav-brand">
      <img src="src/img/logo-name.png" class="logo-img" alt="ASENXO Logo">

      <div class="brand-segment">
        <a href="#personal" class="segment active">Personal</a>
        <a href="#executive" class="segment">Executive</a>
      </div>
    </div>


    <!-- RIGHT -->
    <nav class="nav-links">
      <a href="#services">Services</a>
      <a href="#programs">Programs</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <a href="#reg" class="btn primary">Apply Now</a>
    </nav>

  </div>
</header>


<!-- HERO -->
<section class="hero">
  <div class="container hero-inner">

    <!-- LEFT -->
    <div class="hero-left">
      <h1>Empowering Smarter Enterprises</h1>

      <p class="lead">
        <strong>ASENXO</strong> together with the <strong>DOST-SETUP 4.0</strong>
        drives digital transformation for Filipino MSMEs through smart
        technologies, automation, and data-driven innovation.
      </p>

      <div class="hero-cta">
     
      <a class="pill-btn primary" href="#services">
        <span class="pill-text">Explore Services</span>
        <span class="pill-dot"></span>
      </a>


        <a class="btn outline">Discover Benefits</a>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="hero-right" style="width: 1100px; height: 500px;">
      <div class="credit-cards" style="width: 900px; height: 350px;">
      <img src="src/img/MSME Card.png"
          class="card card-top"
          alt="MSME Card"
          style="width: 450px; height: auto; max-width: none;">

      <img src="src/img/PSTO Card.png"
          class="card card-mid"
          alt="PSTO Card"
          style="width: 450px; height: auto; max-width: none;">

      <img src="src/img/DOST ADMIN Card.png"
          class="card card-bottom"
          alt="DOST Admin Card"
          style="width: 450px; height: auto; max-width: none;">
     </div>
    </div>


  </div>
</section>


<div class="powered-by">
  <p>Powered by</p>

  <div class="logo-marquee">
    <div class="marquee-track">
      <img src="src/img/marquee/asenxo.png" alt="ASENXO Logo">
      <img src="src/img/marquee/dost.png" alt="DOST Logo">
      <img src="src/img/marquee/stp.png" alt="STP Logo">
      <img src="src/img/marquee/fr.png" alt="FR Logo">
      <img src="src/img/marquee/phlgps.png" alt="PHLGPS Logo">
      <img src="src/img/marquee/qgis.png" alt="QGIS Logo">

      <img src="src/img/marquee/asenxo.png" alt="ASENXO Logo">
      <img src="src/img/marquee/dost.png" alt="DOST Logo">
      <img src="src/img/marquee/stp.png" alt="STP Logo">
      <img src="src/img/marquee/fr.png" alt="FR Logo">
      <img src="src/img/marquee/phlgps.png" alt="PHLGPS Logo">
      <img src="src/img/marquee/qgis.png" alt="QGIS Logo">

      <img src="src/img/marquee/asenxo.png" alt="ASENXO Logo">
      <img src="src/img/marquee/dost.png" alt="DOST Logo">
      <img src="src/img/marquee/stp.png" alt="STP Logo">
      <img src="src/img/marquee/fr.png" alt="FR Logo">
      <img src="src/img/marquee/phlgps.png" alt="PHLGPS Logo">
      <img src="src/img/marquee/qgis.png" alt="QGIS Logo">
    </div>
  </div>
</div>


<!-- FEATURES -->
<section class="features">


</section>


<!-- APP -->
<section class="app-section">
  <div class="app-grid">
    <div class="qr-code"></div>
    <div class="app-name"></div>
  </div>
</section>


<!-- CONTENT GRID -->
<section class="content-grid">
  <div class="main-content"></div>
  <div class="side-content"></div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-bottom">
    <p>© 2025 Department of Science and Technology Region VI.</p>
  </div>
</footer>


<!-- JS -->
<script src="src/js/script.js"></script>
<script>
  setTimeout(() => {
    const cards = [
      document.querySelector('.card-top'),
      document.querySelector('.card-mid'),
      document.querySelector('.card-bottom')
    ];

    cards.forEach((card, i) => {
      card.style.transitionDelay = `${i * 0.2}s`;
      card.classList.add('diagonal');
    });
  }, 800);
</script>
<script>
  const toggle = document.querySelector('.toggle-btn');

  toggle.addEventListener('click', () => {
    const isActive = toggle.classList.toggle('active');
    toggle.setAttribute('aria-pressed', isActive);
  });
</script>





</body>
</html>
