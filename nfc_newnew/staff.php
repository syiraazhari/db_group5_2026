<?php
session_start();
if (empty($_SESSION['staff_id']) || !in_array($_SESSION['staff_role'] ?? '', ['staff','admin'])) {
    header('Location: login.php');
    exit;
}
$staffName = $_SESSION['staff_name'] ?? 'Staff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Staff Dashboard — NFC</title>
   <link rel="icon" type="image" href="favicon.png">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
   <link href="css/bootstrap.min.css" rel="stylesheet"/>
   <link rel="stylesheet" href="css/all.min.css"/>
   <style>
      :root{--primary:#e8281a;--secondary:#f6a623;--dark:#1a1a1a;--cream:#fff8f0;--light:#f9f5f0;}
      *{margin:0;padding:0;box-sizing:border-box;}
      body{font-family:"Poppins",sans-serif;background:var(--light);min-height:100vh;}
      /* TOPBAR */
      .topbar{background:#fff;box-shadow:0 2px 20px rgba(0,0,0,.07);padding:0 32px;height:68px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
      .topbar-left{display:flex;align-items:center;gap:14px;}
      .topbar-left img{width:42px;}
      .topbar-brand{font-family:"Playfair Display",serif;font-size:1.25rem;font-weight:900;color:var(--dark);}
      .topbar-brand span{color:var(--primary);}
      .topbar-badge{background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;font-size:.68rem;font-weight:700;border-radius:50px;padding:3px 10px;letter-spacing:.5px;text-transform:uppercase;}
      .topbar-right{display:flex;align-items:center;gap:16px;}
      .staff-name{font-size:.84rem;color:#888;}
      .staff-name strong{color:var(--dark);}
      .logout-btn{background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;border:none;border-radius:8px;padding:9px 20px;font-size:.82rem;font-weight:600;cursor:pointer;font-family:"Poppins",sans-serif;transition:.3s;display:flex;align-items:center;gap:7px;text-decoration:none;}
      .logout-btn:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(232,40,26,.35);color:#fff;}
      /* MAIN */
      .main-wrap{padding:32px;}
      .page-title{font-family:"Playfair Display",serif;font-size:1.9rem;font-weight:900;color:var(--dark);margin-bottom:4px;}
      .page-sub{color:#aaa;font-size:.86rem;margin-bottom:28px;}
      /* STAT CARDS */
      .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:32px;}
      .stat-card{background:#fff;border-radius:16px;padding:22px 24px;box-shadow:0 4px 20px rgba(0,0,0,.06);display:flex;align-items:center;gap:16px;}
      .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;color:#fff;flex-shrink:0;}
      .si-red{background:linear-gradient(135deg,var(--primary),#c01e12);}
      .si-orange{background:linear-gradient(135deg,var(--secondary),#e0900d);}
      .si-green{background:linear-gradient(135deg,#2d6a4f,#1a4a35);}
      .si-blue{background:linear-gradient(135deg,#3b82f6,#1d4ed8);}
      .stat-info .num{font-family:"Playfair Display",serif;font-size:1.7rem;font-weight:900;color:var(--dark);line-height:1;}
      .stat-info .lbl{font-size:.74rem;color:#aaa;text-transform:uppercase;letter-spacing:.8px;margin-top:3px;}
      /* ORDERS TABLE */
      .section-card{background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.06);overflow:hidden;margin-bottom:28px;}
      .section-header{padding:20px 24px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;}
      .section-header h5{font-family:"Playfair Display",serif;font-size:1.1rem;font-weight:800;color:var(--dark);margin:0;}
      .refresh-btn{background:var(--light);border:none;border-radius:8px;padding:8px 16px;font-size:.8rem;font-weight:600;cursor:pointer;color:#666;font-family:"Poppins",sans-serif;display:flex;align-items:center;gap:6px;transition:.2s;}
      .refresh-btn:hover{background:#eee;}
      table{width:100%;border-collapse:collapse;}
      thead tr{background:var(--light);}
      th{padding:12px 18px;text-align:left;font-size:.75rem;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.8px;}
      td{padding:14px 18px;border-bottom:1px solid #f5f5f5;font-size:.86rem;color:#555;vertical-align:middle;}
      tr:last-child td{border-bottom:none;}
      .status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:50px;font-size:.74rem;font-weight:700;}
      .sb-pending{background:rgba(246,166,35,.12);color:#c68b00;}
      .sb-preparing{background:rgba(59,130,246,.12);color:#1d4ed8;}
      .sb-ready{background:rgba(45,106,79,.12);color:#2d6a4f;}
      .sb-completed{background:rgba(107,114,128,.12);color:#4b5563;}
      .sb-cancelled{background:rgba(232,40,26,.1);color:var(--primary);}
      .action-btn{border:none;border-radius:6px;padding:6px 14px;font-size:.76rem;font-weight:600;cursor:pointer;font-family:"Poppins",sans-serif;transition:.2s;}
      .btn-prepare{background:rgba(59,130,246,.1);color:#1d4ed8;}
      .btn-prepare:hover{background:rgba(59,130,246,.2);}
      .btn-ready{background:rgba(45,106,79,.1);color:#2d6a4f;}
      .btn-ready:hover{background:rgba(45,106,79,.2);}
      .btn-done{background:rgba(107,114,128,.1);color:#4b5563;}
      .btn-done:hover{background:rgba(107,114,128,.2);}
      .empty-state{text-align:center;padding:48px;color:#bbb;}
      .empty-state i{font-size:2.5rem;margin-bottom:12px;display:block;}
   </style>
</head>
<body>
   <!-- TOPBAR -->
   <div class="topbar">
      <div class="topbar-left">
         <img src="img/logo.png" alt="NFC">
         <div>
            <div class="topbar-brand">Nandawgs <span>FC</span></div>
         </div>
         <span class="topbar-badge">Staff</span>
      </div>
      <div class="topbar-right">
         <span class="staff-name">Logged in as <strong id="staffName">Staff</strong></span>
         <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
      </div>
   </div>

   <div class="main-wrap">
      <div class="page-title">Kitchen Dashboard</div>
      <div class="page-sub">View and manage incoming customer orders</div>

      <!-- STATS -->
      <div class="stats-row">
         <div class="stat-card">
            <div class="stat-icon si-orange"><i class="fas fa-clock"></i></div>
            <div class="stat-info"><div class="num" id="cntPending">0</div><div class="lbl">Pending</div></div>
         </div>
         <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fas fa-fire"></i></div>
            <div class="stat-info"><div class="num" id="cntPreparing">0</div><div class="lbl">Preparing</div></div>
         </div>
         <div class="stat-card">
            <div class="stat-icon si-green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info"><div class="num" id="cntReady">0</div><div class="lbl">Ready</div></div>
         </div>
         <div class="stat-card">
            <div class="stat-icon si-red"><i class="fas fa-receipt"></i></div>
            <div class="stat-info"><div class="num" id="cntTotal">0</div><div class="lbl">Total Today</div></div>
         </div>
      </div>

      <!-- ORDERS TABLE -->
      <div class="section-card">
         <div class="section-header">
            <h5><i class="fas fa-list-alt me-2" style="color:var(--primary)"></i>Active Orders</h5>
            <button class="refresh-btn" onclick="loadOrders()"><i class="fas fa-sync-alt"></i> Refresh</button>
         </div>
         <table>
            <thead>
               <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Items</th>
                  <th>Total</th>
                  <th>Time</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody id="ordersBody"></tbody>
         </table>
      </div>
   </div>

   <script>
      // Auth check (server already verified session; this just displays name)
      document.getElementById('staffName').textContent = <?= json_encode($staffName) ?>;

      function doLogout(){
         window.location.href='logout.php';
      }

      var orders = [];

      function statusBadge(s){
         var map={pending:'sb-pending',preparing:'sb-preparing',ready:'sb-ready',completed:'sb-completed',cancelled:'sb-cancelled'};
         var icons={pending:'fa-clock',preparing:'fa-fire',ready:'fa-check-circle',completed:'fa-check-double',cancelled:'fa-times-circle'};
         return '<span class="status-badge '+(map[s]||'sb-pending')+'"><i class="fas '+(icons[s]||'fa-clock')+'"></i>'+s.charAt(0).toUpperCase()+s.slice(1)+'</span>';
      }

      function actionBtns(id,s){
         if(s==='pending') return '<button class="action-btn btn-prepare" onclick="updateStatus('+id+',\'preparing\')">Start Prep</button>';
         if(s==='preparing') return '<button class="action-btn btn-ready" onclick="updateStatus('+id+',\'ready\')">Mark Ready</button>';
         if(s==='ready') return '<button class="action-btn btn-done" onclick="updateStatus('+id+',\'completed\')">Done</button>';
         return '<span style="color:#bbb;font-size:.78rem;">—</span>';
      }

      function updateStatus(orderId,status){
         var fd=new FormData();
         fd.append('action','order_update_status');
         fd.append('order_id', orderId);
         fd.append('status', status);
         fetch('api.php',{method:'POST',body:fd})
            .then(function(r){return r.json();})
            .then(function(res){
               if(res.success){ loadOrders(); }
               else { alert(res.message||'Could not update order.'); }
            });
      }

      function fmtItems(items){
         return items.map(function(it){ return it.quantity+'x '+it.item_name; }).join(', ');
      }
      function fmtTime(dt){
         var d=new Date(dt.replace(' ','T'));
         if(isNaN(d.getTime())) return dt;
         return d.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
      }

      function loadOrders(){
         fetch('api.php?action=orders_list')
            .then(function(r){return r.json();})
            .then(function(res){
               if(!res.success){
                  if(res.message && res.message.indexOf('logged in')>-1){ window.location.href='login.php'; }
                  return;
               }
               orders = res.orders;
               render();
            });
      }

      function render(){
         var tbody=document.getElementById('ordersBody');
         var active=orders.filter(function(o){return o.order_status!=='completed'&&o.order_status!=='cancelled';});
         if(active.length===0){
            tbody.innerHTML='<tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No active orders right now</p></div></td></tr>';
         } else {
            tbody.innerHTML=active.map(function(o){
               return '<tr><td><strong>#'+o.order_id+'</strong></td><td>'+(o.customer_name||'Guest')+'</td><td style="max-width:220px;white-space:normal;">'+fmtItems(o.items)+'</td><td><strong>RM'+parseFloat(o.total_price).toFixed(2)+'</strong></td><td>'+fmtTime(o.order_date)+'</td><td>'+statusBadge(o.order_status)+'</td><td>'+actionBtns(o.order_id,o.order_status)+'</td></tr>';
            }).join('');
         }
         var cnt={pending:0,preparing:0,ready:0};
         orders.forEach(function(o){if(cnt[o.order_status]!==undefined)cnt[o.order_status]++;});
         document.getElementById('cntPending').textContent=cnt.pending;
         document.getElementById('cntPreparing').textContent=cnt.preparing;
         document.getElementById('cntReady').textContent=cnt.ready;
         document.getElementById('cntTotal').textContent=orders.length;
      }

      loadOrders();
      // keep the dashboard fresh as new orders/status changes come in
      setInterval(loadOrders, 8000);
   </script>
</body>
</html>
