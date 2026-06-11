AOS.init({ duration: 680, once: true, offset: 55 });

/* ===================== NAVBAR SCROLL ===================== */
window.addEventListener('scroll', function () {
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 60);
  document.getElementById('btt').classList.toggle('show', window.scrollY > 300);
  document.querySelectorAll('section[id]').forEach(function (sec) {
    var top = sec.offsetTop - 110, bot = top + sec.offsetHeight;
    if (window.scrollY >= top && window.scrollY < bot) {
      document.querySelectorAll('.nav-link').forEach(function (l) { l.classList.remove('active'); });
      var lnk = document.querySelector('.nav-link[href="#' + sec.id + '"]');
      if (lnk) lnk.classList.add('active');
    }
  });
});

/* ===================== SMOOTH SCROLL ===================== */
document.querySelectorAll('a[href^="#"]').forEach(function (a) {
  a.addEventListener('click', function (e) {
    var href = this.getAttribute('href');
    if (href === '#') return;
    var t = document.querySelector(href);
    if (t) {
      e.preventDefault();
      var navCollapse = document.getElementById('navmenu');
      if (navCollapse && navCollapse.classList.contains('show')) {
        var bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
        if (bsCollapse) bsCollapse.hide();
        else navCollapse.classList.remove('show');
      }
      setTimeout(function () {
        window.scrollTo({ top: t.offsetTop - 78, behavior: 'smooth' });
      }, 50);
    }
  });
});

/* ===================== MENU FILTER ===================== */
function filterMenu(cat) {
  document.querySelectorAll('.filtbtn').forEach(function (b) {
    b.classList.toggle('active', b.getAttribute('data-f') === cat);
  });
  document.querySelectorAll('.mwrap').forEach(function (w) {
    var c = w.getAttribute('data-c');
    if (cat === 'all' || c === cat) {
      w.classList.remove('gone');
      w.style.opacity = '0';
      w.style.transform = 'translateY(16px)';
      setTimeout(function () {
        w.style.transition = 'opacity .38s,transform .38s';
        w.style.opacity = '1';
        w.style.transform = 'translateY(0)';
      }, 60);
    } else {
      w.classList.add('gone');
    }
  });
}

document.querySelectorAll('.filtbtn').forEach(function (btn) {
  btn.addEventListener('click', function () { filterMenu(this.getAttribute('data-f')); });
});

/* ===================== CART STATE ===================== */
var cartItems = []; // { title, price, priceNum, qty, img }

function getCartTotal() {
  return cartItems.reduce(function (s, i) { return s + i.priceNum * i.qty; }, 0);
}

function renderCart() {
  var container = document.getElementById('cartItems');
  var empty = document.getElementById('cartEmpty');
  var footer = document.getElementById('cartFooter');
  var totalEl = document.getElementById('cartTotal');
  var countEl = document.getElementById('cartCount');

  // update floating count badge
  var totalQty = cartItems.reduce(function (s, i) { return s + i.qty; }, 0);
  countEl.textContent = totalQty;

  if (cartItems.length === 0) {
    empty.style.display = 'flex';
    footer.style.display = 'none';
    // clear any item rows but keep empty div
    Array.from(container.querySelectorAll('.cart-item-row')).forEach(function (el) { el.remove(); });
    return;
  }

  empty.style.display = 'none';
  footer.style.display = 'block';

  // rebuild item rows
  Array.from(container.querySelectorAll('.cart-item-row')).forEach(function (el) { el.remove(); });
  cartItems.forEach(function (item, idx) {
    var row = document.createElement('div');
    row.className = 'cart-item-row';
    row.innerHTML =
      '<img src="' + item.img + '" alt="' + item.title + '">' +
      '<div class="cart-item-info">' +
        '<div class="cart-item-title">' + item.title + '</div>' +
        '<div class="cart-item-price">' + item.price + '</div>' +
      '</div>' +
      '<div class="cart-item-qty">' +
        '<button class="cqbtn" data-idx="' + idx + '" data-act="minus">-</button>' +
        '<span>' + item.qty + '</span>' +
        '<button class="cqbtn" data-idx="' + idx + '" data-act="plus">+</button>' +
      '</div>' +
      '<button class="cart-item-del" data-idx="' + idx + '"><i class="fas fa-trash"></i></button>';
    container.insertBefore(row, empty);
  });

  totalEl.textContent = 'RM' + getCartTotal().toFixed(2);

  // qty / delete handlers
  container.querySelectorAll('.cqbtn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var i = parseInt(this.getAttribute('data-idx'));
      if (this.getAttribute('data-act') === 'plus') {
        cartItems[i].qty++;
      } else {
        cartItems[i].qty--;
        if (cartItems[i].qty <= 0) cartItems.splice(i, 1);
      }
      renderCart();
    });
  });
  container.querySelectorAll('.cart-item-del').forEach(function (btn) {
    btn.addEventListener('click', function () {
      cartItems.splice(parseInt(this.getAttribute('data-idx')), 1);
      renderCart();
    });
  });
}

