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

  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="src\img\ASENXO-FAVICON.png">

  <!-- CSS -->
  <link rel="stylesheet" href="src/css/index-style.css">

  <title>ASENXO</title>
</head>

<body>
<!-- PRELOADER -->
<div id="preloader">
  <div class="loader-content">

    <h2 class="loader-text">Sa ASENXO, Tuloy ang progreso sa negosyo!</h2>

    <div class="loader-bar"></div>
  </div>
</div>


<!-- NAVBAR -->
<header class="navbar">
  <div class="container nav-inner">

    <!-- LEFT -->
    <div class="nav-brand">
      <img src="src/img/logo-name.png" class="logo-img" alt="ASENXO Logo">

      <div class="brand-segment">
        <a href="#personal" id="personalHover" class="segment active">Personal</a>
        <a href="#executive" id="technicalHover" class="segment">Technical</a>
        <a href="#executive" id="executiveHover" class="segment">Executive</a>
      </div>
    </div>

      <!-- PERSONAL OVERLAY -->
<div id="personalOverlay" class="overlay-hover">
  <div class="overlay-card">

    <div class="overlay-img-container">
      <img src="src/img/personal-card.png" class="overlay-img" alt="MSME Account">
    </div>
    
    <div class="overlay-details">
      <h2>MSME Account</h2>

      <p>
        A centralized platform that helps small businesses apply for programs,
        manage compliance documents, and track progress with ease.
      </p>

      <ul class="feature-list">
        <li>
          <img src="src/img/icons/submit-icon.png" alt="Submit Icon">
          <span>Submit SETUP program applications</span>
        </li>

        <li>
          <img src="src/img/icons/upload-icon.png" alt="Upload Icon">
          <span>Upload and manage requirements</span>
        </li>

        <li>
          <img src="src/img/icons/business-icon.png" alt="Track Icon">
          <span>Track application status in real time</span>
        </li>

        <li>
          <img src="src/img/icons/monitor-icon.png" alt="Dashboard Icon">
          <span>Access dashboards and business insights</span>
        </li>
      </ul>

      <a href="#">Explore →</a>
    </div>

  </div>
</div>


<!-- TECHNICAL OVERLAY -->
<div id="technicalOverlay" class="overlay-hover">
  <div class="overlay-card">

    <div class="overlay-img-container">
      <img src="src/img/technical-card.png" class="overlay-img" alt="Technical Account">
    </div>
    
    <div class="overlay-details">
      <h2>Technical Account</h2>

      <p>
      A dedicated interface for technical PSTOs to assist MSMEs with
      SETUP program requirements, verify documents, and provide guidance submissions and system processes efficiently.
      </p>

      <ul class="feature-list">
        <li>
          <img src="src/img/icons/PSTO/receive-icon.png" alt="Monitor Icon">
          <span>Receive MSME SETUP applications</span>
        </li>  

        <li>
          <img src="src/img/icons/PSTO/eval-icon.png" alt="Document Icon">
          <span>Verify and validate compliance documents</span>
        </li>

        <li>
          <img src="src/img/icons/PSTO/tna-icon.png" alt="Setup Icon">
          <span>Evaluate business TNA & Geographical Area</span>
        </li>

        <li>
          <img src="src/img/icons/PSTO/endorse-icon.png" alt="Setup Icon">
          <span>Endorse enterpreneurs to the region</span>
        </li>

      </ul>

      <a href="#">Explore →</a>
    </div>

  </div>
</div>


<!-- EXECUTIVE OVERLAY -->
<div id="executiveOverlay" class="overlay-hover">
  <div class="overlay-card">

    <div class="overlay-img-container">
      <img src="src/img/executive-card.png" class="overlay-img" alt="Executive Account">
    </div>
    
    <div class="overlay-details">
      <h2>Executive Account</h2>

      <p>
        A management-level dashboard designed for decision-makers to
        oversee projects, financial disbursements, and monitor performance.
      </p>

      <ul class="feature-list">
        <li>
          <img src="src/img/icons/ADMIN\view-icon.png" alt="Approve Icon">
          <span>Review approved SETUP-MSMEs' transactions</span>
        </li>

        <li>
          <img src="src/img/icons/ADMIN/track-icon.png" alt="Team Icon">
          <span>Manage internal projects and workflows</span>
        </li>

        <li>
          <img src="src/img/icons/ADMIN/data-icon.png" alt="Analytics Icon">
          <span>Access performance analytics</span>
        </li>

        <li>
          <img src="src/img/icons/ADMIN/docu-icon.png" alt="Report Icon">
          <span>Generate reports and summaries</span>
        </li>

      </ul>

      <a href="#">Explore →</a>
    </div>

  </div>
