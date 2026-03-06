<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASENXO · BENEFICIARY MAP</title>
  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="https://img.icons8.com/color/48/000000/marker.png">
  <!-- Google Font & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Leaflet + providers -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="../src/css/psto-map-style.css">
</head>
<body class="dark">
<div class="app">
  <!-- header -->
  <header class="top-header">
    <div class="top-header-left">
      <span class="project-name"> Map View | ASENXO</span>
      <span class="badge">PROVINCIAL</span>
      <div class="search"><i class="fas fa-search"></i><input type="text" id="globalFilter" placeholder="Filter beneficiaries..."></div>
    </div>
    <div class="top-header-right">
      <div class="live-indicator">
        <i class="fas fa-circle"></i> LIVE · 30s
      </div>
      <button class="btn-export" id="exportBtn"><i class="fas fa-download"></i> Export</button>
      <button class="theme-toggle" id="themeToggle"><i class="fas fa-sun"></i> Light</button>
    </div>
  </header>

  <div class="content-row">
    <!-- left sidebar - FIXED WIDTH -->
    <aside class="sidebar">
      <div class="sidebar-header">MENU</div>
      <ul class="sidebar-menu">
        <li><a href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <li><a href="#"><i class="fas fa-user-check"></i><span>Beneficiary</span></a></li>
        <li class="active"><a href="#"><i class="fas fa-map-marked-alt"></i><span>Map View</span></a></li>
        <li><a href="#"><i class="fas fa-clipboard-list"></i><span>TNA Tool</span></a></li>
        <li><a href="#"><i class="fas fa-history"></i><span>Revisions</span></a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="map-layers-container">

        <!-- MAP PANEL -->
        <div class="map-panel">
          <div class="map-header">
            <span><i class="fas fa-map"></i> <span id="currentLayer">OpenStreetMap</span></span>
            <span style="display:flex; gap:12px;">
              <i class="fas fa-globe" id="switchLayerBtn" style="cursor:pointer;" title="Switch layer"></i>
              <span id="gpsIndicator"><i class="fas fa-satellite-dish"></i> tracking</span>
            </span>
          </div>
          <div id="map"></div>
        </div>

        <!-- RIGHT ANALYSIS PANEL -->
        <div class="layers-panel">
          <!-- QUICK STATS -->
          <div class="stats-mini">
            <div class="stat-mini-item">
              <span class="stat-mini-label">Beneficiaries</span>
              <span class="stat-mini-value" id="totalBeneficiaries">10</span>
            </div>
            <div class="stat-mini-divider"></div>
            <div class="stat-mini-item">
              <span class="stat-mini-label">Employees</span>
              <span class="stat-mini-value" id="totalEmployees">251</span>
            </div>
          </div>

          <!-- BENEFICIARY SEARCH -->
          <div class="search-enterprise">
            <i class="fas fa-search"></i>
            <input type="text" id="benefSearch" placeholder="Search beneficiary...">
          </div>

          <!-- BENEFICIARY LIST -->
          <div class="enterprise-list" id="benefList">
            <!-- dynamic -->
          </div>

          <!-- BENEFICIARY DETAILS -->
          <div class="company-brief" id="companyBrief">
            <div class="brief-row">
              <span>Enterprise</span>
              <span class="brief-value" id="briefName">Select a beneficiary</span>
            </div>
            <div class="brief-row">
              <span>Employees</span>
              <span id="briefEmp">-</span>
            </div>
            <div class="brief-row">
              <span>Municipality</span>
              <span id="briefMunicipality">-</span>
            </div>
            <div class="brief-row last-updated">
              <span>Last Updated</span>
              <span id="lastUpdatedTime">just now</span>
            </div>
          </div>

          <!-- PROXIMITY ANALYSIS -->
          <div class="buffer-info">
            <div class="buffer-title">
              <i class="fas fa-draw-polygon"></i>
              Nearby Competitors (7.5km)
            </div>
            <div class="competitor-tags" id="competitorList">
              <span class="competitor-tag">Select enterprise</span>
            </div>
          </div>

          <!-- NEAREST POI -->
          <div>
            <div class="poi-header">
              <span><i class="fas fa-map-pin"></i> Nearest Points of Interest</span>
            </div>
            <div class="poi-scroll" id="poiList">
              <!-- dynamic -->
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Notification container -->
<div id="notificationContainer"></div>