/* ===================== CART POPUP ===================== */
var cartPop = document.getElementById('cartPop');

// Simple non-blocking toast notification (replaces alert())
function showToast(msg, type) {
  var t = document.getElementById('nfcToast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'nfcToast';
    t.style.cssText = 'position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(80px);' +
      'background:#1a1a1a;color:#fff;padding:14px 24px;border-radius:12px;font-family:"Poppins",sans-serif;' +
      'font-size:.9rem;z-index:99999;opacity:0;transition:.3s;box-shadow:0 10px 30px rgba(0,0,0,.25);text-align:center;max-width:90%;';
    document.body.appendChild(t);
  }
  t.style.background = type === 'error' ? 'linear-gradient(135deg,#e8281a,#c01e12)' : 'linear-gradient(135deg,#2d6a4f,#1a4a35)';
  t.textContent = msg;
  requestAnimationFrame(function () {
    t.style.opacity = '1';
    t.style.transform = 'translateX(-50%) translateY(0)';
  });
  clearTimeout(window._nfcToastTimer);
  window._nfcToastTimer = setTimeout(function () {
    t.style.opacity = '0';
    t.style.transform = 'translateX(-50%) translateY(80px)';
  }, 3200);
}

// Checkout handler — no alert; logged-in customers' orders go straight to
// the kitchen via the database, guests are sent to create an account first.
function handleCheckout() {
  if (cartItems.length === 0) { return; }
  sessionStorage.setItem('nfc_cart', JSON.stringify(cartItems));

  if (typeof NFC_LOGGED_IN !== 'undefined' && NFC_LOGGED_IN) {
    var fd = new FormData();
    fd.append('action', 'place_order');
    fd.append('cart', JSON.stringify(cartItems));
    fetch('api.php', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.success) {
          cartItems = [];
          sessionStorage.removeItem('nfc_cart');
          renderCart();
          closeCart();
          showToast('Order #' + res.order_id + ' sent to the kitchen! \uD83C\uDF57');
        } else {
          showToast(res.message || 'Could not place your order. Please try again.', 'error');
        }
      })
      .catch(function () {
        showToast('Could not reach the server. Please try again.', 'error');
      });
  } else {
    closeCart();
    window.location.href = 'signup.php';
  }
}
// legacy listener (in case button also fires event)
document.getElementById('cartCheckout').addEventListener('click', function (e) {
  e.preventDefault();
});

