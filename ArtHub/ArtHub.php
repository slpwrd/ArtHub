<?php
session_start();
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ArtHub</title>
    <link rel="stylesheet" href="MainStyle.css" />
    <style>
      .nav-links li a img.avatar {
        border-radius: 50%;
        width: 60px !important;
        height: 60px !important;
        object-fit: cover; 
      }

      .nav-links {
        font-family: "BIZ UDPMincho", serif;
        font-size: 18px;
        font-weight: bold;
        list-style: none;
        display: flex;
        gap: 20px;
        margin-left: 65%;
        align-items: center; /* Центрирование по вертикали */
      }

      .nav-links li {
        display: flex;
        align-items: center; /* Центрирование по вертикали */
      }

      .nav-links li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        position: relative;
        white-space: nowrap;
        display: flex;
        align-items: center; /* Центрирование по вертикали */
      }

      .nav-links li a::after {
        content: "";
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #12a73e;
        transform: scaleX(0);
        transition: transform 0.3s ease-in-out;
      }

      .nav-links li a:hover::after {
        transform: scaleX(1);
      }

      .profile-section {
    position: relative;
    display: flex;
    align-items: center;
    gap: 15px; /* Расстояние между кнопкой и аватаркой */
}

.admin-menu-btn {
    color: #12a73e;
    font-weight: bold;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 4px;
    transition: all 0.3s;
    margin-right: 10px;
}

.admin-menu-btn:hover {
    background: #f0f0f0;
    color: #0e8a31;
}

.admin-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 4px;
    padding: 10px;
    z-index: 1000;
    min-width: 200px;
}

.admin-menu a {
    display: block;
    padding: 8px 15px;
    color: #333;
    text-decoration: none;
    white-space: nowrap;
}

.admin-menu a:hover {
    background: #f5f5f5;
}
    </style>
