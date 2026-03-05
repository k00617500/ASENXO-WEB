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
    
    /* Layout Overrides to prevent double scrollbars and fix sidebar gap */
    html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; background: #000; }
    .app { height: 100vh; display: flex; flex-direction: column; }
    .content-row { display: flex; flex: 1; overflow: hidden; }

    /* Sidebar: Flush to left/top under header */
    .sidebar { width: 200px; background: #000; border-right: 1px solid #222; display: flex; flex-direction: column; flex-shrink: 0; }
    .user-profile-box { padding: 10px 12px; border-bottom: 1px solid #333; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
    .user-avatar { width: 32px; height: 32px; background: var(--accent-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
    .user-name-sidebar { font-weight: 600; font-size: 12px; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* Main Area: One single scrollbar for content */
    .main-content { flex: 1; overflow-y: auto; display: flex; padding: 15px; gap: 15px; }
    .progress-column { flex: 1; }
    .info-column { width: 240px; flex-shrink: 0; position: sticky; top: 0; height: fit-content; display: flex; flex-direction: column; gap: 10px; }

    /* Compact Stepper */
    .step-list { list-style: none; padding: 0; margin: 0; }
    .step-item { background: #1a1a1a; border: 1px solid #333; border-radius: 8px; margin-bottom: 6px; overflow: hidden; }
    .step-header { padding: 6px 14px; display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .step-icon { width: 22px; height: 22px; border-radius: 50%; background: #262626; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 9px; color: #555; }
    
    .step-item.active { border-color: var(--accent-color); background: #1c1c1c; }
    .step-item.active .step-icon { background: var(--accent-color); color: white; }
    .step-item.completed .step-icon { background: var(--accent-color); color: white; }
    .step-title { font-weight: 600; font-size: 11.5px; line-height: 1.2; }
    .step-desc { font-size: 9.5px; color: #666; display: block; }

    /* Form Expansion */
    .step-content { display: none; padding: 10px 14px 14px 46px; border-top: 1px solid #262626; }
    .step-item.active .step-content { display: block; }

    /* Dense Form Grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
    .input-group { margin-bottom: 4px; }
    .input-group label { display: block; font-size: 8.5px; color: #777; margin-bottom: 2px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.3px; }
    .input-group input, .input-group select { width: 100%; padding: 5px 8px; background: #000; border: 1px solid #333; color: white; border-radius: 4px; font-size: 11px; box-sizing: border-box; }
    .input-group input:disabled { opacity: 0.4; border-style: dashed; }
    
    .primary-btn { background: var(--accent-color); color: #000; border: none; padding: 7px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: 700; margin-top: 6px; font-size: 11px; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .spinner { animation: rotate 1s linear infinite; display: none; font-size: 10px; }
    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  </style>
</head>
<body class="dark">
<div class="app">
  <div class="top-header">
    <div class="top-header-left">
      <span class="project-name" style="font-weight: 800;">ASENXO</span>
      <span class="badge production">PRODUCTION</span>
    </div>
    <div class="top-header-right">
      <button class="theme-toggle" id="themeToggle"><i class="fas fa-sun"></i></button>
      <button onclick="handleLogout()" style="background:#ef4444; color:white; border:none; padding:4px 8px; border-radius:4px; font-size:10px; cursor:pointer; font-weight:700;">Logout</button>
    </div>
  </div>

  <div class="content-row">
    <aside class="sidebar">
      <div class="user-profile-box">
        <div class="user-avatar"><i class="fas fa-user"></i></div>
        <div class="user-info-text">
          <span id="sidebarUserName" class="user-name-sidebar">Loading...</span>
        </div>
      </div>
      <div class="sidebar-section">
        <ul class="sidebar-menu">
          <li class="active"><a><i class="fas fa-home"></i> Dashboard</a></li>
          <li><a><i class="fas fa-file-invoice"></i> Applications</a></li>
          <li><a><i class="fas fa-wallet"></i> My Wallet</a></li>
        </ul>
      </div>
    </aside>

    <main class="main-content">
      <div class="progress-column">
        <ul class="step-list" id="middleStepList"></ul>
      </div>

      <aside class="info-column">
        <div class="card" style="padding: 12px; background: #1a1a1a; border: 1px solid #333; border-radius: 8px;">
          <div style="font-size: 9px; color: #777; font-weight: 800; text-transform: uppercase;">Completion</div>
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin: 5px 0;">
             <span id="progressPercent" style="font-size: 18px; font-weight: 800; color: white;">0%</span>
             <span style="font-size: 8px; color: var(--accent-color);">ACTIVE</span>
          </div>
          <div style="height: 4px; background: #000; border-radius: 2px;">
            <div id="progressBar" style="width: 0%; height: 100%; background: var(--accent-color); transition: 0.4s;"></div>
          </div>
        </div>
        <div class="card" style="padding: 12px; background: #1a1a1a; border: 1px solid #333; border-radius: 8px;">
          <div style="font-size: 9px; color: #777; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">File Repository</div>
          <div style="display: flex; justify-content: space-between;"><span style="font-size: 9px; color: #666;">UPLOADED</span><span id="fileCounter" style="font-size: 9px; color: white; font-weight: 700;">0</span></div>
        </div>
      </aside>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
  const S_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
  const S_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw'; 
  const sbClient = supabase.createClient(S_URL, S_KEY);

  let user = null;
  let profile = null;
  let currentStep = 2;

  const steps = [
    { id: 1, title: "Account Selection", desc: "Entity type chosen" },
    { id: 2, title: "Identity Security", desc: "Email confirmation status" },
    { id: 3, title: "Owner Profile", desc: "Detailed background info" },
    { id: 4, title: "Profile Image", desc: "Upload official photo" },
    { id: 5, title: "Business Information", desc: "Registration details" },
    { id: 6, title: "Final Documentation", desc: "Legal permit uploads" }
  ];

  async function init() {
    try {
      const { data: { user: u } } = await sbClient.auth.getUser();
      if (!u) { window.location.href = 'login.php'; return; }
      user = u;

      const { data: p } = await sbClient.from('user_profiles').select('*').eq('id', user.id).single();
      if (p) {
        profile = p;
        document.getElementById('sidebarUserName').innerText = `${p.first_name} ${p.last_name}`;
        currentStep = p.current_step || 2;
        refreshUI();
      }
    } catch (err) { console.error("Init Error:", err); }
  }

  function refreshUI() {
    const percent = Math.round((currentStep / steps.length) * 100);
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressPercent').innerText = percent + '%';
    
    const list = document.getElementById('middleStepList');
    list.innerHTML = steps.map(s => {
      const active = s.id === currentStep;
      const done = s.id < currentStep;
      return `
        <li class="step-item ${active ? 'active' : ''} ${done ? 'completed' : ''}">
          <div class="step-header">
            <div class="step-icon">${done ? '<i class="fas fa-check"></i>' : s.id}</div>
            <div>
              <div class="step-title" style="color:${done ? 'var(--accent-color)' : 'white'}">${s.title}</div>
              <span class="step-desc">${s.desc}</span>
            </div>
          </div>
          <div class="step-content">${getForm(s.id)}</div>
        </li>`;
    }).join('');
  }

  function getForm(id) {
    if (id === 2) return `<button class="primary-btn" onclick="moveNext()">Confirm Email Verified</button>`;
    
    if (id === 3 && profile) {
      return `
      <div class="form-grid">
        <div class="input-group"><label>Owner ID</label><input value="${user.id}" disabled></div>
        <div class="input-group"><label>First Name</label><input value="${profile.first_name}" disabled></div>
        <div class="input-group"><label>Last Name</label><input value="${profile.last_name}" disabled></div>
        <div class="input-group"><label>Email</label><input value="${user.email}" disabled></div>
        
        <div class="input-group"><label>Nickname</label><input id="o_nick" placeholder="e.g. AJ"></div>
        <div class="input-group"><label>Date of Birth</label><input type="date" id="o_dob"></div>
        <div class="input-group"><label>Place of Birth</label><input id="o_pob"></div>
        <div class="input-group"><label>Nationality</label><input id="o_nat" value="Filipino"></div>
        
        <div class="input-group"><label>Sex</label><select id="o_sex"><option>Male</option><option>Female</option></select></div>
        <div class="input-group"><label>Marital Status</label><input id="o_mar" placeholder="Single/Married"></div>
        
        <div class="input-group"><label>Spouse Name</label><input id="o_spo"></div>
        <div class="input-group"><label>Contact Number</label><input id="o_pho"></div>
        <div class="input-group" style="grid-column: span 2;"><label>Full Address</label><input id="o_adr"></div>
        
        <div class="input-group"><label>Enterprise Name</label><input id="o_ent"></div>
        <div class="input-group"><label>Designation</label><input id="o_des"></div>
        <div class="input-group"><label>Affiliations</label><input id="o_aff"></div>
        <div class="input-group"><label>Educational Attainment</label><input id="o_hea"></div>
      </div>
      <button class="primary-btn" id="saveBtn" onclick="saveProfile()">
        <i class="fas fa-circle-notch spinner" id="saveSpn"></i> <span id="saveTxt">Save & Continue</span>
      </button>`;
    }
    return `<p style="font-size:9px; color:#444;">Pending previous steps...</p>`;
  }

  async function saveProfile() {
    const btn = document.getElementById('saveBtn');
    const spn = document.getElementById('saveSpn');
    const txt = document.getElementById('saveTxt');
    
    btn.disabled = true;
    spn.style.display = 'inline-block';
    txt.innerText = 'Processing...';

    const d = {
      owner_ID: user.id,
      owner_name: `${profile.first_name} ${profile.last_name}`,
      owner_nickname: document.getElementById('o_nick').value,
      owner_dob: document.getElementById('o_dob').value,
      owner_pob: document.getElementById('o_pob').value,
      owner_nationality: document.getElementById('o_nat').value,
      owner_sex: document.getElementById('o_sex').value,
      owner_marstat: document.getElementById('o_mar').value,
      owner_spouse: document.getElementById('o_spo').value,
      owner_contactnum: document.getElementById('o_pho').value,
      owner_address: document.getElementById('o_adr').value,
      owner_email: user.email,
      enterprise_name: document.getElementById('o_ent').value,
      enterprise_designation: document.getElementById('o_des').value,
      owner_affiliations: document.getElementById('o_aff').value,
      owner_hea: document.getElementById('o_hea').value
    };

    const { error } = await sbClient.from('owner_profile').upsert([d]);
    
    if (!error) {
      moveNext();
    } else {
      alert("Database error: " + error.message);
      btn.disabled = false;
      spn.style.display = 'none';
      txt.innerText = 'Save & Continue';
    }
  }

  async function moveNext() {
    currentStep++;
    await sbClient.from('user_profiles').update({ current_step: currentStep }).eq('id', user.id);
    refreshUI();
  }

  function handleLogout() { sbClient.auth.signOut().then(() => window.location.href = 'login.php'); }
  window.onload = init;
</script>
</body>
</html>