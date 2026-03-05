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
    
    /* Profile & Sidebar Styling */
    .user-profile-box { padding: 20px; border-bottom: 1px solid #333; margin-bottom: 10px; text-align: center; }
    .user-avatar { width: 60px; height: 60px; background: var(--accent-color); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; }
    .user-name-sidebar { font-weight: 600; font-size: 14px; color: #fff; display: block; }
    
    /* Original Step List Styling */
    .step-list { list-style: none; padding: 0; margin-top: 20px; }
    .step-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px; border-radius: 8px; margin-bottom: 8px; transition: 0.3s; opacity: 0.5; }
    .step-item.completed { opacity: 1; color: var(--accent-color); }
    .step-item.active { opacity: 1; background: rgba(46, 204, 113, 0.1); border-left: 3px solid var(--accent-color); }
    .step-icon { width: 24px; height: 24px; border-radius: 50%; background: #333; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
    .step-item.completed .step-icon { background: var(--accent-color); color: #fff; }
    .step-item.active .step-icon { background: var(--accent-color); color: #fff; }

    /* Form UI */
    .form-card { background: #1a1a1a; padding: 24px; border-radius: 12px; border: 1px solid #333; min-height: 300px; }
    .primary-btn { background: var(--accent-color); color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; width: 100%; font-weight: 600; margin-top: 20px; }
    .input-group { margin-bottom: 15px; }
    .input-group label { display: block; margin-bottom: 8px; font-size: 14px; color: #ccc; }
    .input-group input, .input-group select { width: 100%; padding: 12px; background: #0b0b0b; border: 1px solid #333; color: white; border-radius: 6px; }
    
    #logoutBtn { background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
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
        <div class="sidebar-header">APPLICATION STEPS</div>
        <ul class="step-list" id="stepVisualizer">
          </ul>
      </div>
    </div>

    <div class="main-content">
      <div class="progress-column">
        <div id="activeStepForm" class="form-card">
          <h3>Loading Form...</h3>
        </div>
      </div>

      <div class="info-column">
        <div class="card">
          <div class="card-title">Progress Overview</div>
          <div class="info-stats">
            <div class="stat-item"><span class="stat-label">Completion</span><span class="stat-value" id="progressPercent">0%</span></div>
            <div class="progress-bar-bg"><div class="progress-bar-fill" id="progressBar" style="width:0%"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
  const SUPABASE_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
  const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw'; 
  const supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

  let currentUser = null;
  let currentStep = 2;

  // Define steps to match the visual requirement
  const stepsConfig = [
    { id: 1, title: "Choose Account Type", desc: "Personal or Business" },
    { id: 2, title: "Email Verification", desc: "Confirm your account" },
    { id: 3, title: "Personal Information", desc: "Basic details" },
    { id: 4, title: "Profile Image", desc: "Upload photo" },
    { id: 5, title: "Business Information", desc: "Company details" },
    { id: 6, title: "Document Upload", desc: "Requirements" }
  ];

  function updateDashboardUI() {
    // 1. Update Progress Bar
    const percent = Math.round((currentStep / stepsConfig.length) * 100);
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressPercent').innerText = percent + '%';

    // 2. Update Sidebar Stepper Visuals
    const list = document.getElementById('stepVisualizer');
    list.innerHTML = stepsConfig.map(step => {
      let statusClass = '';
      let icon = step.id;
      if (step.id < currentStep) {
        statusClass = 'completed';
        icon = '<i class="fas fa-check"></i>';
      } else if (step.id === currentStep) {
        statusClass = 'active';
      }
      return `
        <li class="step-item ${statusClass}">
          <span class="step-icon">${icon}</span>
          <div class="step-content">
            <div class="step-title" style="font-size:13px; font-weight:600;">${step.title}</div>
            <div style="font-size:11px; color:#666;">${step.desc}</div>
          </div>
        </li>`;
    }).join('');

    renderCurrentForm();
  }

  function renderCurrentForm() {
    const container = document.getElementById('activeStepForm');
    
    if (currentStep === 2) {
      container.innerHTML = `
        <h3>Step 2: Email Verification</h3>
        <p>A verification link was sent to <b>${currentUser.email}</b>.</p>
        <button class="primary-btn" onclick="moveNext()">I've Verified My Email</button>`;
    } 
    else if (currentStep === 3) {
      container.innerHTML = `
        <h3>Step 3: Personal Information</h3>
        <div class="input-group">
          <label>Birth Date</label>
          <input type="date" id="birthdate">
        </div>
        <div class="input-group">
          <label>Contact Number</label>
          <input type="text" id="phone" placeholder="+63 XXX XXX XXXX">
        </div>
        <button class="primary-btn" onclick="moveNext()">Save & Continue</button>`;
    }
    else if (currentStep === 5) {
      container.innerHTML = `
        <h3>Step 5: Business Information</h3>
        <div class="input-group">
          <label>Business Name</label>
          <input type="text" id="bizName" placeholder="Enter Trade Name">
        </div>
        <button class="primary-btn" onclick="moveNext()">Next Step</button>`;
    }
    else {
      container.innerHTML = `
        <h3>Step ${currentStep}</h3>
        <p>You have reached this milestone. Click below to proceed.</p>
        <button class="primary-btn" onclick="moveNext()">Continue to next phase</button>`;
    }
  }

  async function moveNext() {
    currentStep++;
    const { error } = await supabaseClient
      .from('user_profiles')
      .update({ current_step: currentStep })
      .eq('id', currentUser.id);
    
    if (!error) updateDashboardUI();
  }

  async function init() {
    const { data: { user } } = await supabaseClient.auth.getUser();
    if (!user) { window.location.href = 'login-mock.php'; return; }
    currentUser = user;

    let { data: profile } = await supabaseClient
      .from('user_profiles')
      .select('first_name, last_name, current_step')
      .eq('id', user.id)
      .single();

    if (profile) {
      document.getElementById('sidebarUserName').innerText = `${profile.first_name} ${profile.last_name}`;
      document.getElementById('sidebarUserEmail').innerText = user.email;
      currentStep = profile.current_step || 2;
      updateDashboardUI();
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    init();
    
    // Theme Toggle
    document.getElementById('themeToggle').addEventListener('click', () => {
      document.body.classList.toggle('dark');
      document.body.classList.toggle('light');
    });

    document.getElementById('logoutBtn').addEventListener('click', async () => {
      await supabaseClient.auth.signOut();
      window.location.href = 'login-mock.php';
    });
  });
</script>
</body>
</html>