</div>






    <!-- RIGHT -->
    <nav class="nav-links">
      <a href="#services">Services</a>
      <a href="#programs">Programs</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <a href="#reg" class="btn primary">Register Now</a>
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

          <!-- HERO STATS -->
    <section class="hero-stats">
      <div class="stats-container">
        <div class="stat">
          <h2 id="msme-count">0</h2>
          <p>SETUP MSMEs in the Region</p>
        </div>
      </div>
    </section>

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

<!-- SERVICES SECTION -->
<section id="services" class="services">
  <div class="services-wrapper">

    <div class="services-left">
      <h2>Services</h2>
      <p>
      ASENXO is an all-in-one platform for MSMEs to manage applications, funds, and performance.
      </p>
    </div>

    <div class="services-right">
      <div class="services-container">

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK1.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG1.png');"></div>
          </div>
        </div>

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK2.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG2.png');"></div>
          </div>
        </div>

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK3.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG3.png');"></div>
          </div>
        </div>

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK4.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG4.png');"></div>
          </div>
        </div>

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK5.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG5.png');"></div>
          </div>
        </div>

        <div class="service-card">
          <div class="card-inner">
            <div class="card-front" style="background-image:url('src/img/services/cards/BG-BACK6.png');"></div>
            <div class="card-back" style="background-image:url('src/img/services/cards/back/BG6.png');"></div>
          </div>
        </div>

      </div>
    </div>

  </div>
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
      card.style.transitionDelay = `${i * 0.5}s`;
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


<script>
  window.addEventListener("load", () => {
    const preloader = document.getElementById("preloader");
    setTimeout(() => {
      preloader.classList.add("hide");
    }, 2000); 
  });
</script>


<script>
function animateCount(id, target, duration) {
  let start = 0;
  const element = document.getElementById(id);
  const stepTime = Math.abs(Math.floor(duration / target)); 
  const timer = setInterval(() => {
    start += 1;
    element.textContent = start;
    if (start >= target) {
      clearInterval(timer);
    }
  }, stepTime);
}

window.addEventListener('load', () => {
  animateCount('msme-count', 1422, 2000); 
});
</script>


<script>
const cards = document.querySelectorAll('.service-card');
cards.forEach(card => {
  card.addEventListener('click', () => {
    const inner = card.querySelector('.card-inner');
    inner.classList.toggle('flipped'); 
  });
});

function goToServices() {
  document.getElementById("services").scrollIntoView({
    behavior: "smooth"
  });
}

</script>

<script>

function scrollServices(e) {
  e.preventDefault();
  document.getElementById("services").scrollIntoView({
    behavior: "smooth"
  });
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const personalBtn = document.getElementById("personalHover");
  const overlay = document.getElementById("personalOverlay");

  let autoCloseTimer;

  personalBtn.addEventListener("mouseenter", function () {

  
    overlay.classList.add("show");

    clearTimeout(autoCloseTimer);

    autoCloseTimer = setTimeout(() => {
      overlay.classList.remove("show");
    }, 3000);

  });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const technicalBtn = document.getElementById("technicalHover");
  const technicalOverlay = document.getElementById("technicalOverlay");

  let autoCloseTimer;

  technicalBtn.addEventListener("mouseenter", function () {

    technicalOverlay.classList.add("show");

    clearTimeout(autoCloseTimer);

    autoCloseTimer = setTimeout(() => {
      technicalOverlay.classList.remove("show");
    }, 3000);

  });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const executiveBtn = document.getElementById("executiveHover");
  const executiveOverlay = document.getElementById("executiveOverlay");

  let autoCloseTimer;

  executiveBtn.addEventListener("mouseenter", function () {

    executiveOverlay.classList.add("show");

    clearTimeout(autoCloseTimer);

    autoCloseTimer = setTimeout(() => {
      executiveOverlay.classList.remove("show");
    }, 3000);

  });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const overlayIDs = ["personalOverlay", "technicalOverlay", "executiveOverlay"];

  overlayIDs.forEach(id => {
    const overlay = document.getElementById(id);
    if (!overlay) return;

    const items = overlay.querySelectorAll(".feature-list li");

    function autoHighlightFeatures() {
      const initialDelay = 500; 
      const interval = 500;     

      items.forEach((item, index) => {
        setTimeout(() => {
         
          items.forEach(i => i.classList.remove("highlight"));
          
          item.classList.add("highlight");
        }, initialDelay + index * interval);
      });

      setTimeout(() => {
        items.forEach(i => i.classList.remove("highlight"));
      }, initialDelay + items.length * interval + 500);
    }


    const observer = new MutationObserver(mutations => {
      mutations.forEach(mutation => {
        if (mutation.attributeName === "class" && overlay.classList.contains("show")) {
          autoHighlightFeatures();
        }
      });
    });

    observer.observe(overlay, { attributes: true });
  });

});
</script>





</body>
</html>
