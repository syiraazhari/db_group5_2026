<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Sign In — NFC</title>
   <link rel="icon" type="image" href="favicon.png">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
   <link href="css/bootstrap.min.css" rel="stylesheet"/>
   <link rel="stylesheet" href="css/all.min.css"/>
   <style>
      :root {
         --primary:#e8281a; --secondary:#f6a623; --dark:#1a1a1a;
         --cream:#fff8f0; --cream2:#fef0dc; --light:#f9f5f0;
      }
      *{margin:0;padding:0;box-sizing:border-box;}
      body{font-family:"Poppins",sans-serif;background:var(--cream);min-height:100vh;display:flex;flex-direction:column;}
      nav{background:#fff;box-shadow:0 2px 20px rgba(0,0,0,0.07);padding:14px 0;}
      .nav-inner{display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:0 24px;}
      .nav-logo img{width:44px;}
      .nav-back{font-size:0.85rem;color:#777;text-decoration:none;display:flex;align-items:center;gap:6px;transition:0.2s;}
      .nav-back:hover{color:var(--primary);}
      main{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 16px;}
      .auth-card{background:#fff;border-radius:24px;box-shadow:0 20px 60px rgba(0,0,0,0.1);width:100%;max-width:440px;padding:42px 40px;}
      .auth-icon{width:58px;height:58px;border-radius:16px;background:linear-gradient(135deg,var(--primary),#c01e12);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;margin-bottom:20px;}
      .auth-card h2{font-family:"Playfair Display",serif;font-size:1.9rem;font-weight:900;color:var(--dark);margin-bottom:4px;}
      .auth-card .sub{color:#aaa;font-size:0.86rem;margin-bottom:28px;}
      .auth-card .sub a{color:var(--primary);font-weight:600;}
      .form-group{margin-bottom:18px;}
      label{font-size:0.82rem;font-weight:600;color:#555;margin-bottom:6px;display:block;}
      .input-wrap{position:relative;}
      .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#bbb;font-size:0.88rem;}
      input[type="email"],input[type="password"]{
         width:100%;padding:12px 14px 12px 40px;border:1.5px solid #e8e8e8;border-radius:10px;
         font-family:"Poppins",sans-serif;font-size:0.88rem;color:var(--dark);
         transition:0.3s;outline:none;background:#fafafa;
      }
      input:focus{border-color:var(--primary);background:#fff;box-shadow:0 0 0 3px rgba(232,40,26,0.08);}
      .pw-toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#bbb;font-size:0.88rem;border:none;background:none;padding:0;}
      .pw-toggle:hover{color:var(--primary);}
      .submit-btn{
         width:100%;background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;
         border:none;border-radius:12px;padding:14px;font-size:0.96rem;font-weight:700;
         cursor:pointer;font-family:"Poppins",sans-serif;transition:0.3s;margin-top:6px;
         display:flex;align-items:center;justify-content:center;gap:9px;
      }
      .submit-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(232,40,26,0.38);}
      .submit-btn:disabled{opacity:0.7;cursor:not-allowed;transform:none;}
      .signup-link{text-align:center;font-size:0.84rem;color:#888;margin-top:18px;}
      .signup-link a{color:var(--primary);font-weight:600;}
      .auth-alert{border-radius:10px;padding:12px 16px;font-size:0.84rem;margin-bottom:18px;display:none;}
      .auth-alert.err{background:rgba(232,40,26,0.08);color:var(--primary);border:1px solid rgba(232,40,26,0.2);}
      .auth-alert.ok{background:rgba(45,106,79,0.08);color:#2d6a4f;border:1px solid rgba(45,106,79,0.2);}
   </style>
</head>
<body>

   <nav>
      <div class="nav-inner">
         <a href="index.php" class="nav-logo">
            <img src="img/logo.png" alt="NFC Logo">
         </a>
         <a href="index.php" class="nav-back"><i class="fas fa-arrow-left"></i>Back to Menu</a>
      </div>
   </nav>

   <main>
      <div class="auth-card">

         <div class="auth-alert" id="authAlert"></div>

         <div class="auth-icon"><i class="fas fa-user"></i></div>
         <h2>Welcome Back</h2>
         <p class="sub">New here? <a href="signup.php">Create an account</a></p>

         <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrap">
               <i class="fas fa-envelope"></i>
               <input type="email" id="email" placeholder="you@email.com" autocomplete="email" required>
            </div>
         </div>

         <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
               <i class="fas fa-lock"></i>
               <input type="password" id="password" placeholder="Enter your password" autocomplete="current-password" required>
               <button class="pw-toggle" id="pwToggle" type="button" tabindex="-1"><i class="fas fa-eye" id="pwIcon"></i></button>
            </div>
         </div>

         <button class="submit-btn" id="loginBtn" type="button">
            <i class="fas fa-sign-in-alt"></i>Sign In
         </button>

         <p class="signup-link">Don't have an account? <a href="signup.php">Create one</a></p>
      </div>
   </main>

   <script>
      document.getElementById('pwToggle').addEventListener('click', function () {
         var inp = document.getElementById('password');
         var ico = document.getElementById('pwIcon');
         if (inp.type === 'password') { inp.type = 'text'; ico.className = 'fas fa-eye-slash'; }
         else { inp.type = 'password'; ico.className = 'fas fa-eye'; }
      });

      function showAlert(msg, type) {
         var el = document.getElementById('authAlert');
         el.textContent = msg;
         el.className = 'auth-alert ' + type;
         el.style.display = 'block';
      }

      function getCart() {
         try { return JSON.parse(sessionStorage.getItem('nfc_cart') || '[]'); } catch(e) { return []; }
      }

      document.getElementById('loginBtn').addEventListener('click', function () {
         var email = document.getElementById('email').value.trim();
         var pass  = document.getElementById('password').value;
         if (!email || !pass) { showAlert('Please enter your email and password.', 'err'); return; }

         var btn = this;
         btn.disabled = true;
         btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in...';

         var fd = new FormData();
         fd.append('action', 'customer_login');
         fd.append('email', email);
         fd.append('password', pass);

         fetch('api.php', { method:'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (res) {
               if (!res.success) {
                  showAlert(res.message || 'Invalid email or password.', 'err');
                  btn.disabled = false;
                  btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Sign In';
                  return;
               }
               var cart = getCart();
               if (cart.length > 0) {
                  // Place the pending cart immediately after login
                  var fd2 = new FormData();
                  fd2.append('action', 'place_order');
                  fd2.append('cart', JSON.stringify(cart));
                  fetch('api.php', { method:'POST', body: fd2 })
                     .then(function (r) { return r.json(); })
                     .then(function (res2) {
                        sessionStorage.removeItem('nfc_cart');
                        if (res2.success) {
                           window.location.href = 'index.php?ordered=1';
                        } else {
                           window.location.href = 'index.php';
                        }
                     })
                     .catch(function () { window.location.href = 'index.php'; });
               } else {
                  window.location.href = 'index.php';
               }
            })
            .catch(function () {
               showAlert('Could not reach the server. Please try again.', 'err');
               btn.disabled = false;
               btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Sign In';
            });
      });

      document.addEventListener('keydown', function (e) {
         if (e.key === 'Enter') document.getElementById('loginBtn').click();
      });
   </script>

</body>
</html>