function openCart() {
  renderCart();
  cartPop.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeCart() {
  cartPop.classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('cartFlBtn').addEventListener('click', openCart);
document.getElementById('cartClose').addEventListener('click', closeCart);
cartPop.addEventListener('click', function (e) { if (e.target === this) closeCart(); });

/* ===================== MENU DETAIL POPUP ===================== */
var menuPop = document.getElementById('menuPop');
var mpQty = 1;
var currentCardId = null;

function openMenuPop(card) {
  currentCardId = card.getAttribute('data-id');
  var img   = card.getAttribute('data-img');
  var title = card.getAttribute('data-title');
  var cat   = card.getAttribute('data-cat');
  var price = card.getAttribute('data-price');
  var old   = card.getAttribute('data-old');
  var desc  = card.getAttribute('data-desc');
  var tags  = card.getAttribute('data-tags') || '';

  // these elements are hidden but must exist so JS doesn't throw
  document.getElementById('mpStars').textContent = '';
  document.getElementById('mpMeta').innerHTML = '';

  document.getElementById('mpImg').setAttribute('src', img);
  document.getElementById('mpCat').textContent = cat;
  document.getElementById('mpTitle').textContent = title;
  document.getElementById('mpDesc').textContent = desc;
  document.getElementById('mpPrice').innerHTML =
    price + (old ? '<small>' + old + '</small>' : '');

  document.getElementById('mpTags').innerHTML =
    tags.split(',').filter(Boolean).map(function (t) {
      return '<span class="mptag">' + t.trim() + '</span>';
    }).join('');

  mpQty = 1;
  document.getElementById('mpQnum').textContent = 1;
  document.getElementById('mpAddCart').innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
  document.getElementById('mpAddCart').style.background = '';

  menuPop.classList.add('open');
  document.body.style.overflow = 'hidden';
}

document.querySelectorAll('.mcard').forEach(function (card) {
  card.addEventListener('click', function () { openMenuPop(this); });
});
document.querySelectorAll('.madd').forEach(function (btn) {
  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    openMenuPop(this.closest('.mcard'));
  });
});

document.querySelectorAll('.mhrt').forEach(function (btn) {
  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    var ico = this.querySelector('i');
    ico.classList.toggle('far');
    ico.classList.toggle('fas');
    this.style.color = ico.classList.contains('fas') ? 'var(--primary)' : '#ccc';
  });
});

document.getElementById('mpClose').addEventListener('click', closeMenuPop);
menuPop.addEventListener('click', function (e) { if (e.target === this) closeMenuPop(); });

function closeMenuPop() {
  menuPop.classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('mpPlus').addEventListener('click', function () {
  document.getElementById('mpQnum').textContent = ++mpQty;
});
document.getElementById('mpMinus').addEventListener('click', function () {
  if (mpQty > 1) document.getElementById('mpQnum').textContent = --mpQty;
});

/* Add to Cart — adds to cartItems array */
document.getElementById('mpAddCart').addEventListener('click', function () {
  var card = document.querySelector('#menuPop .mpbox');
  var title = document.getElementById('mpTitle').textContent;
  var price = document.getElementById('mpPrice').firstChild.textContent.trim();
  var img   = document.getElementById('mpImg').getAttribute('src');
  var priceNum = parseFloat(price.replace('RM', '')) || 0;
  var menuId = currentCardId;

  // find existing item
  var existing = cartItems.find(function (i) { return i.title === title; });
  if (existing) {
    existing.qty += mpQty;
  } else {
    cartItems.push({ id: menuId, title: title, price: price, priceNum: priceNum, qty: mpQty, img: img });
  }

  this.innerHTML = '<i class="fas fa-check"></i> Added!';
  this.style.background = 'linear-gradient(135deg,var(--green),#1a4a35)';
  var self = this;
  setTimeout(function () {
    closeMenuPop();
    self.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
    self.style.background = '';
    renderCart(); // update badge count
  }, 900);
});

/* ===================== ESC KEY ===================== */
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') { closeMenuPop(); closeCart(); }
});

/* ===================== COUNTER ANIMATION ===================== */
var numAnimated = false;
window.addEventListener('scroll', function () {
  var hero = document.getElementById('hero');
  if (!numAnimated && hero && window.scrollY > hero.offsetHeight - 300) {
    numAnimated = true;
    document.querySelectorAll('.snum').forEach(function (el) {
      var txt = el.textContent;
      var num = parseInt(txt);
      var suf = txt.replace(/[0-9]/g, '');
      if (isNaN(num)) return;
      var start = 0, step = Math.ceil(num / 55);
      var iv = setInterval(function () {
        start += step;
        if (start >= num) { start = num; clearInterval(iv); }
        el.textContent = start + suf;
      }, 1400 / 55);
    });
  }
});
