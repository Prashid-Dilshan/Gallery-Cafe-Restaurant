<?php

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "gallery_cafe";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_all = "SELECT photo_path, title, subtitle FROM banner_details";
$result_all = $conn->query($sql_all);


$sql_latest = "SELECT photo_path, title, subtitle FROM banner_details ORDER BY id DESC LIMIT 4";
$result_latest = $conn->query($sql_latest);

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Gallery Cafe Home Page</title>


  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">


  <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body id="top">




  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <h1>
        <a href="#" class="logo"> The Gallery Cafe <span class="span">.</span></a>
      </h1>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li class="nav-item">
            <a href="#home" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li class="nav-item">
            <a href="#about" class="navbar-link" data-nav-link>About Us</a>
          </li>

          <li class="nav-item">
            <a href="#food-menu" class="navbar-link" data-nav-link>Food Items</a>
          </li>

          <li class="nav-item">
            <a href="#Offers" class="navbar-link" data-nav-link>Offers</a>
          </li>

          <li class="nav-item">
            <a href="#blog" class="navbar-link" data-nav-link>Blog</a>
          </li>

          <li class="nav-item">
            <a href="#contact" class="navbar-link" data-nav-link>Contact Us</a>
          </li>

        </ul>
      </nav>

      <div class="header-btn-group">

        <a href="login.php"><button class="log-btn-hover" >Log in</button></a>

        <button class="nav-toggle-btn" aria-label="Toggle Menu" data-menu-toggle-btn>
          <span class="line top"></span>
          <span class="line middle"></span>
          <span class="line bottom"></span>
        </button>
      </div>

    </div>
  </header>









      <!-- 
        - #HERO
      -->

      <section class="hero" id="home" style="background-image: url('./assets/images/hero-bg.jpg')">
        <div class="container">

          <div class="hero-content">


            <h2 class="h1 hero-title">Supper delicious Foods in town!</h2>

            <p class="hero-text">We do not cook, we create your emotions!</p>

          </div>

          <figure class="hero-banner">
            <img src="./assets/images/hero-banner-bg.png" width="820" height="716" alt="" aria-hidden="true"
              class="w-100 hero-img-bg">

            <img src="./assets/images/hero-banner.png" width="700" height="637" loading="lazy" alt="Burger"
              class="w-100 hero-img">
          </figure>

        </div>
      </section>









      <!-- 
        - #ABOUT
      -->

      <section class="section section-divider gray about" id="about">
        <div class="container">

          <div class="about-banner">
            <img src="./assets/images/about.jpg" width="509" height="459" loading="lazy" alt="Burger with Drinks"
              class="w-100 about-img">

              
          </div>

          <div class="about-content">

            <h2 class="h2 section-title">
              The Gallery Cafe, Culinary Delights and Artistic Vibes
              <span class="span">in Town!</span>
            </h2>

            <p class="section-text">
              The Gallery Cafe in Sri Lanka serves as a vibrant cultural hub, reflecting the island's rich and diverse culinary traditions. It caters to a wide array of patrons, including both locals and travelers seeking unique dining experiences. The cafe is a family-run establishment, where traditional recipes and culinary techniques are lovingly passed down through generations. This familial touch not only preserves the authenticity of Sri Lankan cuisine but also creates a warm and inviting atmosphere, making every visit to The Gallery Cafe a memorable and hospitable experience.
            </p>

            <ul class="about-list">

              <li class="about-item">
                <ion-icon name="checkmark-outline"></ion-icon>

                <span class="span">Delicious & Healthy Foods</span>
              </li>

              <li class="about-item">
                <ion-icon name="checkmark-outline"></ion-icon>

                <span class="span">Spacific Family And Kids Zone</span>
              </li>

              <li class="about-item">
                <ion-icon name="checkmark-outline"></ion-icon>

                <span class="span">Music & Other Facilities</span>
              </li>

              <li class="about-item">
                <ion-icon name="checkmark-outline"></ion-icon>

                <span class="span">Fastest Food Home Delivery</span>
              </li>

            </ul>
          </div>
        </div>
      </section>








      <!-- 
        - #FOOD MENU
      -->

      <section class="section food-menu" id="food-menu">
        <div class="container">

          <p class="section-subtitle">Popular Dishes</p>

          <h2 class="h2 section-title">
            Our Delicious <span class="span">Foods</span>
          </h2>

          <p class="section-text">
            "Check out our delicious foods! At Gallery Cafe, we offer an array of tasty treats and beverages. Whether you're in the mood for a rich, aromatic coffee or a freshly baked pastry, we have something to satisfy every craving. Come and enjoy our culinary delights in a cozy and artistic setting!"
          </p>
                </div>

           <a href="Food.php" id="food-btn"><button>See Here</button></a>

      </section>







 <!-- 
    - #BANNER
