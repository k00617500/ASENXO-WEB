<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASENXO | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root { --accent: #2ecc71; --bg: #000; --card: #111; --border: #222; }

        /* FIX: Single scrollbar on the right only */
        html, body { margin: 0; padding: 0; height: 100%; background: var(--bg); color: #fff; overflow-x: hidden; }
        
        .app-layout { display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER: Sticky at top */
        .top-nav { height: 60px; background: #000; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; position: sticky; top: 0; z-index: 1000; }

        .main-row { display: flex; flex: 1; align-items: stretch; }

        /* SIDEBAR: Flush to left/top (no space) */
        .sidebar { width: 240px; background: #000; border-right: 1px solid var(--border); position: sticky; top: 60px; height: calc(100vh - 60px); }

        /* CONTENT: Standard flow (no internal scroll) */
        .content-body { flex: 1; padding: 40px; }

        /* RIGHT PANEL: Sticky stats */
        .stats-panel { width: 300px; padding: 40px 20px; position: sticky; top: 60px; height: fit-content; }

        /* UI Cards */
        .nav-link { padding: 12px 25px; color: #666; display: flex; align-items: center; gap: 15px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .nav-link.active { color: var(--accent); background: rgba(46, 204, 113, 0.05); border-left: 3px solid var(--accent); }

        .card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 25px; margin-bottom: 20px; }
        .progress-container { height: 8px; background: #222; border-radius: 4px; margin-top: 15px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--accent); width: 0%; transition: 0.6s ease; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .field label { display: block; font-size: 10px; color: #555; text-transform: uppercase; font-weight: 800; margin-bottom: 5px; }
        .field input { width: 100%; padding: 12px; background: #000; border: 1px solid var(--border); color: #fff; border-radius: 6px; box-sizing: border-box; }
        
        .save-btn { width: 100%; background: var(--accent); color: #000; border: none; padding: 15px; border-radius: 6px; font-weight: 800; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="app-layout">
        <header class="top-nav">
            <div style="font-weight:900; font-size:20px;">ASENXO <span style="color:var(--accent); font-size:10px;">PRO</span></div>
            <button onclick="logOut()" style="background:#e74c3c; border:none; color:#fff; padding:6px 15px; border-radius:4px; font-weight:700; cursor:pointer;">Logout</button>
        </header>

        <div class="main-row">
            <aside class="sidebar">
                <div style="padding: 25px; border-bottom: 1px solid var(--border); margin-bottom: 10px;">
                    <div id="displayName" style="font-weight:700; font-size:15px;">Loading...</div>
                </div>
                <div class="nav-link active"><i class="fas fa-th-large"></i> Dashboard</div>
                <div class="nav-link"><i class="fas fa-folder"></i> Applications</div>
                <div class="nav-link"><i class="fas fa-cog"></i> Settings</div>
            </aside>

            <main class="content-body">
                <div id="step-container"></div>
            </main>

            <aside class="stats-panel">
                <div class="card">
                    <div style="font-size:11px; font-weight:800; color:#555;">OVERALL PROGRESS</div>
                    <div id="percValue" style="font-size:32px; font-weight:900; margin-top:10px;">0%</div>
                    <div class="progress-container"><div id="percBar" class="progress-bar"></div></div>
                </div>
            </aside>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script>
        const SB_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
        const SB_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw';
        
        let client;
        let currentUser;
        let currentStep = 3;

        async function initApp() {
            client = supabase.createClient(SB_URL, SB_KEY);
            const { data: { user } } = await client.auth.getUser();
            if(!user) return window.location.href='login.php';
            currentUser = user;

            const { data: p } = await client.from('user_profiles').select('*').eq('id', user.id).single();
            if(p) {
                document.getElementById('displayName').innerText = p.first_name + ' ' + p.last_name;
                currentStep = p.current_step || 3;
                refreshUI();
            }
        }

        function refreshUI() {
            const p = Math.round((currentStep / 6) * 100);
            document.getElementById('percBar').style.width = p + '%';
            document.getElementById('percValue').innerText = p + '%';

            const stepData = [
                { id: 1, title: "Account Active", done: true },
                { id: 2, title: "Security Verified", done: true },
                { id: 3, title: "Owner Information", active: true }
            ];

            document.getElementById('step-container').innerHTML = stepData.map(s => `
                <div class="card" style="opacity: ${s.id > currentStep ? '0.5' : '1'}">
                    <div style="display:flex; align-items:center; gap:15px; margin-bottom: ${s.id === currentStep ? '20px' : '0'}">
                        <div style="width:30px; height:30px; border-radius:50%; background:${s.id <= currentStep ? 'var(--accent)' : '#222'}; color:#000; display:flex; align-items:center; justify-content:center; font-weight:900;">
                            ${s.id < currentStep ? '✓' : s.id}
                        </div>
                        <div style="font-weight:700;">${s.title}</div>
                    </div>
                    ${s.id === currentStep ? renderForm() : ''}
                </div>
            `).join('');
        }

        function renderForm() {
            return `
                <div class="form-grid">
                    <div class="field" style="grid-column: span 2;"><label>Full Legal Name</label><input id="f_name" placeholder="Required for database"></div>
                    <div class="field"><label>Nickname</label><input id="f_nick"></div>
                    <div class="field"><label>Birth Date</label><input type="date" id="f_dob"></div>
                    <div class="field"><label>Enterprise</label><input id="f_ent"></div>
                </div>
                <button class="save-btn" onclick="saveData()">Save & Continue</button>
            `;
        }

        async function saveData() {
            // FIX: Including 'owner_name' to prevent the 400 error
            const payload = {
                "owner_ID": currentUser.id,
                "owner_name": document.getElementById('f_name').value, 
                "owner_nickname": document.getElementById('f_nick').value,
                "owner_dob": document.getElementById('f_dob').value || null,
                "enterprise_name": document.getElementById('f_ent').value
            };

            const { error } = await client.from('owner_profile').upsert([payload]);

            if (error) {
                console.error(error);
                alert("Database Error: " + error.message);
            } else {
                currentStep++;
                await client.from('user_profiles').update({ current_step: currentStep }).eq('id', currentUser.id);
                refreshUI();
            }
        }

        function logOut() { client.auth.signOut().then(() => window.location.href='login.php'); }
        window.onload = initApp;
    </script>
</body>
</html>