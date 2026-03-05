<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASENXO | MSME Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="src/css/msme-home-style.css">
  <style>
    :root { --accent: #2ecc71; --bg: #0d0d0d; --card: #1a1a1a; --border: #333; }
    body { background: var(--bg); color: #e0e0e0; font-family: 'Inter', sans-serif; margin: 0; }

    /* Layout Structure */
    .app { display: flex; flex-direction: column; height: 100vh; }
    .content-row { display: flex; flex: 1; padding: 15px; gap: 15px; overflow: hidden; }
    
    /* Sidebar Navigation */
    .sidebar { width: 210px; flex-shrink: 0; display: flex; flex-direction: column; gap: 10px; }
    .nav-group { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 10px; }
    .nav-item { 
      display: flex; align-items: center; gap: 12px; padding: 8px 12px; 
      font-size: 11.5px; color: #888; border-radius: 6px; cursor: pointer; transition: 0.2s;
    }
    .nav-item.active { background: rgba(46, 204, 113, 0.1); color: var(--accent); font-weight: 700; }
    .nav-item:hover:not(.active) { background: #252525; color: #fff; }

    /* Main Content Area */
    .main-scroll { flex: 1; overflow-y: auto; padding-right: 5px; }
    
    /* Sticky Info Column */
    .info-column { 
      width: 250px; flex-shrink: 0; 
      position: sticky; top: 0; height: fit-content;
      display: flex; flex-direction: column; gap: 12px;
    }

    /* Form & Stepper Styling */
    .step-card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; margin-bottom: 8px; overflow: hidden; }
    .step-header { padding: 10px 15px; display: flex; align-items: center; gap: 12px; cursor: pointer; }
    .step-num { width: 22px; height: 22px; border-radius: 50%; background: #262626; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; }
    .active .step-num { background: var(--accent); color: #000; }
    .done .step-num { background: var(--accent); color: #000; }
    
    .step-content { display: none; padding: 15px; border-top: 1px solid #262626; background: #141414; }
    .active .step-content { display: block; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .field label { display: block; font-size: 9px; color: #666; text-transform: uppercase; font-weight: 800; margin-bottom: 3px; }
    .field input, .field select { width: 100%; padding: 6px 10px; background: #000; border: 1px solid var(--border); color: #fff; border-radius: 4px; font-size: 12px; box-sizing: border-box; }
    
    /* Status Cards */
    .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 15px; }
    .progress-bar { height: 4px; background: #222; border-radius: 2px; margin-top: 10px; overflow: hidden; }
    .progress-fill { height: 100%; background: var(--accent); transition: width 0.5s ease; }

    .btn-primary { background: var(--accent); color: #000; border: none; padding: 10px; border-radius: 5px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 10px; }
  </style>
</head>
<body class="dark">
  <div class="app">
    <div class="top-header" style="height: 50px; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; border-bottom: 1px solid #222;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 18px;">ASENXO</span>
        <span style="font-size: 9px; padding: 2px 6px; background: #1a3324; color: var(--accent); border-radius: 4px; font-weight: 800;">PRODUCTION</span>
      </div>
      <div style="display: flex; gap: 10px;">
        <button id="themeToggle" style="background: #222; border: 1px solid #333; color: #fff; padding: 5px 10px; border-radius: 4px; cursor: pointer;"><i class="fas fa-moon"></i></button>
        <button onclick="logout()" style="background: #e74c3c; border: none; color: #fff; padding: 5px 15px; border-radius: 4px; font-weight: 700; cursor: pointer;">Logout</button>
      </div>
    </div>

    <div class="content-row">
      <div class="sidebar">
        <div class="nav-group" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 35px; height: 35px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000;"><i class="fas fa-user"></i></div>
          <div style="overflow: hidden;">
            <div id="sidebarUserName" style="font-weight: 700; font-size: 12px; white-space: nowrap; text-overflow: ellipsis;">Loading...</div>
            <div style="font-size: 9px; color: #555;">MSME OWNER</div>
          </div>
        </div>
        <div class="nav-group">
          <div style="font-size: 9px; color: #444; font-weight: 800; margin-bottom: 8px;">WORKSPACE</div>
          <div class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</div>
          <div class="nav-item"><i class="fas fa-folder"></i> Applications</div>
          <div class="nav-item"><i class="fas fa-wallet"></i> My Wallet</div>
          <div class="nav-item"><i class="fas fa-cog"></i> Settings</div>
        </div>
      </div>

      <div class="main-scroll" id="stepContainer">
        </div>

      <div class="info-column">
        <div class="stat-card">
          <div style="font-size: 9px; font-weight: 800; color: #555;">COMPLETION PROGRESS</div>
          <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 5px;">
            <span id="progressPercent" style="font-size: 24px; font-weight: 900;">0%</span>
            <span style="font-size: 10px; color: var(--accent);">STABLE</span>
          </div>
          <div class="progress-bar"><div class="progress-fill" id="progressBar" style="width: 0%;"></div></div>
        </div>

        <div class="stat-card">
          <div style="font-size: 9px; font-weight: 800; color: #555;">SYSTEM STATUS</div>
          <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 5px;">
            <div style="display: flex; justify-content: space-between; font-size: 10px;"><span style="color: #666;">Engine:</span><span style="color: var(--accent); font-weight: 700;">ONLINE</span></div>
            <div style="display: flex; justify-content: space-between; font-size: 10px;"><span style="color: #666;">Database:</span><span style="color: var(--accent); font-weight: 700;">CONNECTED</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
  <script>
    const S_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
    const S_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw';

    let supabaseClient; // Renamed to avoid syntax errors
    let user = null;
    let profile = null;
    let currentStep = 3;

    const stepData = [
      { id: 1, title: "Account Initialized", desc: "Type Selection" },
      { id: 2, title: "Security Check", desc: "Identity Verified" },
      { id: 3, title: "Owner Profile", desc: "Detailed Information" },
      { id: 4, title: "ID Verification", desc: "Official Documentation" },
      { id: 5, title: "Business Info", desc: "Enterprise Details" },
      { id: 6, title: "Final Review", desc: "Submission" }
    ];

    async function init() {
      try {
        supabaseClient = supabase.createClient(S_URL, S_KEY, {
          global: { headers: { 'apikey': S_KEY, 'Authorization': `Bearer ${S_KEY}` } }
        });

        const { data: { user: authUser } } = await supabaseClient.auth.getUser();
        if (!authUser) { window.location.href = 'login.php'; return; }
        user = authUser;

        const { data: p } = await supabaseClient.from('user_profiles').select('*').eq('id', user.id).single();
        if (p) {
          profile = p;
          document.getElementById('sidebarUserName').innerText = p.first_name + ' ' + p.last_name;
          currentStep = p.current_step || 3;
          renderUI();
        }
      } catch (err) { console.error("Init Error:", err); }
    }

    function renderUI() {
      const p = Math.round((currentStep / stepData.length) * 100);
      document.getElementById('progressBar').style.width = p + '%';
      document.getElementById('progressPercent').innerText = p + '%';

      document.getElementById('stepContainer').innerHTML = stepData.map(s => `
        <div class="step-card ${s.id === currentStep ? 'active' : ''} ${s.id < currentStep ? 'done' : ''}">
          <div class="step-header">
            <div class="step-num">${s.id < currentStep ? '<i class="fas fa-check"></i>' : s.id}</div>
            <div>
              <div style="font-size: 12px; font-weight: 800; color: ${s.id <= currentStep ? '#fff' : '#444'}">${s.title}</div>
              <div style="font-size: 9px; color: #666;">${s.desc}</div>
            </div>
          </div>
          <div class="step-content">${getForm(s.id)}</div>
        </div>
      `).join('');
    }

    function getForm(id) {
      if (id === 3) return `
        <div class="form-grid">
          <div class="field"><label>Nickname</label><input id="o_nick" placeholder="Nickname"></div>
          <div class="field"><label>Birth Date</label><input type="date" id="o_dob"></div>
          <div class="field"><label>Place of Birth</label><input id="o_pob"></div>
          <div class="field"><label>Nationality</label><input id="o_nat" value="Filipino"></div>
          <div class="field"><label>Sex</label><select id="o_sex"><option>Male</option><option>Female</option></select></div>
          <div class="field"><label>Marital Status</label><input id="o_mar"></div>
          <div class="field" style="grid-column: span 2;"><label>Full Address</label><input id="o_adr"></div>
          <div class="field"><label>Enterprise</label><input id="o_ent"></div>
          <div class="field"><label>Designation</label><input id="o_des"></div>
        </div>
        <button class="btn-primary" onclick="saveProfile()">Save & Continue</button>`;
      return `<p style="font-size: 10px; color: #444;">Please complete previous steps.</p>`;
    }

    async function saveProfile() {
      const data = {
        owner_ID: user.id,
        owner_name: profile.first_name + ' ' + profile.last_name,
        owner_nickname: document.getElementById('o_nick').value,
        owner_dob: document.getElementById('o_dob').value,
        owner_pob: document.getElementById('o_pob').value,
        owner_nationality: document.getElementById('o_nat').value,
        owner_sex: document.getElementById('o_sex').value,
        owner_marstat: document.getElementById('o_mar').value,
        owner_address: document.getElementById('o_adr').value,
        owner_email: user.email,
        enterprise_name: document.getElementById('o_ent').value,
        enterprise_designation: document.getElementById('o_des').value
      };

      const { error } = await supabaseClient.from('owner_profile').upsert([data]);
      if (error) {
        alert("Policy Error: Please check if RLS for 'INSERT' and 'UPDATE' is enabled for Authenticated users on table 'owner_profile'.");
      } else {
        currentStep++;
        await supabaseClient.from('user_profiles').update({ current_step: currentStep }).eq('id', user.id);
        renderUI();
      }
    }

    document.getElementById('themeToggle').addEventListener('click', () => {
      document.body.classList.toggle('light-mode');
      const icon = document.querySelector('#themeToggle i');
      icon.className = document.body.classList.contains('light-mode') ? 'fas fa-sun' : 'fas fa-moon';
    });

    function logout() { supabaseClient.auth.signOut().then(() => window.location.href = 'login.php'); }
    window.onload = init;
  </script>
</body>
</html>