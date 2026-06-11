<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Admin Dashboard — NFC</title>
   <link rel="icon" type="image" href="../favicon.png">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
   <link href="../css/bootstrap.min.css" rel="stylesheet"/>
   <link rel="stylesheet" href="../css/all.min.css"/>
   <style>
      :root{--primary:#e8281a;--secondary:#f6a623;--dark:#1a1a1a;--cream:#fff8f0;--light:#f9f5f0;--sidebar-w:260px;}
      *{margin:0;padding:0;box-sizing:border-box;}
      body{font-family:"Poppins",sans-serif;background:var(--light);display:flex;min-height:100vh;}

      /* ====== SIDEBAR ====== */
      .sidebar{width:var(--sidebar-w);background:linear-gradient(180deg,#1a1a1a 0%,#2a0a08 100%);position:fixed;top:0;left:0;height:100vh;overflow-y:auto;z-index:200;transition:.3s;}
      .sb-brand{padding:24px 20px 20px;border-bottom:1px solid rgba(255,255,255,.08);}
      .sb-brand img{width:38px;margin-bottom:8px;}
      .sb-brand h4{font-family:"Playfair Display",serif;font-size:1.1rem;font-weight:900;color:#fff;margin-bottom:2px;}
      .sb-brand h4 span{color:var(--secondary);}
      .sb-brand small{color:rgba(255,255,255,.4);font-size:.72rem;letter-spacing:1px;text-transform:uppercase;}
      .sb-section{padding:16px 12px 6px;color:rgba(255,255,255,.3);font-size:.68rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;}
      .sb-link{display:flex;align-items:center;gap:12px;padding:11px 20px;color:rgba(255,255,255,.6);text-decoration:none;font-size:.84rem;font-weight:500;border-radius:0;transition:.2s;position:relative;cursor:pointer;}
      .sb-link:hover,.sb-link.active{color:#fff;background:rgba(255,255,255,.08);}
      .sb-link.active::before{content:"";position:absolute;left:0;top:20%;height:60%;width:3px;background:var(--secondary);border-radius:0 3px 3px 0;}
      .sb-link i{width:18px;text-align:center;font-size:.9rem;}
      .sb-badge{margin-left:auto;background:var(--primary);color:#fff;font-size:.62rem;font-weight:700;border-radius:50px;padding:2px 7px;}
      .sb-divider{border:none;border-top:1px solid rgba(255,255,255,.08);margin:10px 0;}
      .sb-logout{display:flex;align-items:center;gap:12px;padding:12px 20px;color:rgba(255,100,90,.7);text-decoration:none;font-size:.84rem;font-weight:600;cursor:pointer;transition:.2s;}
      .sb-logout:hover{color:#ff6b6b;background:rgba(232,40,26,.1);}

      /* ====== TOPBAR ====== */
      .topbar{position:fixed;top:0;left:var(--sidebar-w);right:0;height:64px;background:#fff;box-shadow:0 2px 20px rgba(0,0,0,.06);display:flex;align-items:center;justify-content:space-between;padding:0 28px;z-index:100;}
      .topbar-title{font-family:"Playfair Display",serif;font-size:1.2rem;font-weight:900;color:var(--dark);}
      .topbar-right{display:flex;align-items:center;gap:14px;}
      .admin-avatar{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#c01e12);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;font-weight:700;}
      .admin-info{font-size:.82rem;}
      .admin-info .name{font-weight:700;color:var(--dark);}
      .admin-info .role{color:#aaa;font-size:.74rem;}

      /* ====== CONTENT ====== */
      .content{margin-left:var(--sidebar-w);padding-top:64px;flex:1;min-height:100vh;}
      .page{display:none;padding:28px;}
      .page.active{display:block;}
      .page-header{margin-bottom:24px;}
      .page-header h2{font-family:"Playfair Display",serif;font-size:1.7rem;font-weight:900;color:var(--dark);margin-bottom:4px;}
      .page-header p{color:#aaa;font-size:.85rem;}

      /* STAT CARDS */
      .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:28px;}
      .stat-card{background:#fff;border-radius:14px;padding:20px 22px;box-shadow:0 4px 18px rgba(0,0,0,.06);display:flex;align-items:center;gap:14px;}
      .stat-icon{width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;flex-shrink:0;}
      .si-red{background:linear-gradient(135deg,var(--primary),#c01e12);}
      .si-orange{background:linear-gradient(135deg,var(--secondary),#e0900d);}
      .si-green{background:linear-gradient(135deg,#2d6a4f,#1a4a35);}
      .si-blue{background:linear-gradient(135deg,#3b82f6,#1d4ed8);}
      .si-purple{background:linear-gradient(135deg,#8b5cf6,#6d28d9);}
      .stat-info .num{font-family:"Playfair Display",serif;font-size:1.6rem;font-weight:900;color:var(--dark);line-height:1;}
      .stat-info .lbl{font-size:.72rem;color:#aaa;text-transform:uppercase;letter-spacing:.8px;margin-top:3px;}

      /* CARDS */
      .card{background:#fff;border-radius:14px;box-shadow:0 4px 18px rgba(0,0,0,.06);overflow:hidden;margin-bottom:24px;}
      .card-header{padding:18px 22px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;}
      .card-header h5{font-family:"Playfair Display",serif;font-size:1rem;font-weight:800;color:var(--dark);margin:0;}
      .card-body{padding:22px;}

      /* TABLES */
      .tbl{width:100%;border-collapse:collapse;}
      .tbl thead tr{background:var(--light);}
      .tbl th{padding:11px 16px;text-align:left;font-size:.72rem;font-weight:700;color:#999;text-transform:uppercase;letter-spacing:.8px;}
      .tbl td{padding:13px 16px;border-bottom:1px solid #f5f5f5;font-size:.84rem;color:#555;vertical-align:middle;}
      .tbl tr:last-child td{border-bottom:none;}

      /* BADGES */
      .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:50px;font-size:.72rem;font-weight:700;}
      .b-pending{background:rgba(246,166,35,.12);color:#c68b00;}
      .b-preparing{background:rgba(59,130,246,.12);color:#1d4ed8;}
      .b-ready{background:rgba(45,106,79,.12);color:#2d6a4f;}
      .b-completed{background:rgba(107,114,128,.12);color:#4b5563;}
      .b-cancelled{background:rgba(232,40,26,.1);color:var(--primary);}
      .b-admin{background:rgba(139,92,246,.12);color:#6d28d9;}
      .b-staff{background:rgba(59,130,246,.12);color:#1d4ed8;}

      /* FORMS */
      .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
      .form-group{margin-bottom:16px;}
      .form-group label{font-size:.8rem;font-weight:600;color:#555;margin-bottom:6px;display:block;}
      .form-control{width:100%;padding:10px 14px;border:1.5px solid #e8e8e8;border-radius:9px;font-family:"Poppins",sans-serif;font-size:.85rem;color:var(--dark);outline:none;transition:.2s;background:#fafafa;}
      .form-control:focus{border-color:var(--primary);background:#fff;box-shadow:0 0 0 3px rgba(232,40,26,.07);}
      select.form-control{cursor:pointer;}

      /* BUTTONS */
      .btn{border:none;border-radius:8px;padding:9px 20px;font-size:.82rem;font-weight:600;cursor:pointer;font-family:"Poppins",sans-serif;transition:.2s;display:inline-flex;align-items:center;gap:7px;}
      .btn-primary{background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;}
      .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(232,40,26,.35);}
      .btn-secondary{background:var(--light);color:#666;}
      .btn-secondary:hover{background:#eee;}
      .btn-danger{background:rgba(232,40,26,.1);color:var(--primary);}
      .btn-danger:hover{background:rgba(232,40,26,.18);}
      .btn-success{background:rgba(45,106,79,.1);color:#2d6a4f;}
      .btn-success:hover{background:rgba(45,106,79,.18);}
      .btn-sm{padding:6px 14px;font-size:.76rem;}

      /* MODAL */
      .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:999;align-items:center;justify-content:center;}
      .modal-overlay.open{display:flex;}
      .modal-box{background:#fff;border-radius:18px;padding:28px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto;animation:modalIn .25s ease;}
      @keyframes modalIn{from{transform:scale(.95);opacity:0}to{transform:scale(1);opacity:1}}
      .modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;}
      .modal-header h4{font-family:"Playfair Display",serif;font-size:1.2rem;font-weight:900;color:var(--dark);}
      .modal-close{background:none;border:none;font-size:1.1rem;color:#aaa;cursor:pointer;padding:4px;}
      .modal-close:hover{color:var(--primary);}

      /* SYSTEM INFO */
      .info-row{display:flex;align-items:flex-start;gap:12px;padding:14px 0;border-bottom:1px solid #f0f0f0;}
      .info-row:last-child{border-bottom:none;}
      .info-key{font-size:.78rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.6px;width:160px;flex-shrink:0;padding-top:2px;}
      .info-val{font-size:.86rem;color:var(--dark);flex:1;}
      .info-edit{background:none;border:none;color:#bbb;cursor:pointer;font-size:.82rem;transition:.2s;padding:0 4px;}
      .info-edit:hover{color:var(--primary);}

      /* TOAST */
      .toast{position:fixed;bottom:28px;right:28px;background:var(--dark);color:#fff;padding:14px 20px;border-radius:12px;font-size:.84rem;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;}
      .toast.show{transform:translateY(0);opacity:1;}
      .toast.success{background:linear-gradient(135deg,#2d6a4f,#1a4a35);}
      .toast.error{background:linear-gradient(135deg,var(--primary),#c01e12);}

      /* CHART placeholder */
      .chart-bar{display:flex;align-items:flex-end;gap:8px;height:120px;padding:10px 0;}
      .c-bar{flex:1;border-radius:6px 6px 0 0;background:linear-gradient(to top,var(--primary),var(--secondary));min-height:8px;transition:.6s;cursor:default;position:relative;}
      .c-bar:hover::after{content:attr(data-val);position:absolute;top:-22px;left:50%;transform:translateX(-50%);background:var(--dark);color:#fff;font-size:.68rem;padding:2px 6px;border-radius:4px;white-space:nowrap;}
      .chart-labels{display:flex;gap:8px;padding-top:6px;}
      .chart-labels span{flex:1;text-align:center;font-size:.68rem;color:#bbb;}

      @media(max-width:768px){
         .sidebar{transform:translateX(-100%);}
         .sidebar.open{transform:translateX(0);}
         .content,.topbar{margin-left:0;left:0;}
         .form-row{grid-template-columns:1fr;}
      }
   </style>
</head>
<body>

   <!-- SIDEBAR -->
   <div class="sidebar" id="sidebar">
      <div class="sb-brand">
         <img src="../img/logo.png" alt="NFC">
         <h4>Nandawgs <span>FC</span></h4>
         <small>Admin Panel</small>
      </div>
      <!-- Dashboard -->
      <div class="sb-section">Main</div>
      <a class="sb-link active" onclick="showPage('dashboard',this)"><i class="fas fa-tachometer-alt"></i>Dashboard</a>

      <!-- Accounts -->
      <div class="sb-section">Accounts</div>
      <a class="sb-link" onclick="showPage('customers',this)"><i class="fas fa-users"></i>Customer Accounts</a>
      <a class="sb-link" onclick="showPage('staff',this)"><i class="fas fa-user-tie"></i>Staff Accounts</a>

      <!-- Menu -->
      <div class="sb-section">Menu</div>
      <a class="sb-link" onclick="showPage('categories',this)"><i class="fas fa-tags"></i>Menu Categories</a>
      <a class="sb-link" onclick="showPage('menuitems',this)"><i class="fas fa-burger"></i>Menu Items</a>

      <!-- Orders -->
      <div class="sb-section">Orders</div>
      <a class="sb-link" onclick="showPage('orders',this)"><i class="fas fa-receipt"></i>All Orders <span class="sb-badge" id="sbOrderCount">0</span></a>
      <a class="sb-link" onclick="showPage('orderrecords',this)"><i class="fas fa-history"></i>Order Records</a>

      <!-- System -->
      <div class="sb-section">System</div>
      <a class="sb-link" onclick="showPage('sysinfo',this)"><i class="fas fa-cog"></i>System Info</a>

      <hr class="sb-divider">
      <a class="sb-logout" onclick="doLogout()"><i class="fas fa-sign-out-alt"></i>Logout</a>
   </div>

   <!-- TOPBAR -->
   <div class="topbar">
      <div style="display:flex;align-items:center;gap:12px;">
         <button onclick="document.getElementById('sidebar').classList.toggle('open')" style="background:none;border:none;font-size:1.1rem;cursor:pointer;color:#666;display:none;" id="menuToggle"><i class="fas fa-bars"></i></button>
         <span class="topbar-title" id="topbarTitle">Dashboard</span>
      </div>
      <div class="topbar-right">
         <div class="admin-avatar" id="adminAvatar">A</div>
         <div class="admin-info">
            <div class="name" id="adminName">Admin</div>
            <div class="role">Administrator</div>
         </div>
      </div>
   </div>

   <!-- CONTENT -->
   <div class="content">

      <!-- ===== DASHBOARD ===== -->
      <div class="page active" id="page-dashboard">
         <div class="page-header">
            <h2>Dashboard</h2>
            <p>Welcome back! Here's what's happening at NFC today.</p>
         </div>
         <div class="stats-grid">
            <div class="stat-card"><div class="stat-icon si-red"><i class="fas fa-receipt"></i></div><div class="stat-info"><div class="num" id="dTotalOrders">0</div><div class="lbl">Total Orders</div></div></div>
            <div class="stat-card"><div class="stat-icon si-orange"><i class="fas fa-clock"></i></div><div class="stat-info"><div class="num" id="dPending">0</div><div class="lbl">Pending</div></div></div>
            <div class="stat-card"><div class="stat-icon si-green"><i class="fas fa-dollar-sign"></i></div><div class="stat-info"><div class="num" id="dRevenue">RM0</div><div class="lbl">Revenue Today</div></div></div>
            <div class="stat-card"><div class="stat-icon si-blue"><i class="fas fa-users"></i></div><div class="stat-info"><div class="num" id="dCustomers">0</div><div class="lbl">Customers</div></div></div>
            <div class="stat-card"><div class="stat-icon si-purple"><i class="fas fa-burger"></i></div><div class="stat-info"><div class="num" id="dMenuItems">15</div><div class="lbl">Menu Items</div></div></div>
         </div>
         <div class="card">
            <div class="card-header"><h5><i class="fas fa-chart-bar me-2" style="color:var(--primary)"></i>Orders This Week</h5></div>
            <div class="card-body">
               <div class="chart-bar" id="chartBars"></div>
               <div class="chart-labels" id="chartLabels"></div>
            </div>
         </div>
         <div class="card">
            <div class="card-header"><h5><i class="fas fa-list me-2" style="color:var(--primary)"></i>Recent Orders</h5><button class="btn btn-secondary btn-sm" onclick="showPage('orders',null)">View All</button></div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Time</th></tr></thead>
               <tbody id="recentOrders"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== CUSTOMERS ===== -->
      <div class="page" id="page-customers">
         <div class="page-header"><h2>Customer Accounts</h2><p>Manage registered customer accounts</p></div>
         <div class="card">
            <div class="card-header">
               <h5><i class="fas fa-users me-2" style="color:var(--primary)"></i>All Customers</h5>
               <button class="btn btn-primary btn-sm" onclick="openModal('modalAddCustomer')"><i class="fas fa-plus"></i>Add Customer</button>
            </div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Registered</th><th>Orders</th><th>Action</th></tr></thead>
               <tbody id="customersBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== STAFF ===== -->
      <div class="page" id="page-staff">
         <div class="page-header"><h2>Staff Accounts</h2><p>Manage restaurant staff and admin accounts</p></div>
         <div class="card">
            <div class="card-header">
               <h5><i class="fas fa-user-tie me-2" style="color:var(--primary)"></i>All Staff</h5>
               <button class="btn btn-primary btn-sm" onclick="openModal('modalAddStaff')"><i class="fas fa-plus"></i>Add Staff</button>
            </div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>#</th><th>Username</th><th>Full Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
               <tbody id="staffBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== CATEGORIES ===== -->
      <div class="page" id="page-categories">
         <div class="page-header"><h2>Menu Categories</h2><p>Manage the categories for menu items</p></div>
         <div class="card">
            <div class="card-header">
               <h5><i class="fas fa-tags me-2" style="color:var(--primary)"></i>Categories</h5>
               <button class="btn btn-primary btn-sm" onclick="openModal('modalAddCat')"><i class="fas fa-plus"></i>Add Category</button>
            </div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>#</th><th>Category Name</th><th>Items Count</th><th>Action</th></tr></thead>
               <tbody id="categoriesBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== MENU ITEMS ===== -->
      <div class="page" id="page-menuitems">
         <div class="page-header"><h2>Menu Items</h2><p>Add, edit or remove items from the menu</p></div>
         <div class="card">
            <div class="card-header">
               <h5><i class="fas fa-burger me-2" style="color:var(--primary)"></i>All Menu Items</h5>
               <button class="btn btn-primary btn-sm" onclick="openModal('modalAddItem')"><i class="fas fa-plus"></i>Add Item</button>
            </div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>#</th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Action</th></tr></thead>
               <tbody id="menuItemsBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== ALL ORDERS ===== -->
      <div class="page" id="page-orders">
         <div class="page-header"><h2>All Orders</h2><p>View and monitor all customer orders</p></div>
         <div class="card">
            <div class="card-header">
               <h5><i class="fas fa-receipt me-2" style="color:var(--primary)"></i>Orders</h5>
               <div style="display:flex;gap:8px;">
                  <select class="form-control" id="orderFilter" onchange="renderOrders()" style="width:auto;padding:6px 12px;font-size:.8rem;">
                     <option value="all">All Status</option>
                     <option value="pending">Pending</option>
                     <option value="preparing">Preparing</option>
                     <option value="ready">Ready</option>
                     <option value="completed">Completed</option>
                     <option value="cancelled">Cancelled</option>
                  </select>
               </div>
            </div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>Order ID</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th><th>Date/Time</th><th>Action</th></tr></thead>
               <tbody id="ordersBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== ORDER RECORDS ===== -->
      <div class="page" id="page-orderrecords">
         <div class="page-header"><h2>Order Records</h2><p>Completed and cancelled order history</p></div>
         <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card"><div class="stat-icon si-green"><i class="fas fa-check-double"></i></div><div class="stat-info"><div class="num" id="recCompleted">0</div><div class="lbl">Completed</div></div></div>
            <div class="stat-card"><div class="stat-icon si-red"><i class="fas fa-times-circle"></i></div><div class="stat-info"><div class="num" id="recCancelled">0</div><div class="lbl">Cancelled</div></div></div>
            <div class="stat-card"><div class="stat-icon si-purple"><i class="fas fa-coins"></i></div><div class="stat-info"><div class="num" id="recRevenue">RM0</div><div class="lbl">Total Revenue</div></div></div>
         </div>
         <div class="card">
            <div class="card-header"><h5><i class="fas fa-history me-2" style="color:var(--primary)"></i>Completed & Cancelled Orders</h5></div>
            <div class="card-body" style="padding:0;">
               <table class="tbl"><thead><tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date/Time</th></tr></thead>
               <tbody id="recordsBody"></tbody></table>
            </div>
         </div>
      </div>

      <!-- ===== SYSTEM INFO ===== -->
      <div class="page" id="page-sysinfo">
         <div class="page-header"><h2>System Information</h2><p>View and edit restaurant system settings</p></div>
         <div class="card">
            <div class="card-header"><h5><i class="fas fa-cog me-2" style="color:var(--primary)"></i>Restaurant Settings</h5></div>
            <div class="card-body" id="sysInfoBody"></div>
         </div>
      </div>

   </div><!-- end content -->

   <!-- ===== MODALS ===== -->

   <!-- Add Customer -->
   <div class="modal-overlay" id="modalAddCustomer">
      <div class="modal-box">
         <div class="modal-header"><h4>Add Customer</h4><button class="modal-close" onclick="closeModal('modalAddCustomer')"><i class="fas fa-times"></i></button></div>
         <div class="form-row">
            <div class="form-group"><label>Full Name</label><input type="text" class="form-control" id="newCustName" placeholder="e.g. Ahmad Razif"></div>
            <div class="form-group"><label>Email</label><input type="email" class="form-control" id="newCustEmail" placeholder="customer@email.com"></div>
         </div>
         <div class="form-row">
            <div class="form-group"><label>Phone</label><input type="text" class="form-control" id="newCustPhone" placeholder="+60 12 345 6789"></div>
            <div class="form-group"><label>Password</label><input type="password" class="form-control" id="newCustPass" placeholder="Min. 8 characters"></div>
         </div>
         <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
            <button class="btn btn-secondary" onclick="closeModal('modalAddCustomer')">Cancel</button>
            <button class="btn btn-primary" onclick="addCustomer()"><i class="fas fa-save"></i>Save</button>
         </div>
      </div>
   </div>

   <!-- Add Staff -->
   <div class="modal-overlay" id="modalAddStaff">
      <div class="modal-box">
         <div class="modal-header"><h4>Add Staff Account</h4><button class="modal-close" onclick="closeModal('modalAddStaff')"><i class="fas fa-times"></i></button></div>
         <div class="form-row">
            <div class="form-group"><label>Username</label><input type="text" class="form-control" id="newStaffUser" placeholder="e.g. staff02"></div>
            <div class="form-group"><label>Full Name</label><input type="text" class="form-control" id="newStaffName" placeholder="e.g. Siti Aisyah"></div>
         </div>
         <div class="form-row">
            <div class="form-group"><label>Email</label><input type="email" class="form-control" id="newStaffEmail" placeholder="staff@nfc.com"></div>
            <div class="form-group"><label>Password</label><input type="password" class="form-control" id="newStaffPass" placeholder="Password"></div>
         </div>
         <div class="form-group"><label>Role</label>
            <select class="form-control" id="newStaffRole">
               <option value="staff">Staff</option>
               <option value="admin">Admin</option>
            </select>
         </div>
         <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
            <button class="btn btn-secondary" onclick="closeModal('modalAddStaff')">Cancel</button>
            <button class="btn btn-primary" onclick="addStaff()"><i class="fas fa-save"></i>Save</button>
         </div>
      </div>
   </div>

   <!-- Add Category -->
   <div class="modal-overlay" id="modalAddCat">
      <div class="modal-box">
         <div class="modal-header"><h4>Add Menu Category</h4><button class="modal-close" onclick="closeModal('modalAddCat')"><i class="fas fa-times"></i></button></div>
         <div class="form-group"><label>Category Name</label><input type="text" class="form-control" id="newCatName" placeholder="e.g. Desserts"></div>
         <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
            <button class="btn btn-secondary" onclick="closeModal('modalAddCat')">Cancel</button>
            <button class="btn btn-primary" onclick="addCategory()"><i class="fas fa-save"></i>Save</button>
         </div>
      </div>
   </div>

   <!-- Add Menu Item -->
   <div class="modal-overlay" id="modalAddItem">
      <div class="modal-box">
         <div class="modal-header"><h4>Add Menu Item</h4><button class="modal-close" onclick="closeModal('modalAddItem')"><i class="fas fa-times"></i></button></div>
         <div class="form-group"><label>Item Name</label><input type="text" class="form-control" id="newItemName" placeholder="e.g. Grilled Chicken"></div>
         <div class="form-row">
            <div class="form-group"><label>Price (RM)</label><input type="number" class="form-control" id="newItemPrice" placeholder="0.00" step="0.10" min="0"></div>
            <div class="form-group"><label>Category</label>
               <select class="form-control" id="newItemCat"></select>
            </div>
         </div>
         <div class="form-group"><label>Description</label><input type="text" class="form-control" id="newItemDesc" placeholder="Short description..."></div>
         <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
            <button class="btn btn-secondary" onclick="closeModal('modalAddItem')">Cancel</button>
            <button class="btn btn-primary" onclick="addMenuItem()"><i class="fas fa-save"></i>Save</button>
         </div>
      </div>
   </div>

   <!-- Edit System Info -->
   <div class="modal-overlay" id="modalEditInfo">
      <div class="modal-box">
         <div class="modal-header"><h4>Edit Setting</h4><button class="modal-close" onclick="closeModal('modalEditInfo')"><i class="fas fa-times"></i></button></div>
         <div class="form-group"><label id="editInfoLabel">Value</label><input type="text" class="form-control" id="editInfoVal"></div>
         <input type="hidden" id="editInfoKey">
         <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
            <button class="btn btn-secondary" onclick="closeModal('modalEditInfo')">Cancel</button>
            <button class="btn btn-primary" onclick="saveInfoEdit()"><i class="fas fa-save"></i>Save</button>
         </div>
      </div>
   </div>

   <!-- TOAST -->
   <div class="toast" id="toast"></div>

   <script>
   /* ===== AUTH ===== */
   var role = sessionStorage.getItem('nfc_role');
   var user = sessionStorage.getItem('nfc_user');
   if(!role || role!=='admin'){ window.location.href='../login.php'; }
   document.getElementById('adminName').textContent = user||'Admin';
   document.getElementById('adminAvatar').textContent = (user||'A')[0].toUpperCase();

   function doLogout(){
      sessionStorage.removeItem('nfc_role');
      sessionStorage.removeItem('nfc_user');
      window.location.href='../index.php';
   }

   /* ===== DATA (localStorage) ===== */
   var defCustomers=[
      {id:1,name:'Ahmad Razif',email:'ahmad@email.com',phone:'+601x-xxx',date:'2026-06-01',orders:3},
      {id:2,name:'Siti Aisyah',email:'siti@email.com',phone:'+601x-xxx',date:'2026-06-05',orders:1},
      {id:3,name:'Lim Wei Jian',email:'lim@email.com',phone:'+601x-xxx',date:'2026-06-10',orders:2},
   ];
   var defStaff=[
      {id:1,username:'admin',name:'Administrator',email:'admin@nfc.com',role:'admin'},
      {id:2,username:'staff',name:'Kitchen Staff',email:'staff@nfc.com',role:'staff'},
   ];
   var defCategories=['Burgers','Chicken','Wraps','Beverages'];
   var defMenuItems=[
      {id:1,name:'Classic Chicken Burger',cat:'Burgers',price:'8.90',available:true},
      {id:2,name:'Spicy Chicken Burger',cat:'Burgers',price:'9.90',available:true},
      {id:3,name:'Cheese Chicken Burger',cat:'Burgers',price:'10.90',available:true},
      {id:4,name:'BBQ Chicken Burger',cat:'Burgers',price:'11.90',available:true},
      {id:5,name:'2-pc Fried Chicken',cat:'Chicken',price:'12.90',available:true},
      {id:6,name:'3-pc Fried Chicken',cat:'Chicken',price:'16.90',available:true},
      {id:7,name:'Spicy Fried Chicken',cat:'Chicken',price:'13.90',available:true},
      {id:8,name:'Popcorn Chicken',cat:'Chicken',price:'8.90',available:true},
      {id:9,name:'Crispy Chicken Wrap',cat:'Wraps',price:'9.90',available:true},
      {id:10,name:'Spicy Chicken Wrap',cat:'Wraps',price:'10.90',available:true},
      {id:11,name:'Cheese Chicken Wrap',cat:'Wraps',price:'11.90',available:true},
      {id:12,name:'Coca-Cola',cat:'Beverages',price:'3.90',available:true},
      {id:13,name:'Sprite',cat:'Beverages',price:'3.90',available:true},
      {id:14,name:'Iced Lemon Tea',cat:'Beverages',price:'4.90',available:true},
      {id:15,name:'Mineral Water',cat:'Beverages',price:'2.50',available:true},
   ];
   var defOrders=[
      {id:'ORD-001',customer:'Ahmad Razif',items:'2x Classic Burger, 1x Coca-Cola',total:21.70,status:'pending',time:'10:32 AM'},
      {id:'ORD-002',customer:'Siti Aisyah',items:'1x 2-pc Fried Chicken, 1x Iced Lemon Tea',total:17.80,status:'preparing',time:'10:45 AM'},
      {id:'ORD-003',customer:'Lim Wei Jian',items:'3x Popcorn Chicken, 2x Sprite',total:34.50,status:'ready',time:'11:00 AM'},
      {id:'ORD-004',customer:'Ahmad Razif',items:'1x BBQ Burger, 1x Sprite',total:15.80,status:'completed',time:'09:15 AM'},
      {id:'ORD-005',customer:'Nurul Huda',items:'1x Cheese Wrap, 1x Mineral Water',total:14.40,status:'completed',time:'08:50 AM'},
   ];
   var defSysInfo={
      restaurant_name:'Nandawgs Fried Chicken',
      restaurant_address:'No. 12, Jalan Tuanku Abdul Halim, 50480 Kuala Lumpur',
      restaurant_phone:'+603-2612 3456',
      restaurant_email:'hello@nfc.com.my',
      restaurant_hours:'Wed-Thu: 9AM-10PM | Fri: 9AM-11PM | Sat: 10AM-11:30PM | Sun: 11AM-9PM',
      currency:'RM',
      footer_text:'© 2026 Nandawgs Fried Chicken. Distributed by Group 4(WP) / 5(DB)',
   };

   function getData(key,def){ try{var v=localStorage.getItem('nfc_admin_'+key);return v?JSON.parse(v):def;}catch(e){return def;}}
   function setData(key,val){ localStorage.setItem('nfc_admin_'+key,JSON.stringify(val)); }

   var customers = getData('customers',defCustomers);
   var staffList  = getData('staff',defStaff);
   var categories = getData('categories',defCategories);
   var menuItems  = getData('menuItems',defMenuItems);
   var orders     = getData('orders',defOrders);
   var sysInfo    = getData('sysinfo',defSysInfo);

   /* ===== TOAST ===== */
   function toast(msg,type){
      var t=document.getElementById('toast');
      t.textContent=msg; t.className='toast '+(type||'success');
      setTimeout(function(){t.classList.add('show');},10);
      setTimeout(function(){t.classList.remove('show');},2800);
   }

   /* ===== MODAL ===== */
   function openModal(id){document.getElementById(id).classList.add('open');}
   function closeModal(id){document.getElementById(id).classList.remove('open');}
   document.querySelectorAll('.modal-overlay').forEach(function(m){
      m.addEventListener('click',function(e){if(e.target===m)m.classList.remove('open');});
   });

   /* ===== PAGE NAV ===== */
   var pageTitles={dashboard:'Dashboard',customers:'Customer Accounts',staff:'Staff Accounts',categories:'Menu Categories',menuitems:'Menu Items',orders:'All Orders',orderrecords:'Order Records',sysinfo:'System Info'};
   function showPage(id,link){
      document.querySelectorAll('.page').forEach(function(p){p.classList.remove('active');});
      document.getElementById('page-'+id).classList.add('active');
      document.getElementById('topbarTitle').textContent = pageTitles[id]||id;
      if(link){ document.querySelectorAll('.sb-link').forEach(function(l){l.classList.remove('active');}); link.classList.add('active'); }
      var renders={dashboard:renderDashboard,customers:renderCustomers,staff:renderStaff,categories:renderCategories,menuitems:renderMenuItems,orders:renderOrders,orderrecords:renderRecords,sysinfo:renderSysInfo};
      if(renders[id]) renders[id]();
   }

   /* ===== STATUS BADGE ===== */
   function sBadge(s){
      var map={pending:'b-pending',preparing:'b-preparing',ready:'b-ready',completed:'b-completed',cancelled:'b-cancelled'};
      return '<span class="badge '+(map[s]||'b-pending')+'">'+s.charAt(0).toUpperCase()+s.slice(1)+'</span>';
   }

   /* ===== DASHBOARD ===== */
   function renderDashboard(){
      var days=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
      var vals=[3,5,4,7,9,12,6];
      var maxV=Math.max.apply(null,vals);
      document.getElementById('chartBars').innerHTML=vals.map(function(v,i){
         return '<div class="c-bar" style="height:'+(v/maxV*100)+'%" data-val="'+v+' orders"></div>';
      }).join('');
      document.getElementById('chartLabels').innerHTML=days.map(function(d){return '<span>'+d+'</span>';}).join('');
      var completed=orders.filter(function(o){return o.status==='completed';});
      var revenue=completed.reduce(function(s,o){return s+(parseFloat(o.total)||0);},0);
      document.getElementById('dTotalOrders').textContent=orders.length;
      document.getElementById('dPending').textContent=orders.filter(function(o){return o.status==='pending'||o.status==='preparing';}).length;
      document.getElementById('dRevenue').textContent='RM'+revenue.toFixed(0);
      document.getElementById('dCustomers').textContent=customers.length;
      document.getElementById('dMenuItems').textContent=menuItems.length;
      document.getElementById('sbOrderCount').textContent=orders.filter(function(o){return o.status==='pending';}).length;
      var recent=orders.slice().reverse().slice(0,5);
      document.getElementById('recentOrders').innerHTML=recent.map(function(o){
         return '<tr><td><strong>'+o.id+'</strong></td><td>'+o.customer+'</td><td><strong>RM'+parseFloat(o.total).toFixed(2)+'</strong></td><td>'+sBadge(o.status)+'</td><td>'+o.time+'</td></tr>';
      }).join('');
   }

   /* ===== CUSTOMERS ===== */
   function renderCustomers(){
      document.getElementById('customersBody').innerHTML=customers.map(function(c,i){
         return '<tr><td>'+(i+1)+'</td><td><strong>'+c.name+'</strong></td><td>'+c.email+'</td><td>'+(c.phone||'—')+'</td><td>'+c.date+'</td><td>'+c.orders+'</td><td><button class="btn btn-danger btn-sm" onclick="deleteItem(\'customers\','+i+')"><i class="fas fa-trash"></i></button></td></tr>';
      }).join('') || '<tr><td colspan="7" style="text-align:center;color:#bbb;padding:24px;">No customers yet</td></tr>';
   }
   function addCustomer(){
      var name=document.getElementById('newCustName').value.trim();
      var email=document.getElementById('newCustEmail').value.trim();
      var phone=document.getElementById('newCustPhone').value.trim();
      if(!name||!email){toast('Please fill required fields','error');return;}
      customers.push({id:Date.now(),name:name,email:email,phone:phone,date:new Date().toISOString().slice(0,10),orders:0});
      setData('customers',customers); closeModal('modalAddCustomer'); renderCustomers();
      document.getElementById('newCustName').value=''; document.getElementById('newCustEmail').value=''; document.getElementById('newCustPhone').value='';
      toast('Customer added!');
   }

   /* ===== STAFF ===== */
   function renderStaff(){
      document.getElementById('staffBody').innerHTML=staffList.map(function(s,i){
         return '<tr><td>'+(i+1)+'</td><td><strong>'+s.username+'</strong></td><td>'+s.name+'</td><td>'+s.email+'</td><td><span class="badge '+(s.role==='admin'?'b-admin':'b-staff')+'">'+s.role+'</span></td><td><button class="btn btn-danger btn-sm" onclick="deleteItem(\'staff\','+i+')" '+(s.username==='admin'?'disabled':'')+'>'+( s.username==='admin'?'<i class="fas fa-lock"></i>':'<i class="fas fa-trash"></i>')+'</button></td></tr>';
      }).join('');
   }
   function addStaff(){
      var user=document.getElementById('newStaffUser').value.trim();
      var name=document.getElementById('newStaffName').value.trim();
      var email=document.getElementById('newStaffEmail').value.trim();
      var role=document.getElementById('newStaffRole').value;
      if(!user||!name){toast('Please fill required fields','error');return;}
      staffList.push({id:Date.now(),username:user,name:name,email:email,role:role});
      setData('staff',staffList); closeModal('modalAddStaff'); renderStaff();
      document.getElementById('newStaffUser').value=''; document.getElementById('newStaffName').value=''; document.getElementById('newStaffEmail').value='';
      toast('Staff account added!');
   }

   /* ===== CATEGORIES ===== */
   function renderCategories(){
      document.getElementById('categoriesBody').innerHTML=categories.map(function(c,i){
         var count=menuItems.filter(function(m){return m.cat===c;}).length;
         return '<tr><td>'+(i+1)+'</td><td><strong>'+c+'</strong></td><td>'+count+'</td><td><button class="btn btn-danger btn-sm" onclick="deleteItem(\'categories\','+i+')" '+(count>0?'disabled title="Remove items first"':'')+'>'+( count>0?'<i class="fas fa-lock"></i>':'<i class="fas fa-trash"></i>')+'</button></td></tr>';
      }).join('');
      // populate category select in add item modal
      var sel=document.getElementById('newItemCat');
      sel.innerHTML=categories.map(function(c){return '<option>'+c+'</option>';}).join('');
   }
   function addCategory(){
      var name=document.getElementById('newCatName').value.trim();
      if(!name){toast('Enter category name','error');return;}
      if(categories.indexOf(name)>-1){toast('Category already exists','error');return;}
      categories.push(name);
      setData('categories',categories); closeModal('modalAddCat'); renderCategories();
      document.getElementById('newCatName').value=''; toast('Category added!');
   }

   /* ===== MENU ITEMS ===== */
   function renderMenuItems(){
      document.getElementById('menuItemsBody').innerHTML=menuItems.map(function(m,i){
         return '<tr><td>'+m.id+'</td><td><strong>'+m.name+'</strong></td><td>'+m.cat+'</td><td>RM'+parseFloat(m.price).toFixed(2)+'</td><td><span class="badge '+(m.available?'b-ready':'b-cancelled')+'">'+(m.available?'Available':'Unavailable')+'</span></td><td style="display:flex;gap:6px;"><button class="btn btn-secondary btn-sm" onclick="toggleItem('+i+')">'+(m.available?'Disable':'Enable')+'</button><button class="btn btn-danger btn-sm" onclick="deleteItem(\'menuItems\','+i+')"><i class="fas fa-trash"></i></button></td></tr>';
      }).join('');
   }
   function addMenuItem(){
      var name=document.getElementById('newItemName').value.trim();
      var price=document.getElementById('newItemPrice').value;
      var cat=document.getElementById('newItemCat').value;
      var desc=document.getElementById('newItemDesc').value.trim();
      if(!name||!price){toast('Please fill required fields','error');return;}
      menuItems.push({id:Date.now(),name:name,cat:cat,price:parseFloat(price).toFixed(2),desc:desc,available:true});
      setData('menuItems',menuItems); closeModal('modalAddItem'); renderMenuItems();
      document.getElementById('newItemName').value=''; document.getElementById('newItemPrice').value=''; document.getElementById('newItemDesc').value='';
      toast('Menu item added!');
   }
   function toggleItem(i){
      menuItems[i].available=!menuItems[i].available;
      setData('menuItems',menuItems); renderMenuItems(); toast('Item updated!');
   }

   /* ===== ORDERS ===== */
   function renderOrders(){
      var filter=document.getElementById('orderFilter').value;
      var filtered=filter==='all'?orders:orders.filter(function(o){return o.status===filter;});
      document.getElementById('ordersBody').innerHTML=filtered.map(function(o,i){
         var realIdx=orders.indexOf(o);
         var actions='';
         if(o.status==='pending') actions='<button class="btn btn-success btn-sm" onclick="changeOrderStatus('+realIdx+',\'preparing\')">Prepare</button>';
         else if(o.status==='preparing') actions='<button class="btn btn-success btn-sm" onclick="changeOrderStatus('+realIdx+',\'ready\')">Ready</button>';
         else if(o.status==='ready') actions='<button class="btn btn-secondary btn-sm" onclick="changeOrderStatus('+realIdx+',\'completed\')">Complete</button>';
         if(o.status!=='completed'&&o.status!=='cancelled') actions+=' <button class="btn btn-danger btn-sm" onclick="changeOrderStatus('+realIdx+',\'cancelled\')">Cancel</button>';
         return '<tr><td><strong>'+o.id+'</strong></td><td>'+o.customer+'</td><td style="max-width:180px;white-space:normal;font-size:.78rem;">'+o.items+'</td><td><strong>RM'+parseFloat(o.total).toFixed(2)+'</strong></td><td>'+sBadge(o.status)+'</td><td>'+o.time+'</td><td>'+actions+'</td></tr>';
      }).join('')||'<tr><td colspan="7" style="text-align:center;color:#bbb;padding:24px;">No orders</td></tr>';
   }
   function changeOrderStatus(idx,status){
      orders[idx].status=status;
      setData('orders',orders); renderOrders();
      document.getElementById('sbOrderCount').textContent=orders.filter(function(o){return o.status==='pending';}).length;
      toast('Order status updated!');
   }

   /* ===== ORDER RECORDS ===== */
   function renderRecords(){
      var done=orders.filter(function(o){return o.status==='completed'||o.status==='cancelled';});
      var completed=done.filter(function(o){return o.status==='completed';});
      var cancelled=done.filter(function(o){return o.status==='cancelled';});
      var revenue=completed.reduce(function(s,o){return s+(parseFloat(o.total)||0);},0);
      document.getElementById('recCompleted').textContent=completed.length;
      document.getElementById('recCancelled').textContent=cancelled.length;
      document.getElementById('recRevenue').textContent='RM'+revenue.toFixed(2);
      document.getElementById('recordsBody').innerHTML=done.map(function(o){
         return '<tr><td><strong>'+o.id+'</strong></td><td>'+o.customer+'</td><td><strong>RM'+parseFloat(o.total).toFixed(2)+'</strong></td><td>'+sBadge(o.status)+'</td><td>'+o.time+'</td></tr>';
      }).join('')||'<tr><td colspan="5" style="text-align:center;color:#bbb;padding:24px;">No records yet</td></tr>';
   }

   /* ===== SYSTEM INFO ===== */
   function renderSysInfo(){
      var labels={restaurant_name:'Restaurant Name',restaurant_address:'Address',restaurant_phone:'Phone',restaurant_email:'Email',restaurant_hours:'Operating Hours',currency:'Currency',footer_text:'Footer Text'};
      var html='';
      Object.keys(sysInfo).forEach(function(k){
         html+='<div class="info-row"><div class="info-key">'+(labels[k]||k)+'</div><div class="info-val">'+sysInfo[k]+'</div><button class="info-edit" onclick="editInfo(\''+k+'\')"><i class="fas fa-pencil-alt"></i> Edit</button></div>';
      });
      document.getElementById('sysInfoBody').innerHTML=html;
   }
   function editInfo(key){
      var labels={restaurant_name:'Restaurant Name',restaurant_address:'Address',restaurant_phone:'Phone',restaurant_email:'Email',restaurant_hours:'Operating Hours',currency:'Currency',footer_text:'Footer Text'};
      document.getElementById('editInfoLabel').textContent=labels[key]||key;
      document.getElementById('editInfoVal').value=sysInfo[key]||'';
      document.getElementById('editInfoKey').value=key;
      openModal('modalEditInfo');
   }
   function saveInfoEdit(){
      var key=document.getElementById('editInfoKey').value;
      sysInfo[key]=document.getElementById('editInfoVal').value;
      setData('sysinfo',sysInfo); closeModal('modalEditInfo'); renderSysInfo(); toast('Setting updated!');
   }

   /* ===== DELETE GENERIC ===== */
   function deleteItem(type,idx){
      if(!confirm('Delete this item?')) return;
      var map={customers:customers,staff:staffList,categories:categories,menuItems:menuItems};
      var saves={customers:'customers',staff:'staff',categories:'categories',menuItems:'menuItems'};
      var arr=map[type]; arr.splice(idx,1);
      setData(saves[type],arr);
      var renders={customers:renderCustomers,staff:renderStaff,categories:renderCategories,menuItems:renderMenuItems};
      if(renders[type]) renders[type]();
      toast('Deleted!');
   }

   /* ===== INIT ===== */
   renderDashboard();
   // populate category dropdown on load
   var initSel=document.getElementById('newItemCat');
   if(initSel) initSel.innerHTML=categories.map(function(c){return '<option>'+c+'</option>';}).join('');
   </script>
</body>
</html>
