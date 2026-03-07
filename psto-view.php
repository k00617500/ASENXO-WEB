<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Details | ASENXO</title>
  <!-- FAVICON (placeholder) -->
  <link rel="icon" type="image/png" href="ASENXO-WEB/favicon.png">
  <!-- Bricolage Grotesque (same as ben-stat) -->
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="../src/css/psto-view-style.css">
</head>
<body class="dark">
<div class="app">
  <header class="top-header">
    <div style="display: flex; align-items: center; gap: 16px;">
      <span class="project-name">ASENXO</span>
      <span class="badge">PROVINCIAL</span>
    </div>
    <button class="theme-toggle" id="themeToggle"><i class="fas fa-sun"></i> Light</button>
  </header>

  <div class="content-row">
<aside class="sidebar">
  <div class="sidebar-section"><div class="sidebar-header">MENU</div>
    <ul class="sidebar-menu">
    <li><a href="psto-home.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
      <li class="active"><a href="psto-ben-stat.php"><i class="fas fa-user-check"></i><span>Beneficiary Status</span></a></li>
      <li><a href="psto-map-view.php"><i class="fas fa-map-marked-alt"></i><span>Map View</span></a></li>
      <li><a href="psto-tna-tool.php"><i class="fas fa-clipboard-list"></i><span>TNA Tool</span></a></li>
      <li><a href="psto-revisions.php"><i class="fas fa-history"></i><span>Revisions</span></a></li>
      <li><a href="psto-endorsement.php"><i class="fas fa-check-circle"></i><span>Endorsement</span></a></li>
      <li><a href="psto-settings.php"><i class="fas fa-gear"></i><span>Settings</span></a></li>
    </ul>
  </div>
