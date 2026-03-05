<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASENXO | MSME Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="src/css/msme-home-style.css">
  <style>
    :root { --accent: #2ecc71; --card: #1a1a1a; }
    
    /* ULTRA-COMPACT LAYOUT */
    .user-profile-box { padding: 4px 10px; border-bottom: 1px solid #333; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
    .user-avatar { width: 24px; height: 24px; background: var(--accent); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; }
    .user-name-sidebar { font-weight: 600; font-size: 10px; color: white; }

    /* THE SQUEEZE: Minimal padding between content and borders */
    .step-list { list-style: none; padding: 0; margin: 0; }
    .step-item { background: var(--card); border: 1px solid #333; border-radius: 4px; margin-bottom: 3px; overflow: hidden; }
    
    /* Reduced header padding from 15px to 4px */
    .step-header { padding: 4px 10px; display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .step-icon { width: 18px; height: 18px; border-radius: 50%; background: #262626; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 8px; color: #555; }
    
    .step-item.active { border-color: var(--accent); background: #1c1c1c; }
    .step-item.active .step-icon { background: var(--accent); color: white; }
    .step-item.completed .step-icon { background: var(--accent); color: white; }
    
    .step-title { font-weight: 600; font-size: 10.5px; line-height: 1; }
    .step-desc { font-size: 8.5px; color: #666; display: block; margin-top: 1px; }

    /* CONTENT SQUEEZE: Minimal space inside the expanded item */
    .step-content { display: none; padding: 4px 10px 8px 38px; border-top: 1px solid #262626; }
    .step-item.active .step-content { display: block; }

    /* HIGH DENSITY FORM */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; }
    .input-group { margin-bottom: 2px; }
    .input-group label { display: block; font-size: 7.5px; color: #777; margin-bottom: 0px; text-transform: uppercase; font-weight: 800; }
    .input-group input, .input-group select { width: 100%; padding: 3px 6px; background: #000; border: 1px solid #333; color: white; border-radius: 2px; font-size: 10px; }
    .input-group input:disabled { opacity: 0.4; border-style: dashed; }
    
    .primary-btn { background: var(--accent); color: white; border: none; padding: 5px; border-radius: 3px; cursor: pointer; width: 100%; font-weight: 700; margin-top: 4px; font-size: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; }
    .spinner { animation: rotate 1s linear infinite; display: none; font-size: 9px; }
    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
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
      <button id="logoutBtn" style="background:#ef4444; color:white; border:none; padding:2px 6px; border-radius:4px; font-size:9px; cursor:pointer;">Logout</button>
    </div>
  </div>

  <div class="content-row">
    <div class="sidebar">
      <div class="user-profile-box">
        <div class="user-avatar"><i class="fas fa-user"></i></div>
        <div class="user-info-text"><span id="sidebarUserName" class="user-name-sidebar">...</span></div>
      </div>
      <ul class="sidebar-menu"><li class="active"><a><i class="fas fa-home"></i> Dashboard</a></li></ul>
    </div>

    <div class="main-content">
      <div class="progress-column">
        <ul class="step-list" id="middleStepList"></ul>
      </div>

      <div class="info-column">
        <div class="card" style="padding:8px; background:var(--card); border:1px solid #333; border-radius:6px;">
          <div style="font-size:8px; color:#777; font-weight:800; text-transform:uppercase;">Progression</div>
          <div id="progressPercent" style="font-size:11px; font-weight:700;">0%</div>
          <div class="progress-bar-bg" style="height:3px; background:#262626; margin-top:3px;"><div class="progress-bar-fill" id="progressBar" style="width:0%; height:100%; background:var(--accent);"></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
  // --- CONFIG ---
  const S_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
  const S_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw'; // <--- Ensure no spaces here!

  let supabase;
  let user = null;
  let profile = null;
  let currentStep = 2;

  const stepDetails = [
    { id: 1, title: "Account Type", desc: "Selection complete" },
    { id: 2, title: "Security", desc: "Email verification" },
    { id: 3, title: "Owner Profile", desc: "Detailed personal data" },
    { id: 4, title: "Identity", desc: "Official photo upload" },
    { id: 5, title: "Business Info", desc: "Tax & Registration" },
    { id: 6, title: "Final Permits", desc: "Required documentation" }
  ];

  async function init() {
    try {
      // FORCED INITIALIZATION: Specifically adding the apikey to the global headers
      supabase = supabase.createClient(S_URL, S_KEY, {
        global: {
          headers: { 'apikey': S_KEY, 'Authorization': `Bearer ${S_KEY}` }
        }
      });

      const { data: { user: authUser }, error: authError } = await supabase.auth.getUser();
      if (authError || !authUser) { window.location.href = 'login.php'; return; }
      user = authUser;

      const { data: p } = await supabase.from('user_profiles').select('*').eq('id', user.id).single();
      if (p) {
        profile = p;
        document.getElementById('sidebarUserName').innerText = p.first_name + ' ' + p.last_name;
        currentStep = p.current_step || 2;
        render();
      }
    } catch (e) { console.error("Init Error:", e); }
  }

  function render() {
    const p = Math.round((currentStep / stepDetails.length) * 100);
    document.getElementById('progressBar').style.width = p + '%';
    document.getElementById('progressPercent').innerText = p + '%';
    
    document.getElementById('middleStepList').innerHTML = stepDetails.map(s => {
      const active = s.id === currentStep;
      const done = s.id < currentStep;
      return `
        <li class="step-item ${active ? 'active' : ''} ${done ? 'completed' : ''}">
          <div class="step-header">
            <div class="step-icon">${done ? '<i class="fas fa-check"></i>' : s.id}</div>
            <div>
              <div class="step-title" style="color:${done ? 'var(--accent)' : 'white'}">${s.title}</div>
              <span class="step-desc">${s.desc}</span>
            </div>
          </div>
          <div class="step-content">${getFormHtml(s.id)}</div>
        </li>`;
    }).join('');
  }

  function getFormHtml(id) {
    if (id === 2) return `<button class="primary-btn" onclick="next()">Continue</button>`;
    if (id === 3 && profile) {
      return `
      <div class="form-grid">
        <div class="input-group"><label>Owner ID</label><input type="text" value="${user.id}" disabled></div>
        <div class="input-group"><label>Full Name</label><input type="text" value="${profile.first_name} ${profile.last_name}" disabled></div>
        <div class="input-group"><label>Nickname</label><input type="text" id="nick"></div>
        <div class="input-group"><label>DOB</label><input type="date" id="dob"></div>
        <div class="input-group"><label>POB</label><input type="text" id="pob"></div>
        <div class="input-group"><label>Nationality</label><input type="text" id="nat"></div>
        <div class="input-group"><label>Sex</label><select id="sex"><option>Male</option><option>Female</option></select></div>
        <div class="input-group"><label>Status</label><input type="text" id="mar"></div>
        <div class="input-group"><label>Spouse</label><input type="text" id="spo"></div>
        <div class="input-group"><label>Contact</label><input type="text" id="pho"></div>
        <div class="input-group" style="grid-column: span 2;"><label>Address</label><input type="text" id="adr"></div>
        <div class="input-group"><label>Email</label><input type="text" value="${user.email}" disabled></div>
        <div class="input-group"><label>Enterprise</label><input type="text" id="ent"></div>
        <div class="input-group"><label>Designation</label><input type="text" id="des"></div>
        <div class="input-group"><label>Affiliations</label><input type="text" id="aff"></div>
        <div class="input-group"><label>Education</label><input type="text" id="edu"></div>
      </div>
      <button class="primary-btn" id="sBtn" onclick="save()">
        <i class="fas fa-circle-notch spinner" id="spn"></i> <span>Save Profile</span>
      </button>`;
    }
    return `<p style="font-size:8px; color:#444;">Locked.</p>`;
  }

  async function save() {
    const btn = document.getElementById('sBtn');
    const spn = document.getElementById('spn');
    btn.disabled = true; spn.style.display = 'inline-block';

    const d = {
      owner_ID: user.id,
      owner_name: profile.first_name + ' ' + profile.last_name,
      owner_nickname: document.getElementById('nick').value,
      owner_dob: document.getElementById('dob').value,
      owner_pob: document.getElementById('pob').value,
      owner_nationality: document.getElementById('nat').value,
      owner_sex: document.getElementById('sex').value,
      owner_marstat: document.getElementById('mar').value,
      owner_spouse: document.getElementById('spo').value,
      owner_contactnum: document.getElementById('pho').value,
      owner_address: document.getElementById('adr').value,
      owner_email: user.email,
      enterprise_name: document.getElementById('ent').value,
      enterprise_designation: document.getElementById('des').value,
      owner_affiliations: document.getElementById('aff').value,
      owner_hea: document.getElementById('edu').value
    };

    const { error } = await supabase.from('owner_profile').upsert([d]);
    if (!error) next();
    else { alert(error.message); btn.disabled = false; spn.style.display = 'none'; }
  }

  async function next() {
    currentStep++;
    await supabase.from('user_profiles').update({ current_step: currentStep }).eq('id', user.id);
    render();
  }

  window.onload = init;
</script>
</body>
</html>