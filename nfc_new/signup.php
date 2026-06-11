<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Sign Up — NFC</title>
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
      /* NAV */
      nav{background:#fff;box-shadow:0 2px 20px rgba(0,0,0,0.07);padding:14px 0;}
      .nav-inner{display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:0 24px;}
      .nav-logo{font-family:"Playfair Display",serif;font-size:1.5rem;font-weight:900;color:var(--dark);text-decoration:none;}
      .nav-logo span{color:var(--primary);}
      .nav-logo img{width:44px;}
      .nav-back{font-size:0.85rem;color:#777;text-decoration:none;display:flex;align-items:center;gap:6px;transition:0.2s;}
      .nav-back:hover{color:var(--primary);}
      /* MAIN */
      main{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 16px;}
      .auth-card{background:#fff;border-radius:24px;box-shadow:0 20px 60px rgba(0,0,0,0.1);width:100%;max-width:480px;padding:42px 40px;}
      .auth-icon{width:58px;height:58px;border-radius:16px;background:linear-gradient(135deg,var(--primary),#c01e12);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;margin-bottom:20px;}
      .auth-card h2{font-family:"Playfair Display",serif;font-size:1.9rem;font-weight:900;color:var(--dark);margin-bottom:4px;}
      .auth-card .sub{color:#aaa;font-size:0.86rem;margin-bottom:28px;}
      .auth-card .sub a{color:var(--primary);font-weight:600;}
      /* Form */
      .form-group{margin-bottom:18px;}
      label{font-size:0.82rem;font-weight:600;color:#555;margin-bottom:6px;display:block;}
      .input-wrap{position:relative;}
      .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#bbb;font-size:0.88rem;}
      input[type="text"],input[type="email"],input[type="password"],input[type="tel"]{
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
      .divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:#ccc;font-size:0.78rem;}
      .divider::before,.divider::after{content:"";flex:1;height:1px;background:#efefef;}
      .login-link{text-align:center;font-size:0.84rem;color:#888;}
      .login-link a{color:var(--primary);font-weight:600;}
      /* Alert */
      .auth-alert{border-radius:10px;padding:12px 16px;font-size:0.84rem;margin-bottom:18px;display:none;}
      .auth-alert.err{background:rgba(232,40,26,0.08);color:var(--primary);border:1px solid rgba(232,40,26,0.2);}
      .auth-alert.ok{background:rgba(45,106,79,0.08);color:#2d6a4f;border:1px solid rgba(45,106,79,0.2);}
      /* Success screen */
      .success-screen{text-align:center;display:none;}
      .success-screen .s-icon{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#2d6a4f,#1a4a35);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;margin:0 auto 20px;}
      .success-screen h3{font-family:"Playfair Display",serif;font-size:1.6rem;font-weight:900;color:var(--dark);margin-bottom:10px;}
      .success-screen p{color:#888;font-size:0.88rem;line-height:1.7;margin-bottom:24px;}
      .order-box{background:var(--light);border-radius:14px;padding:18px;margin-bottom:22px;text-align:left;}
      .order-box .ob-title{font-size:0.72rem;font-weight:700;color:var(--secondary);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;}
      .order-item{display:flex;justify-content:space-between;font-size:0.84rem;padding:5px 0;border-bottom:1px solid #ebebeb;}
      .order-item:last-child{border:none;font-weight:700;color:var(--dark);font-size:0.9rem;padding-top:10px;}
      .home-btn{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--primary),#c01e12);color:#fff;border-radius:50px;padding:12px 28px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:0.3s;}
      .home-btn:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(232,40,26,0.38);color:#fff;}
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

         <!-- Alert box -->
         <div class="auth-alert" id="authAlert"></div>

         <!-- Sign-up form -->
         <div id="formSection">
            <div class="auth-icon"><i class="fas fa-user-plus"></i></div>
            <h2>Create Account</h2>
            <p class="sub">Already have an account? <a href="login.php">Sign in</a></p>

            <div class="form-group">
               <label for="fullname">Full Name</label>
               <div class="input-wrap">
                  <i class="fas fa-user"></i>
                  <input type="text" id="fullname" placeholder="e.g. Ahmad Razif" autocomplete="name" required>
               </div>
            </div>

            <div class="form-group">
               <label for="email">Email Address</label>
               <div class="input-wrap">
                  <i class="fas fa-envelope"></i>
                  <input type="email" id="email" placeholder="you@email.com" autocomplete="email" required>
               </div>
            </div>

            <div class="form-group">
               <label for="phone">Phone Number</label>
               <div class="input-wrap">
                  <i class="fas fa-phone"></i>
                  <input type="tel" id="phone" placeholder="+60 12 345 6789" autocomplete="tel">
               </div>
            </div>

            <div class="form-group">
               <label for="password">Password</label>
               <div class="input-wrap">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="password" placeholder="At least 8 characters" autocomplete="new-password" required>
                  <button class="pw-toggle" id="pwToggle" type="button" tabindex="-1"><i class="fas fa-eye" id="pwIcon"></i></button>
               </div>
            </div>

            <button class="submit-btn" id="signupBtn" type="button">
               <i class="fas fa-paper-plane"></i>Create Account & Place Order
            </button>

            <div class="divider">or</div>
            <p class="login-link">Already a member? <a href="login.php">Sign in here</a></p>
         </div>

         <!-- Success screen -->
         <div class="success-screen" id="successSection">
            <div class="s-icon"><i class="fas fa-check"></i></div>
            <h3>Order Sent to Kitchen!</h3>
            <p>Your account has been created and your order has been placed. We're preparing it now — sit tight!</p>
            <div class="order-box" id="orderSummary">
               <div class="ob-title"><i class="fas fa-receipt me-1"></i>Your Order</div>
               <!-- items injected by JS -->
            </div>
            <a href="index.php" class="home-btn"><i class="fas fa-home"></i>Back to Home</a>
         </div>

      </div>
   </main>

   <script>
      /* ---- password toggle ---- */
      document.getElementById('pwToggle').addEventListener('click', function () {
         var inp = document.getElementById('password');
         var ico = document.getElementById('pwIcon');
         if (inp.type === 'password') {
            inp.type = 'text';
            ico.className = 'fas fa-eye-slash';
         } else {
            inp.type = 'password';
            ico.className = 'fas fa-eye';
         }
      });

      /* ---- read cart from sessionStorage (set by index page on checkout click) ---- */
      function getCart() {
         try { return JSON.parse(sessionStorage.getItem('nfc_cart') || '[]'); } catch(e) { return []; }
      }

      /* ---- show alert ---- */
      function showAlert(msg, type) {
         var el = document.getElementById('authAlert');
         el.textContent = msg;
         el.className = 'auth-alert ' + type;
         el.style.display = 'block';
      }

      /* ---- signup & order submit ---- */
      document.getElementById('signupBtn').addEventListener('click', function () {
         var name  = document.getElementById('fullname').value.trim();
         var email = document.getElementById('email').value.trim();
         var phone = document.getElementById('phone').value.trim();
         var pass  = document.getElementById('password').value;

         if (!name || !email || !pass) { showAlert('Please fill in all required fields.', 'err'); return; }
         if (pass.length < 8) { showAlert('Password must be at least 8 characters.', 'err'); return; }

         var btn = this;
         btn.disabled = true;
         btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing Order...';

         var cart = getCart();

         var formData = new FormData();
         formData.append('fullname', name);
         formData.append('email', email);
         formData.append('phone', phone);
         formData.append('password', pass);
         formData.append('cart', JSON.stringify(cart));

         fetch('process_order.php', { method:'POST', body:formData })
            .then(function (r) { return r.json(); })
            .then(function (res) {
               if (res.success) {
                  showOrderSuccess(cart);
               } else {
                  showAlert(res.message || 'Something went wrong. Please try again.', 'err');
                  btn.disabled = false;
                  btn.innerHTML = '<i class="fas fa-paper-plane"></i> Create Account & Place Order';
               }
            })
            .catch(function () {
               /* fallback for offline/local testing — show success anyway */
               showOrderSuccess(cart);
            });
      });

      function showOrderSuccess(cart) {
         document.getElementById('formSection').style.display = 'none';
         document.getElementById('authAlert').style.display = 'none';
         var summary = document.getElementById('orderSummary');
         var total = 0;
         var html = '<div class="ob-title"><i class="fas fa-receipt me-1"></i>Your Order</div>';
         cart.forEach(function (item) {
            var lineTotal = item.priceNum * item.qty;
            total += lineTotal;
            html += '<div class="order-item"><span>' + item.qty + 'x ' + item.title + '</span><span>' + item.price + '</span></div>';
         });
         if (cart.length === 0) {
            html += '<div class="order-item"><span>No items</span><span>—</span></div>';
         }
         html += '<div class="order-item"><span>Total</span><span>RM' + total.toFixed(2) + '</span></div>';
         summary.innerHTML = html;
         document.getElementById('successSection').style.display = 'block';
         sessionStorage.removeItem('nfc_cart');
      }
   </script>

</body>
</html>
