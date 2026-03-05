<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ASENXO | MSME Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root { --accent: #2ecc71; --bg: #0d0d0d; --card: #1a1a1a; }
    body { background: var(--bg); color: white; font-family: 'Inter', sans-serif; margin: 0; padding: 10px; }
    
    /* ULTRA SQUEEZE UI */
    .step-list { list-style: none; padding: 0; max-width: 500px; margin: 0 auto; }
    .step-item { background: var(--card); border: 1px solid #333; border-radius: 4px; margin-bottom: 2px; }
    .step-header { padding: 4px 8px; display: flex; align-items: center; gap: 8px; cursor: pointer; }
    .step-title { font-weight: 700; font-size: 10px; margin: 0; }
    .step-desc { font-size: 8px; color: #666; display: block; }
    .step-icon { width: 16px; height: 16px; border-radius: 50%; background: #222; display: flex; align-items: center; justify-content: center; font-size: 8px; }
    
    .step-item.active { border-color: var(--accent); }
    .step-content { display: none; padding: 6px 10px 10px 32px; border-top: 1px solid #222; }
    .step-item.active .step-content { display: block; }

    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; }
    label { font-size: 7px; color: #888; text-transform: uppercase; display: block; }
    input { width: 100%; padding: 3px 6px; background: #000; border: 1px solid #333; color: white; font-size: 10px; border-radius: 2px; }
    
    .btn { background: var(--accent); border: none; padding: 5px; color: white; width: 100%; font-weight: 700; font-size: 10px; margin-top: 5px; cursor: pointer; border-radius: 2px; }
    #debug-log { background: #000; color: #0f0; font-family: monospace; font-size: 9px; padding: 10px; margin-top: 20px; border: 1px dashed #333; border-radius: 4px; }
  </style>
</head>
<body>

<div id="middleStepList" class="step-list">
  <div style="text-align: center; padding: 20px; font-size: 10px; color: #666;">
    <i class="fas fa-circle-notch fa-spin"></i> Initializing System...
  </div>
</div>

<div id="debug-log">
  <div>[SYSTEM] Waiting for initialization...</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
  // 1. SETTINGS
  const SB_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
  const SB_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw'; 

  const logBox = document.getElementById('debug-log');
  function log(msg) {
    console.log(msg);
    logBox.innerHTML += `<div>> ${msg}</div>`;
  }

  let supabaseClient;
  let currentUser = null;
  let currentStep = 3;

  async function boot() {
    log("Starting boot process...");
    
    try {
      log("Initializing Supabase Client...");
      // Forcing the apikey into the headers manually
      supabaseClient = supabase.createClient(SB_URL, SB_KEY, {
        global: { headers: { 'apikey': SB_KEY, 'Authorization': `Bearer ${SB_KEY}` } }
      });
      log("Client initialized.");

      log("Fetching User...");
      const { data: { user }, error: authError } = await supabaseClient.auth.getUser();
      
      if (authError) {
        log("AUTH ERROR: " + authError.message);
        return;
      }

      if (!user) {
        log("No user found. Redirecting to login...");
        window.location.href = 'login.php';
        return;
      }

      log("User connected: " + user.email);
      currentUser = user;

      log("Fetching profile for ID: " + user.id);
      const { data: profile, error: profError } = await supabaseClient
        .from('user_profiles')
        .select('*')
        .eq('id', user.id)
        .single();

      if (profError) log("PROFILE ERROR: " + profError.message);
      
      currentStep = profile?.current_step || 3;
      log("Current Step: " + currentStep);

      renderUI(profile);
      log("UI Rendered.");

    } catch (err) {
      log("CRITICAL JS ERROR: " + err.message);
    }
  }

  function renderUI(profile) {
    const steps = [
      { id: 1, t: "Account Selection", d: "Done" },
      { id: 2, t: "Security Check", d: "Verified" },
      { id: 3, t: "Owner Profile", d: "Detailed Data" }
    ];

    document.getElementById('middleStepList').innerHTML = steps.map(s => `
      <div class="step-item ${s.id === currentStep ? 'active' : ''}">
        <div class="step-header">
          <div class="step-icon">${s.id < currentStep ? '✓' : s.id}</div>
          <div>
            <div class="step-title">${s.t}</div>
            <span class="step-desc">${s.d}</span>
          </div>
        </div>
        <div class="step-content">
          <div class="grid">
            <div><label>Owner ID</label><input value="${currentUser.id}" disabled></div>
            <div><label>Full Name</label><input value="${profile?.first_name || ''} ${profile?.last_name || ''}" disabled></div>
            <div><label>Nickname</label><input type="text" id="o_nick"></div>
            <div><label>Phone</label><input type="text" id="o_phone"></div>
          </div>
          <button class="btn" onclick="save()">Save & Continue</button>
        </div>
      </div>
    `).join('');
  }

  async function save() {
    log("Attempting to save...");
    const data = {
      owner_ID: currentUser.id,
      owner_nickname: document.getElementById('o_nick').value,
      owner_contactnum: document.getElementById('o_phone').value
    };
    
    const { error } = await supabaseClient.from('owner_profile').upsert(data);
    if (!error) {
      log("Save successful!");
      currentStep++;
      boot();
    } else {
      log("SAVE ERROR: " + error.message);
      alert(error.message);
    }
  }

  window.onload = boot;
</script>
</body>
</html>