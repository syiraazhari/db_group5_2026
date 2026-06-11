<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Order Food at NFC Now!</title>
      <link rel="icon" type="image" href="favicon.png">
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
      <link href="css/bootstrap.min.css" rel="stylesheet"/>
      <link href="css/aos.css" rel="stylesheet"/>
      <link rel="stylesheet" href="css/all.min.css"/>
      <link rel="stylesheet" href="css/style.css"/>
   </head>
   <body>

      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg" id="nav">
         <div class="container">
            <a class="navbar-brand" href="#">
               <img src="img/logo.png" alt="Logo" class="logo-img">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navmenu">
               <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
               <ul class="navbar-nav mx-auto">
                  <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                  <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
               </ul>
               <div class="d-flex align-items-center gap-3">
                  <a href="login.php" class="user-icon" id="navLoginBtn" title="Staff Login"><i class="fas fa-user-shield"></i></a>
                  <a href="#menu" class="nav-cta">Order Now</a>
               </div>
            </div>
         </div>
      </nav>

      <!-- HERO -->
      <section id="hero">
         <div class="hs hs1"></div>
         <div class="hs hs2"></div>
         <div class="hbgtxt">NFC</div>
         <div class="container">
            <div class="row align-items-center g-5" style="min-height:88vh;">
               <div class="col-lg-6">
                  <h1 class="htitle">Taste the <span class="hl">Legend,</span><br/>Love the Crunch</h1>
                  <p class="hdesc">Fresh ingredients, authentic flavours, and a warm atmosphere for every gathering.</p>
                  <div class="d-flex flex-wrap gap-3 mb-2">
                     <a href="#menu" class="btn-red"><i class="fas fa-utensils"></i>Explore Menu</a>
                  </div>
                  <div class="hstats d-flex gap-3 flex-wrap mt-4">
                     <div class="hstat"><span class="snum">10K<em>+</em></span><small>Outlets Worldwide</small></div>
                     <div class="sdiv"></div>
                     <div class="hstat"><span class="snum">500K<em>+</em></span><small>Happy Customers</small></div>
                     <div class="sdiv"></div>
                     <div class="hstat"><span class="snum">12<em>yrs</em></span><small>In Business</small></div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div style="position:relative;text-align:center;">
                     <div class="food-slider">
                        <div class="food-track">
                           <img src="img/slide1.png">
                           <img src="img/slide2.png">
                           <img src="img/slide3.png">
                           <img src="img/slide4.png">
                           <img src="img/slide1.png">
                           <img src="img/slide2.png">
                           <img src="img/slide3.png">
                           <img src="img/slide4.png">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- MARQUEE -->
      <div class="mqsec">
         <div class="mqtrack">
            <div class="mqitem"><i class="fas fa-circle"></i>Classic Chicken Burger</div>
            <div class="mqitem"><i class="fas fa-circle"></i>BBQ Chicken Burger</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Cheese Chicken Burger</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Spicy Fried Chicken</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Popcorn Chicken</div>
            <div class="mqitem"><i class="fas fa-circle"></i>2-Piece Fried Chicken</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Crispy Chicken Wrap</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Cheese Chicken Wrap</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Iced Lemon Tea</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Coca-Cola</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Sprite</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Vanilla Sundae</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Chocolate Brownie</div>
            <div class="mqitem"><i class="fas fa-circle"></i>Apple Pie</div>
         </div>
      </div>

      <!-- ABOUT -->
      <section id="about">
         <div class="container">
            <div class="row align-items-center g-5">
               <div class="col-lg-5" data-aos="fade-right">
                  <div class="astack">
                     <div class="aexp"><span class="anum">12</span><small>Years of<br/>Excellence</small></div>
                     <div class="amain"><img src="img/nfc_about.jpg" alt="Restaurant"/></div>
                     <div class="asm"><img src="img/burger_about.jpg" alt="Food"/></div>
                  </div>
               </div>
               <div class="col-lg-7" data-aos="fade-left">
                  <span class="slbl">Our History</span>
                  <h2 class="stitle text-start">Welcome to<br/> <span>Nandawgs Fried Chicken</span></h2>
                  <div class="sline lft"></div>
                  <p class="sdesc mb-4">Nandawgs Fried Chicken (NFC) - was founded in 2014, NFC began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all.</p>
                  <div class="mb-4">
                     <div class="fti">
                        <div class="ftico r"><i class="fas fa-leaf"></i></div>
                        <div>
                           <h6>100% Fresh Ingredients</h6>
                           <p>We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness.</p>
                        </div>
                     </div>
                     <div class="fti">
                        <div class="ftico y"><i class="fas fa-award"></i></div>
                        <div>
                           <h6>Award-Winning Recipes</h6>
                           <p>Our signature recipes have won national culinary awards 5 years in a row.</p>
                        </div>
                     </div>
                  </div>
                  <a href="#menu" class="btn-red"><i class="fas fa-book-open"></i>View Full Menu</a>
               </div>
            </div>
         </div>
      </section>

      <!-- MENU -->
      <section id="menu">
         <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
               <span class="slbl">What's Cooking</span>
               <h2 class="stitle">Our Delicious <span>Menu</span></h2>
               <div class="sline"></div>
            </div>
            <div class="text-center mb-4" data-aos="fade-up">
               <button class="filtbtn active" data-f="all">All</button>
               <button class="filtbtn" data-f="burgers">Burgers</button>
               <button class="filtbtn" data-f="chicken">Chicken</button>
               <button class="filtbtn" data-f="wraps">Wraps</button>
               <button class="filtbtn" data-f="beverages">Beverages</button>
            </div>
            <div class="row g-4" id="mgrid">

               <!-- Burgers -->
               <div class="col-sm-6 col-lg-4 mwrap" data-c="burgers" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/classic_burger.jpg" data-title="Classic Chicken Burger" data-cat="Burgers" data-price="RM8.90" data-old="RM12.90" data-desc="Crispy chicken fillet served with fresh lettuce and mayonnaise.">
                     <div class="mimg">
                        <img src="img/menu/classic_burger.jpg" alt="Classic Chicken Burger"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Burgers</div>
                        <div class="mtit">Classic Chicken Burger</div>
                        <div class="mdesc">Crispy fillet served with mayonnaise.</div>
                        <div class="mfoot">
                           <div class="mprice">RM8.90 <small>RM12.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="burgers" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/spicy_burger.jpg" data-title="Spicy Chicken Burger" data-cat="Burgers" data-price="RM9.90" data-old="RM13.90" data-desc="Crispy spicy fillet topped with mayonnaise.">
                     <div class="mimg">
                        <img src="img/menu/spicy_burger.jpg" alt="Spicy Chicken Burger"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Burgers</div>
                        <div class="mtit">Spicy Chicken Burger</div>
                        <div class="mdesc">Crispy spicy fillet topped with mayonnaise.</div>
                        <div class="mfoot">
                           <div class="mprice">RM9.90 <small>RM13.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="burgers" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/cheese_burger.jpg" data-title="Cheese Chicken Burger" data-cat="Burgers" data-price="RM10.90" data-old="RM14.90" data-desc="Crispy fillet topped with melted cheese.">
                     <div class="mimg">
                        <img src="img/menu/cheese_burger.jpg" alt="Cheese Chicken Burger"/>
                        <div class="mbdg hot"><i class="fas fa-star"></i> Hot</div>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Burgers</div>
                        <div class="mtit">Cheese Chicken Burger</div>
                        <div class="mdesc">Crispy fillet topped with melted cheese.</div>
                        <div class="mfoot">
                           <div class="mprice">RM10.90 <small>RM14.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="burgers" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/bbq_burger.jpg" data-title="BBQ Chicken Burger" data-cat="Burgers" data-price="RM11.90" data-old="RM15.90" data-desc="Crispy chicken fillet coated with smoky BBQ sauce and lettuce.">
                     <div class="mimg">
                        <img src="img/menu/bbq_burger.jpg" alt="BBQ Chicken Burger"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Burgers</div>
                        <div class="mtit">BBQ Chicken Burger</div>
                        <div class="mdesc">Crispy fillet coated with smoky BBQ sauce.</div>
                        <div class="mfoot">
                           <div class="mprice">RM11.90 <small>RM15.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Chicken -->
               <div class="col-sm-6 col-lg-4 mwrap" data-c="chicken" data-aos="fade-up" data-aos-delay="160">
                  <div class="mcard" data-img="img/menu/chicken_2pc.jpg" data-title="2-pc Fried Chicken" data-cat="Chicken" data-price="RM12.90" data-old="RM16.90" data-desc="Two pieces of crispy golden fried chicken.">
                     <div class="mimg">
                        <img src="img/menu/chicken_2pc.jpg" alt="2-pc Fried Chicken"/>
                        <div class="mbdg"><i class="fas fa-star"></i> Best Seller</div>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Chicken</div>
                        <div class="mtit">2-pc Fried Chicken</div>
                        <div class="mdesc">Two pieces of crispy golden fried chicken.</div>
                        <div class="mfoot">
                           <div class="mprice">RM12.90 <small>RM16.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="chicken" data-aos="fade-up" data-aos-delay="160">
                  <div class="mcard" data-img="img/menu/chicken_3pc.jpg" data-title="3-pc Fried Chicken" data-cat="Chicken" data-price="RM16.90" data-old="RM20.90" data-desc="Three pieces of crispy golden fried chicken.">
                     <div class="mimg">
                        <img src="img/menu/chicken_3pc.jpg" alt="3-pc Fried Chicken"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Chicken</div>
                        <div class="mtit">3-pc Fried Chicken</div>
                        <div class="mdesc">Three pieces of crispy golden fried chicken.</div>
                        <div class="mfoot">
                           <div class="mprice">RM16.90 <small>RM20.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="chicken" data-aos="fade-up" data-aos-delay="160">
                  <div class="mcard" data-img="img/menu/chicken_spicy.jpg" data-title="Spicy Fried Chicken" data-cat="Chicken" data-price="RM13.90" data-old="RM17.90" data-desc="Crispy fried chicken seasoned with spicy herbs and spices.">
                     <div class="mimg">
                        <img src="img/menu/chicken_spicy.jpg" alt="Spicy Fried Chicken"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Chicken</div>
                        <div class="mtit">Spicy Fried Chicken</div>
                        <div class="mdesc">Crispy fried chicken seasoned with spicy herbs and spices.</div>
                        <div class="mfoot">
                           <div class="mprice">RM13.90 <small>RM17.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="chicken" data-aos="fade-up" data-aos-delay="160">
                  <div class="mcard" data-img="img/menu/popcorn_chicken.jpg" data-title="Popcorn Chicken" data-cat="Chicken" data-price="RM8.90" data-old="RM12.90" data-desc="Bite-sized crispy chicken pieces seasoned with flavorful spices.">
                     <div class="mimg">
                        <img src="img/menu/popcorn_chicken.jpg" alt="Popcorn Chicken"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Chicken</div>
                        <div class="mtit">Popcorn Chicken</div>
                        <div class="mdesc">Bite-sized chicken pieces seasoned with spices.</div>
                        <div class="mfoot">
                           <div class="mprice">RM8.90 <small>RM12.90</small></div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Wraps -->
               <div class="col-sm-6 col-lg-4 mwrap" data-c="wraps" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/crispy_wrap.jpg" data-title="Crispy Chicken Wrap" data-cat="Wraps" data-price="RM9.90" data-old="" data-desc="Crispy chicken wrapped with fresh vegetables and sauce.">
                     <div class="mimg">
                        <img src="img/menu/crispy_wrap.jpg" alt="Crispy Chicken Wrap"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Wraps</div>
                        <div class="mtit">Crispy Chicken Wrap</div>
                        <div class="mdesc">Crispy chicken with fresh vegetables and sauce.</div>
                        <div class="mfoot">
                           <div class="mprice">RM9.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="wraps" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/spicy_wrap.jpg" data-title="Spicy Chicken Wrap" data-cat="Wraps" data-price="RM10.90" data-old="" data-desc="Spicy crispy chicken wrapped with lettuce and sauce.">
                     <div class="mimg">
                        <img src="img/menu/spicy_wrap.jpg" alt="Spicy Chicken Wrap"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Wraps</div>
                        <div class="mtit">Spicy Chicken Wrap</div>
                        <div class="mdesc">Spicy crispy chicken with lettuce and sauce.</div>
                        <div class="mfoot">
                           <div class="mprice">RM10.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="wraps" data-aos="fade-up">
                  <div class="mcard" data-img="img/menu/cheese_wrap.jpg" data-title="Cheese Chicken Wrap" data-cat="Wraps" data-price="RM11.90" data-old="" data-desc="Chicken wrapped with fresh vegetables and melted cheese.">
                     <div class="mimg">
                        <img src="img/menu/cheese_wrap.jpg" alt="Cheese Chicken Wrap"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Wraps</div>
                        <div class="mtit">Cheese Chicken Wrap</div>
                        <div class="mdesc">Chicken with fresh vegetables and melted cheese.</div>
                        <div class="mfoot">
                           <div class="mprice">RM11.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Beverages -->
               <div class="col-sm-6 col-lg-4 mwrap" data-c="beverages" data-aos="fade-up" data-aos-delay="80">
                  <div class="mcard" data-img="img/menu/cola.jpg" data-title="Coca-Cola" data-cat="Beverages" data-price="RM3.90" data-old="" data-desc="Iconic refreshing carbonated soft drink served chilled.">
                     <div class="mimg">
                        <img src="img/menu/cola.jpg" alt="Coca-Cola"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Beverages</div>
                        <div class="mtit">Coca-Cola</div>
                        <div class="mdesc">Iconic refreshing carbonated soft drink.</div>
                        <div class="mfoot">
                           <div class="mprice">RM3.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="beverages" data-aos="fade-up" data-aos-delay="80">
                  <div class="mcard" data-img="img/menu/sprite.jpg" data-title="Sprite" data-cat="Beverages" data-price="RM3.90" data-old="" data-desc="Famous lemon-lime flavored soft drink served chilled.">
                     <div class="mimg">
                        <img src="img/menu/sprite.jpg" alt="Sprite"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Beverages</div>
                        <div class="mtit">Sprite</div>
                        <div class="mdesc">Famous lemon-lime flavored soft drink.</div>
                        <div class="mfoot">
                           <div class="mprice">RM3.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="beverages" data-aos="fade-up" data-aos-delay="80">
                  <div class="mcard" data-img="img/menu/lemon_tea.jpg" data-title="Iced Lemon Tea" data-cat="Beverages" data-price="RM4.90" data-old="" data-desc="Refreshing tea blended with a hint of lemon flavor.">
                     <div class="mimg">
                        <img src="img/menu/lemon_tea.jpg" alt="Iced Lemon Tea"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Beverages</div>
                        <div class="mtit">Iced Lemon Tea</div>
                        <div class="mdesc">Refreshing tea with a hint of lemon.</div>
                        <div class="mfoot">
                           <div class="mprice">RM4.90</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-lg-4 mwrap" data-c="beverages" data-aos="fade-up" data-aos-delay="80">
                  <div class="mcard" data-img="img/menu/mineral.jpg" data-title="Mineral Water" data-cat="Beverages" data-price="RM2.50" data-old="" data-desc="Pure bottled drinking water.">
                     <div class="mimg">
                        <img src="img/menu/mineral.jpg" alt="Mineral Water"/>
                        <div class="mhrt"><i class="far fa-heart"></i></div>
                     </div>
                     <div class="mbody">
                        <div class="mcat">Beverages</div>
                        <div class="mtit">Mineral Water</div>
                        <div class="mdesc">Pure bottled drinking water.</div>
                        <div class="mfoot">
                           <div class="mprice">RM2.50</div>
                           <button class="madd" title="View Details"><i class="fas fa-plus"></i></button>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
            <!-- FIX 6: "View Full Menu" button removed -->
         </div>
      </section>

      <!-- MENU DETAIL POPUP -->
      <div id="menuPop">
         <div class="mpbox">
            <button class="mpclose" id="mpClose"><i class="fas fa-times"></i></button>
            <div class="mpimg"><img id="mpImg" src="" alt=""/></div>
            <div class="mpbody">
               <div id="mpCat"></div>
               <div id="mpTitle"></div>
               <!-- FIX 2: mpStars and mpMeta kept in DOM but hidden via CSS so JS doesn't error -->
               <div id="mpStars" style="display:none;"></div>
               <div id="mpDesc"></div>
               <div id="mpPrice"></div>
               <div class="mpmeta" id="mpMeta" style="display:none;"></div>
               <div class="mpqty">
                  <button class="mpqbtn" id="mpMinus">-</button>
                  <span class="mpqnum" id="mpQnum">1</span>
                  <button class="mpqbtn" id="mpPlus">+</button>
                  <span style="font-size:.82rem;color:#aaa;margin-left:9px;">portion</span>
               </div>
               <div class="mptags" id="mpTags"></div>
               <button class="mpaddcart" id="mpAddCart"><i class="fas fa-shopping-cart"></i>Add to Cart</button>
            </div>
         </div>
      </div>

      <!-- CART POPUP -->
      <div id="cartPop">
         <div class="cartbox">
            <div class="cartbox-header">
               <h5><i class="fas fa-shopping-cart me-2"></i>My Cart</h5>
               <button class="cartclose" id="cartClose"><i class="fas fa-times"></i></button>
            </div>
            <div class="cartbox-items" id="cartItems">
               <div class="cart-empty" id="cartEmpty">
                  <i class="fas fa-shopping-basket"></i>
                  <p>Your cart is empty</p>
               </div>
            </div>
            <div class="cartbox-footer" id="cartFooter" style="display:none;">
               <div class="cart-total">
                  <span>Total</span>
                  <span class="cart-total-amt" id="cartTotal">RM0.00</span>
               </div>
               <button class="cart-checkout-btn" id="cartCheckout" onclick="handleCheckout()">
                  <i class="fas fa-lock"></i>Proceed to Checkout
               </button>
            </div>
         </div>
      </div>

      <!-- HOURS -->
      <section id="hours">
         <div class="hrsbg"></div>
         <div class="container" style="position:relative;z-index:2;">
            <div class="text-center mb-5" data-aos="fade-up">
               <span class="slbl" style="color:#ffe878;">Opening Hours</span>
               <h2 class="stitle" style="color:#fff;">We're Open <span style="color:var(--secondary);">For You</span></h2>
               <div class="sline"></div>
            </div>
            <div class="row g-4 align-items-start justify-content-center">
               <div class="col-lg-5" data-aos="fade-right">
                  <div class="hrscard">
                     <div class="hrsrow">
                        <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Monday - Tuesday</span>
                        <div class="d-flex align-items-center gap-2">
                           <div class="hdot off"></div>
                           <span class="hrstime" style="color:#ff6b6b;">Closed</span>
                        </div>
                     </div>
                     <div class="hrsrow">
                        <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Wednesday - Thursday</span>
                        <div class="d-flex align-items-center gap-2">
                           <div class="hdot on"></div>
                           <span class="hrstime">09:00 AM - 10:00 PM</span>
                        </div>
                     </div>
                     <div class="hrsrow">
                        <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Friday</span>
                        <div class="d-flex align-items-center gap-2">
                           <div class="hdot on"></div>
                           <span class="hrstime">09:00 AM - 11:00 PM</span>
                        </div>
                     </div>
                     <div class="hrsrow">
                        <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Saturday</span>
                        <div class="d-flex align-items-center gap-2">
                           <div class="hdot on"></div>
                           <span class="hrstime">10:00 AM - 11:30 PM</span>
                        </div>
                     </div>
                     <div class="hrsrow">
                        <span class="hrsday"><i class="fas fa-calendar-day me-2" style="color:var(--secondary);"></i>Sunday</span>
                        <div class="d-flex align-items-center gap-2">
                           <div class="hdot on"></div>
                           <span class="hrstime">11:00 AM - 09:00 PM</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- FOOTER — FIX 5: centered, desserts removed -->
      <footer>
         <div class="container">
            <div class="row g-5 justify-content-center text-center">
               <div class="col-lg-4">
                  <div class="fnm">N<span>FC</span></div>
                  <p class="fdesc">We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love.</p>
               </div>
               <div class="col-sm-6 col-lg-2">
                  <div class="ftit">Quick Links</div>
                  <ul class="flinks ps-0">
                     <li><a href="#hero"><i class="fas fa-chevron-right"></i>Home</a></li>
                     <li><a href="#about"><i class="fas fa-chevron-right"></i>About Us</a></li>
                     <li><a href="#menu"><i class="fas fa-chevron-right"></i>Our Menu</a></li>
                  </ul>
               </div>
               <div class="col-sm-6 col-lg-2">
                  <div class="ftit">Our Menu</div>
                  <ul class="flinks ps-0">
                     <li><a href="#menu"><i class="fas fa-chevron-right"></i>Burgers</a></li>
                     <li><a href="#menu"><i class="fas fa-chevron-right"></i>Chicken</a></li>
                     <li><a href="#menu"><i class="fas fa-chevron-right"></i>Wraps</a></li>
                     <li><a href="#menu"><i class="fas fa-chevron-right"></i>Beverages</a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="fbot">
            <div class="container">
               <div class="text-center">
                  <p>&copy; 2026 <span>Nandawgs Fried Chicken</span>. Made with <span><i class="fas fa-heart"></i></span><br>Distributed by Group 4(WP) / 5(DB)</p>
               </div>
            </div>
         </div>
      </footer>

      <!-- Floating cart -->
      <div class="cartfl" id="cartFlBtn">
         <i class="fas fa-shopping-cart"></i><span>My Cart</span>
         <div class="ccount" id="cartCount">0</div>
      </div>

      <!-- Back to top -->
      <button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-chevron-up"></i></button>

      <script src="js/jquery-3.7.1.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/main.js"></script>
   </body>
</html>