-->

<section class="section section-divider gray banner" id="Offers">
<h1>Weekly Offers</h1>  
    <div class="container">

        
        <ul class="banner-list">
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gallery_cafe";


            $conn = new mysqli($servername, $username, $password, $dbname);


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            $sql = "SELECT photo_path, title, subtitle FROM banner_details ORDER BY id DESC LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $count = 0;
                while($row = $result->fetch_assoc()) {
                    $bannerClass = "";
                    if ($count == 0) {
                        $bannerClass = "banner-lg";
                    } elseif ($count == 1 || $count == 2) {
                        $bannerClass = "banner-sm";
                    } elseif ($count == 3) {
                        $bannerClass = "banner-md";
                    }

                    echo '<li class="banner-item ' . $bannerClass . '">
                            <div class="banner-card">
                                <img src="' . $row["photo_path"] . '" alt="' . $row["title"] . '" class="banner-img">
                                <div class="banner-item-content">
                                    <h3 class="banner-title">' . $row["title"] . '</h3>
                                    <p class="banner-subtitle">' . $row["subtitle"] . '</p>
    <a href="login.php"><button id="oder-now-btn">Oder Now</button></a>

                                </div>
                            </div>
                          </li>';

                    $count++;
                }
            } else {
                echo "<p>No banners found.</p>";
            }

            // Close connection
            $conn->close();
            ?>
        </ul>
    </div>