</aside>

    <main class="main-content">
      <!-- two column profile: left = iFund client info (with profile pic), right = enterprise profile (Oye) -->
      <div class="profile-grid">
        <!-- CLIENT INFORMATION SHEET (owner) with profile picture -->
        <div class="info-card">
          <div class="client-card-with-pic">
            <!-- profile picture added here -->
            <div class="profile-pic-large"></div>
            <div class="info-content">
              <h3 style="margin-top: 0; border-bottom: none; padding-bottom: 0;"><i class="fas fa-user-circle"></i> iFund Client Information</h3>
              <div class="info-row"><span class="info-label">Full name</span><span class="info-value">Salazar, Elizabeth T.</span></div>
              <div class="info-row"><span class="info-label">Nickname</span><span class="info-value">Beth</span></div>
              <div class="info-row"><span class="info-label">Date / Place of birth</span><span class="info-value">15 Mar 1985 · San Jose, Antique</span></div>
              <div class="info-row"><span class="info-label">Nationality</span><span class="info-value">Filipino</span></div>
            </div>
          </div>
          <div class="gender-marital" style="margin-left: 0; margin-top: 8px;">
            <span class="tag"><i class="fas fa-venus-mars"></i> Female</span>
            <span class="tag"><i class="fas fa-heart"></i> Married</span>
          </div>
          <div class="info-row"><span class="info-label">Spouse</span><span class="info-value">Salazar, Mario R.</span></div>
          <div class="divider"></div>
          <div class="info-row"><span class="info-label">Home address</span><span class="info-value">22 Mabini St., Brgy 2, San Jose, Antique 5700</span></div>
          <div class="info-row"><span class="info-label">Contact Nos.</span><span class="info-value">09561363994 / (036) 540-1234</span></div>
          <div class="info-row"><span class="info-label">Email address</span><span class="info-value">bethsalzar2017@gmail.com</span></div>
          <div class="divider"></div>
          <div class="info-row"><span class="info-label">Company name</span><span class="info-value">Oye Fruit Wine Manufacturing</span></div>
          <div class="info-row"><span class="info-label">Company address</span><span class="info-value">Bantayan St., Brgy 2, San Jose, Antique</span></div>
          <div class="info-row"><span class="info-label">Designation</span><span class="info-value">Owner / Manager</span></div>
          <div class="info-row"><span class="info-label">Highest education</span><span class="info-value">BS Business Management</span></div>
          <div class="info-row"><span class="info-label">Affiliations</span><span class="info-value">San Jose Women's Cooperative, Antique Food Processors Assoc.</span></div>
        </div>

        <!-- COMPANY PROFILE (Oye Fruit Wine) with Latitude & Longitude -->
        <div class="info-card">
          <h3><i class="fas fa-building"></i> Enterprise Profile</h3>
          <div class="info-row"><span class="info-label">Name of Firm</span><span class="info-value">Oye Fruit Wine Manufacturing</span></div>
          <div class="info-row"><span class="info-label">Address</span><span class="info-value">Bantayan St., Barangay 2, San Jose, Antique</span></div>
          <div class="info-row"><span class="info-label">Contact Person</span><span class="info-value">Elizabeth T. Salazar</span></div>
          <div class="info-row"><span class="info-label">Contact No.</span><span class="info-value">09561363994</span></div>
          <div class="info-row"><span class="info-label">Email</span><span class="info-value">bethsalzar2017@gmail.com</span></div>
          <div class="info-row"><span class="info-label">Year Established</span><span class="info-value">2025 </span></div>
          
          <!-- NEW: Latitude & Longitude -->
          <div class="info-row geo-row">
            <span class="info-label"><i class="fas fa-map-pin"></i> Latitude</span>
            <span class="info-value">10.7432° N</span>
          </div>
          <div class="info-row geo-row">
            <span class="info-label"><i class="fas fa-map-marker-alt"></i> Longitude</span>
            <span class="info-value">121.9435° E</span>
          </div>

          <div style="display: flex; gap: 20px; flex-wrap: wrap; margin: 12px 0;">
            <span class="tag">Single Proprietorship</span>
            <span class="tag">Profit</span>
            <span class="tag">Micro (≤₱3M TAV)</span>
          </div>

          <!-- employee table -->
          <table class="emp-table">
            <tr><th>Employment</th><th>Male</th><th>Female</th><th>Total</th></tr>
            <tr><td>Direct Production</td><td>2</td><td>0</td><td>2</td></tr>
            <tr><td>Direct Non‑Production</td><td>0</td><td>1</td><td>1</td></tr>
            <tr><td>Indirect/Contract</td><td>-</td><td>-</td><td>-</td></tr>
            <tr><td><strong>Total</strong></td><td><strong>2</strong></td><td><strong>1</strong></td><td><strong>3</strong></td></tr>
          </table>

          <!-- registration -->
          <div class="reg-grid">
            <div><span class="info-label">DTI</span> 7131804 (07 May 2025)</div>
            <div><span class="info-label">Mayor's Permit</span> BP-2025-02216-0 (21 May 2025)</div>
            <div><span class="info-label">BIR</span> 485-903-456-000 (TIN)</div>
          </div>

          <div class="info-row"><span class="info-label">Business activity</span><span class="info-value">Beverage manufacturing / Food processing</span></div>
          <div class="info-row"><span class="info-label">Brief background</span><span class="info-value">Oye Fruit Wine started as a small venture under Kusina ni Oye in 2019. Formally registered in 2025 with DTI encouragement. Participated in DOST Consultancy on Food Safety.</span></div>
        </div>
      </div>

      <!-- FILE UPLOADS = REQUIREMENTS checklist, each with upload date (exactly as reference) -->
      <div class="file-checklist-section">
        <div class="section-header">
          <h3><i class="fas fa-clipboard-check"></i> Requirements & Uploads</h3>
        </div>

        <div class="req-list">
          <!-- item 1 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">1. Approved Request for Technical Assistance</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 12 Mar 2026</span></div>
          <!-- 2 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">2. DOST TNA Form 01 (Application for TNA)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 05 Mar 2026</span></div>
          <!-- 3 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">3. DOST TNA Form 02 + Technology Level Assessment</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 18 Mar 2026</span></div>
          <!-- 4 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">4. Letter of intent (refund & insurance commitment)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 20 Feb 2026</span></div>
          <!-- 5 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">5. SETUP Form 001 Project Proposal (Annex A-1)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 22 Mar 2026</span></div>
          <!-- 6 (Mayor's permit & DTI reg) -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">6. Mayor's permit / DTI registration (photocopy)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 10 Jan 2026</span></div>
          <!-- 7 -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">7. Company cash/sales invoice (photocopy)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 15 Mar 2026</span></div>
          <!-- 8 (Board resolution) -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">8. Board Resolution authorizing availment</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 28 Feb 2026</span></div>
          <!-- 9 Financial statements + sworn statement -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">9. In-house FS (3 yrs) + notarized sworn statement</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 01 Apr 2026</span></div>
          <!-- 10 Sworn affidavit (no relation / bad debt) -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">10. Sworn affidavit (consanguinity / bad debt)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 04 Apr 2026</span></div>
          <!-- 11 tech specs -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">11. Equipment technical specs / drawings</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 25 Mar 2026</span></div>
          <!-- 12 Three quotations -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">12. Three quotations (fermenters, bottles, etc.)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 30 Mar 2026</span></div>
          <!-- 13 Projected FS -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">13. Projected Financial Statements (5 years)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 02 Apr 2026</span></div>
          <!-- 14 (NGO/PO specific, but we include if applicable) -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">14. Work & Financial Plan / equity details</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 06 Apr 2026</span></div>
          <!-- 15 GAD Checklist -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">15. GAD Checklist 2 (project identification)</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 07 Apr 2026</span></div>
          <!-- 16 Data Privacy Consent -->
          <div class="req-item"><div class="req-info"><i class="fas fa-check-circle check-badge"></i><span class="req-name">16. Data Privacy Consent Form</span></div><span class="req-date"><i class="far fa-calendar-alt"></i> 08 Apr 2026</span></div>
        </div>

        <!-- subtle note: all files have been uploaded with dates (as per requirement) -->
        <div style="display: flex; gap: 20px; margin-top: 20px; color: var(--text-muted); font-size: 12px; border-top: 1px solid var(--border-light); padding-top: 16px;">
          <span><i class="fas fa-check-circle" style="color: var(--green);"></i> 16/16 requirements complied</span>
          <span><i class="far fa-clock"></i> latest upload: 08 Apr 2026</span>
        </div>
      </div>


    </main>
  </div>
</div>

<!-- theme toggle (same as ben-stat) -->
<script>
  document.getElementById('themeToggle').onclick = function() {
    document.body.classList.toggle('dark');
    const btn = document.querySelector('#themeToggle');
    if (document.body.classList.contains('dark')) {
      btn.innerHTML = '<i class="fas fa-sun"></i> Light';
    } else {
      btn.innerHTML = '<i class="fas fa-moon"></i> Dark';
    }
  };
</script>
</body>
</html>