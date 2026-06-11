<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Staff Login — NFC</title>
   <link rel="icon" type="image" href="favicon.png">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
   <link href="css/bootstrap.min.css" rel="stylesheet"/>
   <link rel="stylesheet" href="css/all.min.css"/>
   <style>
      :root{--primary:#e8281a;--secondary:#f6a623;--dark:#1a1a1a;--cream:#fff8f0;}
      *{margin:0;padding:0;box-sizing:border-box;}
      body{font-family:"Poppins",sans-serif;background:var(--cream);min-height:100vh;display:flex;flex-direction:column;}
      /* NAV */
      nav{background:#fff;box-shadow:0 2px 20px rgba(0,0,0,.07);padding:14px 0;}
      .nav-inner{display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:0 24px;}
      .nav-logo img{width:44px;}
      .nav-back{font-size:.85rem;color:#777;text-decoration:none;display:flex;align-items:center;gap:6px;transition:.2s;}
      .nav-back:hover{color:var(--primary);}
      /* SPLIT LAYOUT */
      main{flex:1;display:flex;min-height:calc(100vh - 72px);}
      .login-left{flex:1;background:linear-gradient(145deg,#1a1a1a 0%,#2d0a08 60%,#e8281a 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 40px;position:relative;overflow:hidden;}
      .login-left::before{content:"NFC";position:absolute;font-family:"Playfair Display",serif;font-size:18vw;font-weight:900;color:rgba(255,255,255,.04);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;white-space:nowrap;}
      .ll-badge{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:50px;padding:8px 20px;color:rgba(255,255,255,.7);font-size:.75rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;margin-bottom:30px;}
      .ll-title{font-family:"Playfair Display",serif;font-size:clamp(2rem,4vw,3.2rem);font-weight:900;color:#fff;text-align:center;line-height:1.15;margin-bottom:16px;}
      .ll-title span{color:var(--secondary);}
      .ll-sub{color:rgba(255,255,255,.55);text-align:center;font-size:.9rem;line-height:1.7;max-width:340px;}
      .ll-dots{display:flex;gap:8px;margin-top:40px;}
      .ll-dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.2);}
      .ll-dot.active{background:var(--secondary);width:24px;border-radius:4px;}
      .login-right{width:480px;display:flex;align-items:center;justify-content:center;padding:40px 32px;background:#fff;}
      .auth-card{width:100%;max-width:400px;}
      .auth-icon{width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--primary),#c01e12);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;margin-bottom:20px;}
      .auth-card h2{font-family:"Playfair Display",serif;font-size:1.8rem;font-weight:900;color:var(--dark);margin-bottom:4px;}
      .auth-card .sub{color:#aaa;font-size:.84rem;margin-bottom:28px;}
      .auth-card .sub a{color:var(--primary);font-weight:600;text-decoration:none;}
      .form-group{margin-bottom:18px;}
      label{font-size:.82rem;font-weight:600;color:#555;margin-bottom:6px;display:block;}
      .input-wrap{position:relative;}
      .input-wrap i.icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#bbb;font-size:.88rem;}
      .input-wrap input{width:100%;padding:12px 14px 12px 40px;border:1.5px solid #e8e8e8;border-radius:10px;font-family:"Poppins",sans-serif;font-size:.88rem;color:var(--dark);transition:.3s;outline:none;background:#fafafa;}
      .input-wrap input:focus{border-color:var(--primary);background:#fff;box-shadow:0 0 0 3px rgba(232,40,26,.08);}
      .role-tabs{display:flex;gap:8px;margin-bottom:24px;}
      .rtab{flex:1;padding:10px;border:1.5px solid #e8e8e8;border-radius:10px;background:#fafafa;color:#888;font-size:.82rem;font-weight:600;cursor:pointer;text-align:center;transition:.2s;font-family:"Poppins",sans-serif;}
      .rtab.active{border-color:var(--primary);background:rgba(232,40,26,.06);color:var(--primary);}
      .submit-btn{width:100%;background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;border:none;border-radius:12px;padding:14px;font-size:.96rem;font-weight:700;cursor:pointer;font-family:"Poppins",sans-serif;transition:.3s;display:flex;align-items:center;justify-content:center;gap:9px;}
      .submit-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(232,40,26,.38);}
      .auth-alert{border-radius:10px;padding:12px 16px;font-size:.84rem;margin-bottom:18px;display:none;}
      .auth-alert.err{background:rgba(232,40,26,.08);color:var(--primary);border:1px solid rgba(232,40,26,.2);}
      .back-link{text-align:center;margin-top:20px;font-size:.82rem;color:#aaa;}
      .back-link a{color:var(--primary);font-weight:600;text-decoration:none;}
      @media(max-width:768px){.login-left{display:none;}.login-right{width:100%;}}
   </style>
</head>
<body>
   <nav>
      <div class="nav-inner">
         <a href="index.php" class="nav-logo"><img src="img/logo.png" alt="NFC Logo"></a>
         <a href="index.php" class="nav-back"><i class="fas fa-arrow-left"></i> Back to Home</a>
      </div>
   </nav>
   <main>
      <div class="login-left">
         <div class="ll-badge">Staff Portal</div>
         <h1 class="ll-title">Welcome to<br/><span>NFC</span> Portal</h1>
         <p class="ll-sub">Manage orders, menu, customers and more from your staff dashboard.</p>
         <div class="ll-dots"><div class="ll-dot active"></div><div class="ll-dot"></div><div class="ll-dot"></div></div>
      </div>
      <div class="login-right">
         <div class="auth-card">
            <div class="auth-icon"><i class="fas fa-shield-alt"></i></div>
            <h2>Staff Login</h2>
            <p class="sub">Enter your credentials to continue</p>
            <div class="auth-alert" id="authAlert"></div>
            <div class="role-tabs">
               <button class="rtab active" id="tabAdmin" onclick="setRole('admin')"><i class="fas fa-crown me-1"></i>Admin</button>
               <button class="rtab" id="tabStaff" onclick="setRole('staff')"><i class="fas fa-user-tie me-1"></i>Staff</button>
            </div>
            <div class="form-group">
               <label>Username</label>
               <div class="input-wrap">
                  <i class="fas fa-user icon"></i>
                  <input type="text" id="username" placeholder="Enter username" autocomplete="username">
               </div>
            </div>
            <div class="form-group">
               <label>Password</label>
               <div class="input-wrap">
                  <i class="fas fa-lock icon"></i>
                  <input type="password" id="password" placeholder="Enter password" autocomplete="current-password">
               </div>
            </div>
            <button class="submit-btn" onclick="doLogin()"><i class="fas fa-sign-in-alt"></i>Login</button>
            <p class="back-link mt-3"><a href="index.php"><i class="fas fa-home"></i> Back to Customer Page</a></p>
         </div>
      </div>
   </main>
   <script>
      var role = 'admin';
      function setRole(r){
         role = r;
         document.getElementById('tabAdmin').classList.toggle('active', r==='admin');
         document.getElementById('tabStaff').classList.toggle('active', r==='staff');
      }
      function showAlert(msg){
         var el = document.getElementById('authAlert');
         el.textContent = msg; el.className = 'auth-alert err'; el.style.display = 'block';
      }
      function doLogin(){
         var user = document.getElementById('username').value.trim();
         var pass = document.getElementById('password').value;
         if(!user||!pass){showAlert('Please enter username and password.');return;}
         // Credentials: admin/admin123 or staff/staff123
         if(role==='admin' && user==='admin' && pass==='admin123'){
            sessionStorage.setItem('nfc_role','admin');
            sessionStorage.setItem('nfc_user','admin');
            window.location.href='admin/indexadmin.php';
         } else if(role==='staff' && user==='staff' && pass==='staff123'){
            sessionStorage.setItem('nfc_role','staff');
            sessionStorage.setItem('nfc_user','staff');
            window.location.href='staff.php';
         } else {
            showAlert('Invalid username or password. Please try again.');
         }
      }
      document.addEventListener('keydown',function(e){if(e.key==='Enter')doLogin();});
   </script>
</body>
</html>