</section>










      <!-- 
        - #DELIVERY
      -->

      <section class="section section-divider gray delivery" id="delevery">
        <div class="container">

          <div class="delivery-content">

            <h2 class="h2 section-title">
              A Moments Of Delivered On <span class="span">Right Time</span> & Place
            </h2>

            <p class="section-text">
              Experience the convenience of gourmet dining from the comfort of your home with our exceptional delivery service. Our dedicated team ensures that every meal arrives at your door fresh, hot, and ready to enjoy. From our signature dishes to daily specials, we bring the same high-quality ingredients and culinary excellence directly to you. With easy online ordering, prompt delivery, and a commitment to customer satisfaction, enjoying your favorite meals has never been easier. Indulge in a seamless dining experience without leaving your house
            </p>

            <a href="login.php"> <button class="btn btn-hover">Join with us Order Now</button></a>
          </div>

          <figure class="delivery-banner">
            <img src="./assets/images/delivery-banner-bg.png" width="700" height="602" loading="lazy" alt="clouds"
              class="w-100">

            <img src="./assets/images/delivery-boy.svg" width="1000" height="880" loading="lazy" alt="delivery boy"
              class="w-100 delivery-img" data-delivery-boy>
          </figure>

        </div>
      </section>


      <!-- 
        - #Hire Tbales
      -->

      <section class="section section-divider gray delivery" id="table">
        <div class="container">

          <div class="table-content">

            <h2 class="h2 section-title">
              Hire your own<br> <span class="span">Tables  </span>
            </h2>

            <p class="section-text">
            At Gallery Cafe, we understand the importance of comfort and ambiance while you enjoy your meal. That's why we offer convenient table reservations to ensure you have the perfect spot for your dining experience. Whether you're planning a cozy dinner for two, a family gathering, or a business meeting, our reservation system makes it easy to secure your preferred table. Simply select your desired date, time, and table, and let us take care of the rest. Our welcoming staff and delightful atmosphere await you, providing an unforgettable dining experience tailored to your needs.
            </p>

            <a href="login.php"><button class="btn btn-hover">Join With Us Hire Now</button></a>
          </div>

          <figure class="table-banner">
          
            <img src="./assets/images/table.jpg" width="1200" height="1000" loading="lazy" alt="delivery boy"
              class="w-100 delivery-img" data-delivery-boy>
          </figure>

        </div>
      </section>

      
      <!-- 
        -#Park
      -->

      <section class="section section-divider gray delivery" id="park">
        <div class="container">

          <div class="park-content">

            <h2 class="h2 section-title">
              Park Reservation
            </h2>

            <p class="section-text">
            Gallery Cafe extends its hospitality beyond the dining room with our dedicated parking reservation service. We recognize that hassle-free parking is crucial for a seamless visit. Our park reservation system allows you to book a parking spot in advance, ensuring you have a convenient place to park when you arrive. Simply choose your date and time, and your reserved spot will be ready for you, making your visit to Gallery Cafe even more enjoyable. With our park reservation service, you can focus on savoring your meal and enjoying your time with us, knowing that your vehicle is securely parked.
            </p>

            <a href="login.php"><button class="btn btn-hover">Park Now</button></a>
          </div>

          <figure class="park-banner">
          
            <img src="./assets/images/park.avif" width="1200" height="1000" loading="lazy" alt=""
              class="w-100 park-img" data-delivery-boy>
          </figure>

        </div>
      </section>



      <!-- 
        - #BLOG
      -->

      <section class="section section-divider white blog" id="blog">
        <div class="container">

          <p class="section-subtitle">Latest Blog Posts</p>

          <h2 class="h2 section-title">
            This Is All About <span class="span">Foods</span>
          </h2>

          <p class="section-text" >
            Food is any substance consumed to provide nutritional support for an organism.
          </p>

          <ul class="blog-list">

            <li>
              <div class="blog-card">

                <div class="card-banner">
                  <img src="./assets/images/blog-1.jpg" width="600" height="390" loading="lazy"
                    alt="What Do You Think About Cheese Pizza Recipes?" class="w-100">

                  <div class="badge">Pizza</div>
                </div>

                <div class="card-content">

                  <div class="card-meta-wrapper">

                    <a href="#" class="card-meta-link">
                      <ion-icon name="calendar-outline"></ion-icon>

                      <time class="meta-info" datetime="2022-01-01">July 19 2024</time>
                    </a>

                    <a href="#" class="card-meta-link">
                      <ion-icon name="person-outline"></ion-icon>

                      <p class="meta-info">Prashid Dilshan</p>
                    </a>

                  </div>

                  <h3 class="h3">
                    <a href="https://preppykitchen.com/cheese-pizza/" class="card-title">What Do You Think About Cheese Pizza Recipes?</a>
                  </h3>

                  <p class="card-text">
                    Financial experts support or help you to to find out which way you can raise your funds more...
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                  
                
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </a>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <div class="card-banner">
                  <img src="./assets/images/blog-2.jpg" width="600" height="390" loading="lazy"
                    alt="Making Chicken Strips With New Delicious Ingridents." class="w-100">

                  <div class="badge">Sandwich</div>
                </div>

                <div class="card-content">

                  <div class="card-meta-wrapper">

                    <a href="#" class="card-meta-link">
                      <ion-icon name="calendar-outline"></ion-icon>

                      <time class="meta-info" datetime="2022-01-01">July 19 2024</time>
                    </a>

                    <a href="#" class="card-meta-link">
                      <ion-icon name="person-outline"></ion-icon>

                      <p class="meta-info">Prashid Dilshan</p>
                    </a>

                  </div>

                  <h3 class="h3">
                    <a href="https://www.bbcgoodfood.com/recipes/collection/sandwich-recipes" class="card-title">Making Sandwich With New Delicious Ingridents.</a>
                  </h3>

                  <p class="card-text">
                    Financial experts support or help you to to find out which way you can raise your funds more...
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </a>

                </div>

              </div>
            </li>

            <li>
              <div class="blog-card">

                <div class="card-banner">
                  <img src="./assets/images/blog-3.jpg" width="600" height="390" loading="lazy"
                    alt="Innovative Hot Chessyraw Pasta Make Creator Fact." class="w-100">

                  <div class="badge">Chicken</div>
                </div>

                <div class="card-content">

                  <div class="card-meta-wrapper">

                    <a href="#" class="card-meta-link">
                      <ion-icon name="calendar-outline"></ion-icon>

                      <time class="meta-info" datetime="2022-01-01">July 19 2024</time>
                    </a>

                    <a href="#" class="card-meta-link">
                      <ion-icon name="person-outline"></ion-icon>

                      <p class="meta-info">Prashid Dilshan</p>
                    </a>

                  </div>

                  <h3 class="h3">
                    <a href="https://www.budgetbytes.com/creamy-garlic-chicken/" class="card-title">New Delicious Chicken recipe.</a>
                  </h3>

                  <p class="card-text">
                    Financial experts support or help you to to find out which way you can raise your funds more...
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </a>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>





    </article>
  </main>

  
      <!-- 
        - #Reviews
      -->

      <section class="section section-divider white testi" id="rev">

        <div class="container">

          <h2 class="h2 section-title">
            Our Customers <span class="span">Reviews</span>
          </h2>

          <p class="section-text">
            Feel free to adjust it to better fit your specific needs or style!
          </p>

          <ul class="testi-list has-scrollbar">

            <li class="testi-item">
              <div class="testi-card">

                <div class="profile-wrapper">

                  <figure class="avatar">
                    <img src="./assets/images/avatar-1.jpg" width="80" height="80" loading="lazy" alt="Prashid Dilshan">
                  </figure>

                  <div>
                    <h3 class="h4 testi-name">Prashid Dilsahn</h3>

                    <p class="testi-title">CEO Of Shangri-La Hotel</p>
                  </div>

                </div>

                <blockquote class="testi-text">
                  "I love the eclectic vibe at Gallery Cafe! The artwork on the walls adds a unique touch to the whole experience. The baristas are friendly and knowledgeable about their coffee selection. I particularly enjoy their vegan options, which are surprisingly flavorful. Definitely recommend for both coffee lovers and art enthusiasts!"
                </blockquote>

                <div class="rating-wrapper">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

              </div>
            </li>

            <li class="testi-item">
              <div class="testi-card">

                <div class="profile-wrapper">

                  <figure class="avatar">
                    <img src="./assets/images/avatar-2.jpg" width="80" height="80" loading="lazy" alt="Mohomad Himaz">
                  </figure>

                  <div>
                    <h3 class="h4 testi-name">Mohomad Himaz</h3>

                    <p class="testi-title">CEO Of Araliya Resort & Spa </p>
                  </div>

                </div>

                <blockquote class="testi-text">
                  "I love the eclectic vibe at Gallery Cafe! The artwork on the walls adds a unique touch to the whole experience. The baristas are friendly and knowledgeable about their coffee selection. I particularly enjoy their vegan options, which are surprisingly flavorful. Definitely recommend for both coffee lovers and art enthusiasts!"
                </blockquote>

                <div class="rating-wrapper">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

              </div>
            </li>

            <li class="testi-item">
              <div class="testi-card">

                <div class="profile-wrapper">

                  <figure class="avatar">
                    <img src="./assets/images/avatar-3.jpg" width="80" height="80" loading="lazy" alt="Osura chandula">
                  </figure>

                  <div>
                    <h3 class="h4 testi-name">Osura chandula</h3>

                    <p class="testi-title">CEO Of Hilton Hotel</p>
                  </div>

                </div>

                <blockquote class="testi-text">
                  "A delightful find in the heart of the city! Gallery Cafe not only serves excellent coffee but also provides a great atmosphere for meetings or just hanging out. The service is prompt, and they even have gluten-free options, which is a huge plus for me. It's clear they care about quality and customer experience. Will be visiting again soon!"
                </blockquote>

                <div class="rating-wrapper">
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                  <ion-icon name="star"></ion-icon>
                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>



  <!-- 
    - #FOOTER
  -->


  <footer class="footer" id="contact">

