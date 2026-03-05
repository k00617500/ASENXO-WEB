<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASENXO | MSME Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="src/css/msme-home-style.css">
  <style>
    :root { --accent-color: #2ecc71; }
    .app { animation: fadeInUp 0.6s ease-out; }
    @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
    
    /* Layout Adjustments */
    .user-profile-box { padding: 20px; border-bottom: 1px solid #333; margin-bottom: 10px; text-align: center; }
    .user-avatar { width: 60px; height: 60px; background: var(--accent-color); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; }
    .user-name-sidebar { font-weight: 600; font-size: 14px; color: #fff; display: block; overflow: hidden; text-overflow: ellipsis; }
    
    /* Buttons and UI */
    .primary-btn { background: var(--accent-color); color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; width: 100%; font-weight: 600; margin-top: 15px; transition: opacity 0.2s; }
    .primary-btn:hover { opacity: 0.9; }
    #logoutBtn { background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; }
    .sidebar-menu li.active { border-left: 3px solid var(--accent-color); background: rgba(46, 204, 113, 0.1); color: var(--accent-color); }
    
    /* Form Styling */
    .form-card { background: #1a1a1a; padding: 24px; border-radius: 12px; border: 1px solid #333; }
    .input-group { margin-bottom: 15px; text-align: left; }
    .input-group label { display: block; margin-bottom: 5px; font-size: 13px; color: #aaa; }
    .input-group input { width: 100%; padding: 10px; background: #000; border: 1px solid #333; color: #fff; border-radius: 4px; }
  </style>
</head>
<body class="dark">
<div class="app">
  <div class="top-header">
    <div class="top-header-left">
      <span class="project-name">ASENXO Project</span>
      <span class="badge production">PRODUCTION</span>
    </div>
    <div class="top-header-right">
      <button class="theme-toggle" id="themeToggle" style="margin-right: 15px; background: none; border: none; color: inherit; cursor: pointer;">
        <i class="fas fa-sun"></i>
      </button>
      <button id="logoutBtn">Logout</button>
    </div>
  </div>

  <div class="content-row">
    <div class="sidebar">
      <div class="user-profile-box">
        <div class="user-avatar"><i class="fas fa-user"></i></div>
        <span id="sidebarUserName" class="user-name-sidebar">Loading...</span>
        <small id="sidebarUserEmail" style="color: #666; font-size: 11px;"></small>
      </div>

      <div class="sidebar-section">
        <div class="sidebar-header">MSME DASHBOARD</div>
        <ul class="sidebar-menu" id="sidebarSteps">
          <li data-step="1"><i class="fas fa-user-tag"></i> Account Type</li>
          <li data-step="2"><i class="fas fa-envelope"></i> Email Verification</li>
          <li data-step="4"><i class="fas fa-image"></i> Profile Image</li>
          <li data-step="6"><i class="fas fa-building"></i> Business Info</li>
          <li data-step="8"><i class="fas fa-file-upload"></i> Documents</li>
        </ul>
      </div>
    </div>

    <div class="main-content">
      <div class="progress-column">
        <div id="activeStepForm" class="form-card">
          <h3>Initializing...</h3>
        </div>
      </div>

      <div class="info-column">
        <div class="card">
          <div class="card-title">Progress Overview</div>
          <div class="info-stats">
            <div class="stat-item"><span class="stat-label">Completion</span><span class="stat-value" id="progressPercent">0%</span></div>
            <div class="progress-bar-bg"><div class="progress-bar-fill" id="progressBar" style="width:0%; background: var(--accent-color);"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
  // Replace these with your actual credentials from Supabase Settings
  const SUPABASE_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
  const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw'; 
  const supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

  let currentUser = null;
  let currentStep = 2;

  // --- UI FUNCTIONS ---

  function updateDashboardUI() {
    const totalSteps = 12;
    const percent = Math.round((currentStep / totalSteps) * 100);
    
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressPercent').innerText = percent + '%';

    document.querySelectorAll('#sidebarSteps li').forEach(li => {
      const step = parseInt(li.dataset.step);
      li.classList.remove('active');
      if (step < currentStep) li.style.color = '#2ecc71'; 
      if (step === currentStep) li.classList.add('active');
    });

    renderCurrentForm();
  }

  function renderCurrentForm() {
    const container = document.getElementById('activeStepForm');
    
    switch(currentStep) {
      case 2:
        container.innerHTML = `
          <h3>Step 2: Email Verification</h3>
          <p>We've sent a link to <b>${currentUser.email}</b>. Please confirm your email to continue.</p>
          <button class="primary-btn" onclick="verifyEmailStatus()">I've Verified My Email</button>`;
        break;
      case 4:
        container.innerHTML = `
          <h3>Step 4: Profile Image</h3>
          <p>Please upload a professional profile picture.</p>
          <div class="input-group">
            <input type="file" id="profileImageInput" accept="image/*">
          </div>
          <button class="primary-btn" onclick="moveNext()">Upload & Continue</button>`;
        break;
      case 6:
        container.innerHTML = `
          <h3>Step 6: Business Information</h3>
          <div class="input-group">
            <label>Trade Name / Business Name</label>
            <input type="text" id="bizName" placeholder="Enter business name">
          </div>
          <div class="input-group">
            <label>Business Type</label>
            <input type="text" id="bizType" placeholder="e.g. Retail, Manufacturing">
          </div>
          <button class="primary-btn" onclick="moveNext()">Save Business Info</button>`;
        break;
      default:
        container.innerHTML = `
          <h3>Step ${currentStep}</h3>
          <p>Form for this section is currently being updated.</p>
          <button class="primary-btn" onclick="moveNext()">Skip to Next Step</button>`;
    }
  }

  // --- LOGIC FUNCTIONS ---

  async function verifyEmailStatus() {
    const { data: { user } } = await supabaseClient.auth.getUser();
    if (user.email_confirmed_at) {
      moveNext();
    } else {
      alert("Verification not detected yet. Please check your email inbox.");
    }
  }

  async function moveNext() {
    currentStep++;
    // Use user_profiles since that's where your registration data lives
    const { error } = await supabaseClient
      .from('user_profiles')
      .update({ current_step: currentStep })
      .eq('id', currentUser.id);
      
    if (error) console.error("Error updating progress:", error);
    updateDashboardUI();
  }

  async function init() {
    const { data: { user } } = await supabaseClient.auth.getUser();
    if (!user) { window.location.href = 'login-mock.php'; return; }
    
    currentUser = user;
    document.getElementById('sidebarUserEmail').innerText = user.email;

    // Fetch from user_profiles to get the name
    let { data: profile, error } = await supabaseClient
      .from('user_profiles')
      .select('first_name, last_name, current_step')
      .eq('id', user.id)
      .single();

    // If profile is empty/null, create it to prevent crashes
    if (!profile || error) {
      console.log("Creating missing profile entry...");
      const { data: newProfile } = await supabaseClient
        .from('user_profiles')
        .insert([{ id: user.id, email: user.email, current_step: 2 }])
        .select().single();
      profile = newProfile;
    }

    if (profile) {
      document.getElementById('sidebarUserName').innerText = `${profile.first_name || 'User'} ${profile.last_name || ''}`;
      currentStep = profile.current_step || 2;
      updateDashboardUI();
    }
  }

  // --- EVENT LISTENERS ---

  document.addEventListener('DOMContentLoaded', () => {
    init();

    // Theme Toggle Logic
    const themeBtn = document.getElementById('themeToggle');
    themeBtn.addEventListener('click', () => {
      const body = document.body;
      const icon = themeBtn.querySelector('i');
      if (body.classList.contains('dark')) {
        body.classList.replace('dark', 'light');
        icon.className = 'fas fa-moon';
      } else {
        body.classList.replace('light', 'dark');
        icon.className = 'fas fa-sun';
      }
    });

    document.getElementById('logoutBtn').addEventListener('click', async () => {
      await supabaseClient.auth.signOut();
      window.location.href = 'login-mock.php';
    });
  });
</script>
</body>
</html>