<script>
// Обновлённый скрипт с обработкой события
function toggleAdminMenu(event) {
    event.preventDefault();
    const menu = document.getElementById('adminMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Закрытие при клике вне меню
document.addEventListener('click', (event) => {
    const menu = document.getElementById('adminMenu');
    const btn = document.querySelector('.admin-menu-btn');
    
    if (!menu.contains(event.target) && 
        !btn.contains(event.target) &&
        menu.style.display === 'block') {
        menu.style.display = 'none';
    }
});
</script>

  </head>
  <body>
  <header>
    <div class="logo">
        <img src="Media/Logo/ArthubLogo.png" alt="ArtHub Logo">
    </div>
    <div class="container">
        <nav>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Explore</a></li>
                <li><a href="#">About Us</a></li>
                <?php if (isset($_SESSION['UserID'])): ?>
                    <li class="profile-section">
                        <?php if (isset($_SESSION['RoleID']) && $_SESSION['RoleID'] === 'Admin'): ?>
                            <a href="#" class="admin-menu-btn" onclick="toggleAdminMenu(event)">
                                Admin
                            </a>
                        <?php endif; ?>

                        <a href="./profile.php">
                            <img
                                src="<?php echo isset($_SESSION['UserImagePath']) && file_exists($_SESSION['UserImagePath']) ? $_SESSION['UserImagePath'] : './uploads/defaultavatar.png'; ?>"
                                alt="Profile"
                                class="avatar"
                            />
                        </a>

                        <?php if (isset($_SESSION['RoleID']) && $_SESSION['RoleID'] === 'Admin'): ?>
                            <div id="adminMenu" class="admin-menu">
                                <a >Control panel</a>
                                <a href="./usermanagement.php">User management</a>
                                <a >Content moderation</a>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="login.php" class="login-button">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

    <section class="hero">
      <div class="container">
        <h1>Welcome to ArtHub!</h1>
      </div>
    </section>

    <section class="categories">
      <h2>Categories <span class="more">more ></span></h2>
      <div class="container">
        <div class="category-grid">
          <div class="category-card">
            <img src="Media/Categories/ArtMuseums.jpg" alt="Art Museums" />
            <p>Art Museums</p>
          </div>
          <div class="category-card">
            <img
              src="Media/Categories/SculptureMuseums.jpg"
              alt="Sculpture Museums"
            />
            <p>Sculpture Museums</p>
          </div>
          <div class="category-card">
            <img
              src="Media/Categories/DigitalArtMuseums.jpg"
              alt="Digital Art Museums"
            />
            <p>Digital Art Museums</p>
          </div>
          <div class="category-card">
            <img
              src="Media/Categories/VintageMuseums.jpg"
              alt="Vintage Museums"
            />
            <p>Vintage Museums</p>
          </div>
          <div class="category-card">
            <img
              src="Media/Categories/HistoricalMuseums.jpg"
              alt="Historical Museums"
            />
            <p>Historical Museums</p>
          </div>
        </div>
      </div>
    </section>

    <section class="best-museums">
      <h2>Best Museums <span class="more">more ></span></h2>
      <div class="container">
        <div class="museum-section">
          <div class="museum-image">
            <img
              src="Media/Museums/Futurione.png"
              alt="FUTURIONE Modern Art Museum"
            />
          </div>
          <div class="museum-info">
            <div class="museum-details">
              <h3>FUTURIONE</h3>
              <p>Modern Art Museum</p>
              <div class="rating">
                <span>Rating:</span>
                <span>4.8</span>
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
              </div>
            </div>
            <div class="reviews">
              <div class="review">
                <img src="Media/Pfp/ExpoHunter.jpg" alt="ExpoHunter Avatar" />
                <div class="review-content">
                  <h4>ExpoHunter</h4>
                  <p>
                    Visited the FUTURIONE digital exhibition in Moscow, and it
                    was an incredible experience! The blend of art, technology,
                    and futuristic design truly immerses you in a world of
                    innovation. Each installation was interactive, visually
                    stunning, and thought-provoking, showcasing how digital art
                    can redefine creativity. A must-see for anyone interested in
                    the future of art and tech!
                  </p>
                </div>
                <div class="review-rating">
                  <span>5★</span>
                </div>
              </div>
              <div class="review">
                <img
                  src="Media/Pfp/MuseumFanatic.jpg"
                  alt="MuseumFanatic Avatar"
                />
                <div class="review-content">
                  <h4>MuseumFanatic</h4>
                  <p>
                    The perfect platform for art lovers! Exciting virtual tours
                    and detailed descriptions of exhibits. I was especially
                    pleased with the ability to create a selection of your
                    favorite museums. Perfect for inspiration!
                  </p>
                </div>
                <div class="review-rating">
                  <span>4★</span>
                </div>
              </div>
            </div>
            <button class="more-button">More</button>
          </div>
        </div>
      </div>
    </section>

    <section class="museum-album">
      <h2>FUTURIONE album:</h2>
      <div class="album-container">
        <div class="album-image">
          <img
            src="Media/Museums/4ea3b10c4c12e7ce787e379dd1e8059c.jpg"
            alt="Image 1"
          />
        </div>
        <div class="album-image">
          <img
            src="Media/Museums/900f00b9-f59d-40c6-b101-8bdc95346a0a.jpg"
            alt="Image 2"
          />
        </div>
        <div class="album-image">
          <img src="Media/Museums/159199_original.jpg" alt="Image 3" />
        </div>
        <div class="album-image">
          <img src="Media/Museums/QNUP7uyay2g.jpg" alt="Image 4" />
        </div>
      </div>
      <div class="pagination">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </section>

    <footer class="site-footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-left">
            <img
              src="Media/Logo/logo.png"
              alt="ArtHub Logo"
              class="footer-logo"
            />
            <p>Blahblah ArtHub:</p>
            <ul class="social-links">
              <li>
                <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
              </li>
              <li>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
              </li>
              <li>
                <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
              </li>
            </ul>
          </div>
          <div class="footer-center">
            <p>
              This website is a thesis project and does not claim any commercial
              profit. All content presented here is for educational purposes
              only.
            </p>
          </div>
          <div class="footer-right">
            <p>Blahblah © 2025, ArtHub</p>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