<div class="footer-top" style="background-image: url('./assets/images/footer-illustration.png')">
<h1>Contact Us</h1>

  <div class="container">
    <div class="footer-brand">
      <a href="" class="logo">The Gallery Cafe<span class="span">.</span></a>
      <p class="footer-text">Supper delicious Foods in town!</p>
    </div>

    <ul class="footer-list">
      <li><p class="footer-list-title">Contact Info</p></li>
      <li><p class="footer-list-item">+94 0765683395</p></li>
      <li><p class="footer-list-item">prashiddilshan@gmail.com</p></li>
      <li><address class="footer-list-item">23 4/A, De Silva Road, Kalubowila, Dehiwala</address></li>
    </ul>

    <ul class="footer-list">
      <li><p class="footer-list-title">Opening Hours</p></li>
      <li><p class="footer-list-item">Monday-Friday: 08:00-23:00</p></li>
      <li><p class="footer-list-item">Tuesday 4PM: Till Mid Night</p></li>
      <li><p class="footer-list-item">Saturday: 10:00-16:00</p></li>
    </ul>

    <!--Location -->
    <div class="footer-map">
      <h2 style="color: orange; margin-bottom: 10px;">Gellery Cafe Location</h2>
    <iframe 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31729.061357317504!2d79.86343300482413!3d6.850887300203166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae247da7365e74f%3A0xd95e6757e1139c1e!2sDehiwala-Mount%20Lavinia%2C%20Sri%20Lanka!5e0!3m2!1sen!2sus!4v1690974919158!5m2!1sen!2sus" 
  width="400" 
  height="250" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy" 
  referrerpolicy="no-referrer-when-downgrade">
</iframe>


    </div>

  </div>
</div>

<div class="footer-bottom">
  <div class="container">
    <p class="copyright-text">
      &copy; 2024 <a href="#" class="copyright-link">Prashid Dilshan</a>
    </p>
  </div>
</div>
</footer>

  <script src="./assets/js/script.js" defer></script>


</body>

</html>