<script>
  // JavaScript remains exactly the same as in the original working version
  // (keeping all the functionality)
  (function() {
    // ========== DATA STORES ==========
    let beneficiaries = [];
    let poiMaster = [];
    let benefMarkers = [];
    let updateInterval = null;
    let lastUpdateTime = new Date();
    
    // ========== MAP INIT ==========
    const map = L.map('map').setView([10.7, 122.55], 12);
    
    // Layer switching
    const layers = [
      { name: 'OpenStreetMap', url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', attr: '© OpenStreetMap' },
      { name: 'CartoDB Voyager', url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', attr: '© CartoDB' },
      { name: 'Satellite', url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', attr: '© ESRI' }
    ];
    
    let layerIndex = 0;
    let tileLayer = L.tileLayer(layers[0].url, {attribution: layers[0].attr}).addTo(map);
    document.getElementById('currentLayer').innerText = layers[0].name;
    
    document.getElementById('switchLayerBtn').addEventListener('click', ()=>{
      layerIndex = (layerIndex+1)%layers.length;
      map.removeLayer(tileLayer);
      tileLayer = L.tileLayer(layers[layerIndex].url, {attribution: layers[layerIndex].attr}).addTo(map);
      document.getElementById('currentLayer').innerText = layers[layerIndex].name;
    });

    // ========== GPS INDICATOR ==========
    const gpsSpan = document.getElementById('gpsIndicator');
    if (navigator.geolocation) {
      navigator.geolocation.watchPosition(
        () => { gpsSpan.innerHTML = '<i class="fas fa-satellite-dish"></i> live'; },
        () => { gpsSpan.innerHTML = '<i class="fas fa-exclamation-triangle"></i> unavailable'; }
      );
    } else { 
      gpsSpan.innerHTML = '<i class="fas fa-ban"></i> no GPS'; 
    }

    // ========== LOAD DATA ==========
    async function loadData() {
      try {
        // Simulate CSV data load - in production, replace with fetch to your CSV endpoint
        beneficiaries = [
          { 
            id: 'BEN-001',
            name: 'Han Jim Marketing Corporation', 
            location: 'Villa',
            lat: 10.68763192, 
            lng: 122.5135522, 
            employees: 12,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-002',
            name: '4JNG Food Services', 
            location: 'Sta. Cruz',
            lat: 10.68874355, 
            lng: 122.5554969, 
            employees: 8,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-003',
            name: 'RMSS Garments Maker', 
            location: 'San Jose',
            lat: 10.68757492, 
            lng: 122.44374, 
            employees: 25,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-004',
            name: 'SJL Corporation', 
            location: 'City proper',
            lat: 10.6920791, 
            lng: 122.5510329, 
            employees: 15,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-005',
            name: 'Balay Sang Amo Food Products', 
            location: 'Oton',
            lat: 10.70677626, 
            lng: 122.5699115, 
            employees: 20,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-006',
            name: 'Maravilla Enterprises Inc.', 
            location: 'Jaro',
            lat: 10.73957095, 
            lng: 122.5708666, 
            employees: 45,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-007',
            name: 'JLP Multi Ventures, Inc.', 
            location: 'Jaro',
            lat: 10.72864646, 
            lng: 122.5563029, 
            employees: 30,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-008',
            name: 'Belverim Foods Corporation', 
            location: 'Mandurriao',
            lat: 10.77907702, 
            lng: 122.5364158, 
            employees: 50,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-009',
            name: 'Orchard Valley, Inc.', 
            location: 'Mandurriao',
            lat: 10.77400823, 
            lng: 122.5493236, 
            employees: 40,
            status: 'active',
            lastUpdated: new Date().toISOString()
          },
          { 
            id: 'BEN-010',
            name: 'Think About Cakes Bakery', 
            location: 'Passi',
            lat: 11.25698579, 
            lng: 123.0150381, 
            employees: 6,
            status: 'active',
            lastUpdated: new Date().toISOString()
          }
        ];

        // POI Data
        poiMaster = [
          // Villa area
          { id: 'POI001', type: 'major_road', name: 'Osmeña St. (Villa Arevalo)', lat: 10.68987523, lng: 122.5134389 },
          { id: 'POI002', type: 'public_market', name: 'Arevalo Public Market', lat: 10.68715531, lng: 122.5162441 },
          { id: 'POI003', type: 'supermarket', name: 'Arevalo Supermarket', lat: 10.68692241, lng: 122.5160331 },
          { id: 'POI004', type: 'public_plaza', name: 'Plaza Villa', lat: 10.68812231, lng: 122.5161445 },
          { id: 'POI005', type: 'school', name: 'Villa Elementary', lat: 10.68963511, lng: 122.51702278 },
          { id: 'POI006', type: 'malls', name: 'Villa Mall', lat: 10.68692241, lng: 122.5160331 },
          { id: 'POI007', type: 'hospital', name: 'Villa District Hospital', lat: 10.68884451, lng: 122.5222339 },
          
          // City Proper area
          { id: 'POI008', type: 'major_road', name: 'M.H. del Pilar St', lat: 10.68821102, lng: 122.5551339 },
          { id: 'POI009', type: 'public_market', name: 'Iloilo Central Market', lat: 10.69345521, lng: 122.5739884 },
          { id: 'POI010', type: 'supermarket', name: 'SM City Iloilo', lat: 10.69383321, lng: 122.5718442 },
          { id: 'POI011', type: 'public_plaza', name: 'Plaza Libertad', lat: 10.69251142, lng: 122.5711229 },
          { id: 'POI012', type: 'school', name: 'University of Iloilo', lat: 10.68953321, lng: 122.5562441 },
          { id: 'POI013', type: 'malls', name: 'SM City Iloilo', lat: 10.69442211, lng: 122.5721338 },
          { id: 'POI014', type: 'hospital', name: 'Iloilo Doctors', lat: 10.69553312, lng: 122.5732442 },
          
          // Jaro area
          { id: 'POI015', type: 'major_road', name: 'Jaro Road', lat: 10.69128831, lng: 122.4475221 },
          { id: 'POI016', type: 'public_market', name: 'Jaro Market', lat: 10.69354412, lng: 122.4485331 },
          { id: 'POI017', type: 'supermarket', name: 'Jaro Supermarket', lat: 10.69482211, lng: 122.4482335 },
          { id: 'POI018', type: 'hospital', name: 'Jaro District Hospital', lat: 10.68752241, lng: 122.4835441 },
          
          // Additional POI
          { id: 'POI019', type: 'public_plaza', name: 'Plaza Libertad', lat: 10.6925, lng: 122.5711 },
          { id: 'POI020', type: 'school', name: 'University of Iloilo', lat: 10.6895, lng: 122.5562 }
        ];

        // Update UI
        updateBeneficiaryList();
        renderMapMarkers();
        updateTotalStats();
        
        // Select first beneficiary by default
        if (beneficiaries.length > 0) {
          setTimeout(() => {
            const firstItem = document.querySelector('.ent-item');
            if (firstItem) {
              firstItem.classList.add('active');
              updatePanelByBeneficiary(0);
            }
          }, 100);
        }
        
        // Setup real-time updates
        setupRealtimeUpdates();
        
      } catch (error) {
        console.error('Error loading data:', error);
        showNotification('Error loading beneficiary data', 'error');
      }
    }

    // ========== SETUP REAL-TIME UPDATES ==========
    function setupRealtimeUpdates() {
      // Clear existing interval
      if (updateInterval) clearInterval(updateInterval);
      
      // Update every 30 seconds
      updateInterval = setInterval(() => {
        simulateRealtimeUpdate();
      }, 30000);
    }

    function simulateRealtimeUpdate() {
      // Randomly update a beneficiary to simulate real-time changes
      if (beneficiaries.length > 0) {
        const randomIndex = Math.floor(Math.random() * beneficiaries.length);
        
        // Only update employees
        const empChange = Math.floor(Math.random() * 3) - 1; // -1, 0, or 1
        
        if (empChange !== 0) {
          beneficiaries[randomIndex].employees = Math.max(1, beneficiaries[randomIndex].employees + empChange);
          beneficiaries[randomIndex].lastUpdated = new Date().toISOString();
          
          // Show notification
          showNotification(
            `${beneficiaries[randomIndex].name}: employees ${empChange > 0 ? '+' : ''}${empChange}`,
            'info'
          );
          
          // Update UI if this beneficiary is selected
          const activeItem = document.querySelector('.ent-item.active');
          if (activeItem) {
            const index = Array.from(document.querySelectorAll('.ent-item')).indexOf(activeItem);
            if (index === randomIndex) {
              updatePanelByBeneficiary(index);
            }
          }
          
          // Update marker popup
          if (benefMarkers[randomIndex]) {
            benefMarkers[randomIndex].setPopupContent(`
              <b>${beneficiaries[randomIndex].name}</b><br>
              Employees: ${beneficiaries[randomIndex].employees}<br>
              <small>Updated: ${new Date().toLocaleTimeString()}</small>
            `);
          }
          
          // Update total stats
          updateTotalStats();
          lastUpdateTime = new Date();
        }
      }
    }

    function showNotification(message, type = 'info') {
      const container = document.getElementById('notificationContainer');
      const notification = document.createElement('div');
      notification.className = `realtime-notification ${type}`;
      
      let icon = 'sync-alt';
      if (type === 'error') icon = 'exclamation-circle';
      if (type === 'success') icon = 'check-circle';
      
      notification.innerHTML = `
        <i class="fas fa-${icon} fa-${type === 'info' ? 'spin' : ''}"></i>
        <span>${message}</span>
      `;
      
      container.appendChild(notification);
      
      setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
    }

    // ========== UPDATE BENEFICIARY LIST ==========
    function updateBeneficiaryList() {
      const listContainer = document.getElementById('benefList');
      listContainer.innerHTML = '';
      
      beneficiaries.forEach((b, index) => {
        const item = document.createElement('div');
        item.className = 'ent-item';
        item.dataset.id = `benef${index}`;
        item.dataset.benefId = b.id;
        item.innerHTML = `
          <span>${b.name}</span>
          <span class="small-note">${b.location}</span>
        `;
        item.addEventListener('click', function() {
          document.querySelectorAll('.ent-item').forEach(i => i.classList.remove('active'));
          this.classList.add('active');
          updatePanelByBeneficiary(index);
        });
        listContainer.appendChild(item);
      });
    }

    // ========== RENDER MAP MARKERS ==========
    function renderMapMarkers() {
      // Clear existing markers
      benefMarkers.forEach(marker => map.removeLayer(marker));
      benefMarkers = [];
      
      // Add new markers
      beneficiaries.forEach((b, idx) => {
        const marker = L.circleMarker([b.lat, b.lng], {
          radius: 8,
          fillColor: '#2ecc71',
          color: '#fff',
          weight: 1.5,
          fillOpacity: 0.9
        }).addTo(map).bindPopup(`
          <b>${b.name}</b><br>
          Employees: ${b.employees}<br>
          <small>Last updated: ${new Date(b.lastUpdated).toLocaleTimeString()}</small>
        `);
        benefMarkers.push(marker);
      });
    }

    // ========== UPDATE TOTAL STATISTICS ==========
    function updateTotalStats() {
      const totalBeneficiaries = beneficiaries.length;
      const totalEmployees = beneficiaries.reduce((sum, b) => sum + b.employees, 0);
      
      document.getElementById('totalBeneficiaries').textContent = totalBeneficiaries;
      document.getElementById('totalEmployees').textContent = totalEmployees;
    }

    // ========== DISTANCE CALCULATION ==========
    function distance(lat1, lng1, lat2, lng2) {
      const R = 6371;
      const dLat = (lat2-lat1)*Math.PI/180;
      const dLng = (lng2-lng1)*Math.PI/180;
      const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLng/2)**2;
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    // ========== UPDATE PANEL BY BENEFICIARY ==========
    function updatePanelByBeneficiary(index) {
      const b = beneficiaries[index];
      
      // Update company brief
      document.getElementById('briefName').innerText = b.name;
      document.getElementById('briefEmp').innerText = b.employees;
      document.getElementById('briefMunicipality').innerText = b.location;
      document.getElementById('lastUpdatedTime').innerHTML = `<small>${new Date(b.lastUpdated).toLocaleTimeString()}</small>`;

      // Find competitors within 2.5km
      const competitors = beneficiaries
        .filter((other, i) => i !== index)
        .map(other => ({
          name: other.name.split(' ').slice(0, 2).join(' '),
          dist: distance(b.lat, b.lng, other.lat, other.lng),
          employees: other.employees
        }))
        .filter(c => c.dist <= 2.5)
        .sort((a, b) => a.dist - b.dist);

      const compContainer = document.getElementById('competitorList');
      if (competitors.length) {
        compContainer.innerHTML = competitors.map(c => 
          `<span class="competitor-tag" title="${c.employees} employees">${c.name} (${c.dist.toFixed(2)}km)</span>`
        ).join(' ');
      } else {
        compContainer.innerHTML = '<span class="competitor-tag">No competitors within 2.5km</span>';
      }

      // Find nearest POI
      const poiWithDist = poiMaster
        .map(p => ({
          ...p,
          distKm: distance(b.lat, b.lng, p.lat, p.lng)
        }))
        .sort((a, b) => a.distKm - b.distKm)
        .slice(0, 5);

      const poiListDiv = document.getElementById('poiList');
      poiListDiv.innerHTML = poiWithDist.map(p => {
        let icon = 'map-pin';
        if (p.type.includes('road')) icon = 'road';
        else if (p.type.includes('market')) icon = 'store';
        else if (p.type.includes('super')) icon = 'shopping-cart';
        else if (p.type.includes('plaza')) icon = 'tree';
        else if (p.type.includes('school')) icon = 'school';
        else if (p.type.includes('hospital')) icon = 'hospital';
        else if (p.type.includes('mall')) icon = 'building';
        
        return `<div class="poi-item">
          <i class="fas fa-${icon}"></i> 
          ${p.name} (${p.distKm.toFixed(2)} km)
        </div>`;
      }).join('');

      // Update map view and highlight marker
      map.setView([b.lat, b.lng], 14);
      
      benefMarkers.forEach((marker, i) => {
        if (i === index) {
          marker.setStyle({ radius: 10, fillColor: '#f39c12' });
        } else {
          marker.setStyle({ radius: 8, fillColor: '#2ecc71' });
        }
      });
    }

    // ========== SEARCH FILTER ==========
    document.getElementById('benefSearch').addEventListener('input', function(e) {
      const val = e.target.value.toLowerCase();
      document.querySelectorAll('.ent-item').forEach(item => {
        const name = item.innerText.toLowerCase();
        item.style.display = name.includes(val) ? 'flex' : 'none';
      });
    });

    // ========== GLOBAL FILTER ==========
    document.getElementById('globalFilter').addEventListener('input', function(e) {
      const val = e.target.value.toLowerCase();
      document.querySelectorAll('.ent-item').forEach(item => {
        const name = item.innerText.toLowerCase();
        item.style.display = name.includes(val) ? 'flex' : 'none';
      });
    });

    // ========== THEME TOGGLE ==========
    document.getElementById('themeToggle').addEventListener('click', function() {
      document.body.classList.toggle('dark');
      this.innerHTML = document.body.classList.contains('dark') ? 
        '<i class="fas fa-sun"></i> Light' : 
        '<i class="fas fa-moon"></i> Dark';
    });

    // ========== EXPORT FUNCTION ==========
    document.getElementById('exportBtn').addEventListener('click', () => {
      const data = {
        beneficiaries: beneficiaries.map(b => ({
          name: b.name,
          location: b.location,
          employees: b.employees,
          lastUpdated: b.lastUpdated
        })),
        summary: {
          totalBeneficiaries: beneficiaries.length,
          totalEmployees: beneficiaries.reduce((sum, b) => sum + b.employees, 0)
        },
        exportDate: new Date().toISOString()
      };
      
      const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `beneficiary-export-${new Date().toISOString().split('T')[0]}.json`;
      a.click();
      URL.revokeObjectURL(url);
      
      showNotification('Export completed successfully', 'success');
    });

    // ========== INITIALIZE ==========
    loadData();

    // Handle resize
    window.addEventListener('resize', () => map.invalidateSize());
  })();
</script>
</body>
</html>