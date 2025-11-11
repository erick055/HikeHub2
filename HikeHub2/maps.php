<?php
session_start();

$loggedIn = isset($_SESSION['email']); 
$username = $_SESSION['name'] ?? "Guest";
// --- ADDED: Get pic path, use default if not logged in or no pic ---
$profile_picture_path = $_SESSION['profile_picture'] ?? 'img/default-avatar.png';

$exploreLink = $loggedIn ? 'explore.php' : 'aboutus.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HikeHub Cavite</title>
  <link rel="stylesheet" href="style/maps.css" />
  </head>
<body>
  <header>
    
     <a href="index.php" class="logo-link">
    <h1>🌄 HikeHub</h1>
  </a>
    <nav>
      <a href="maps.php"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z"/>
        </svg> 
        Maps</a>
      <a href="community.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
</svg>
         Community</a>
      <a href="partners.php"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
  <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
</svg>
        Partners</a>
      
    </nav>
    <div class="profile-pic">
     
        <a href="Sos.php" class="sos-button">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
          </svg>
        </a>

        <div class="profile">
            <a href="profile.php" class="profile-tag"><p class="name-profile"><?php echo htmlspecialchars($username); ?></p></a>
        </div>
        
        <a href="profile.php" class="header-profile-pic-container">
            <?php if ($loggedIn && isset($_SESSION['profile_picture']) && $_SESSION['profile_picture']): ?>
                <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile" class="header-profile-pic">
            <?php else: ?>
                <div class="prof-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </div>
            <?php endif; ?>
        </a>
       
        <a href="logout.php" class="logout-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>
        </a>
    </div>
   
  </header>
 <main>
    <div class="main-text">

    <h1> Interactive Maps</h1>
    <p>Exploring hiking trails in Cavite using GPS Navigation</p>
    </div>
    <div class="DS-bar">
      <div class="search-bar">🔍
        <input type="text" placeholder="Search" id="searchInput">
      </div>
      <div class="filter-but"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
  <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
</svg></div>
        <select class="difficulty-dropdown" id="difficultyFilter">
            <option value="" selected>Difficulty</option>
            <option value="easy">Easy</option>
            <option value="moderate">Moderate</option>
            <option value="intermediate">Intermediate</option>
        </select>
    </div>
    <div class="section-map">
      <div class="map-card">
            <div class="cards">
                            <div class="trail-card active" data-difficulty="moderate" id="card-pico">
                <div class="difficulty-tag moderate">Moderate</div>
                  <h3>Mt. Pico de loro</h3>
                 <div class="details">
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>
                    Ternate, Cavite
                  </p>
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/></svg>
                    664m elevation
                  </p>
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.582a32 32 0 0 1-2.206-2.578c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.877 3 6a5 5 0 0 1 10 0c0 .877-.304 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                8.5km distance
                  </p>
                </div>
                <p class="status open">OPEN</p>
                <a href="trail_details.php?id=1" class="card-footer-link"></a>
                <div class="card-footer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                </div>
              </div>
              
                            <div class="trail-card" data-difficulty="easy" id="card-palay">
                <div class="difficulty-tag easy">Easy</div>
                <h3>Mt. Palay-Palay</h3>
                <div class="details">
                  <p class="detail-item">
            _         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>
                    2-3 Hours
                  </p>
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/></svg>
                    620m elevation
                  </p>
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.582a32 32 0 0 1-2.206-2.578c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.877 3 6a5 5 0 0 1 10 0c0 .877-.304 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                    4.2km distance
                  </p>
                </div>
                <p class="status open">OPEN</p>
                <a href="trail_details.php?id=2" class="card-footer-link"></a>
                <div class="card-footer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                </div>
              </div>
              
                            <div class="trail-card" data-difficulty="moderate" id="card-talamitam">
                <div class="difficulty-tag moderate">Moderate</div>
                <h3>Mt. Talamitam</h3>
                <div class="details">
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>
                    3-4 Hours
                  </p>
                  <p class="detail-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/></svg>
                    620m elevation
                _ </p>
                  <p class="detail-item">
              _       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.582a32 32 0 0 1-2.206-2.578c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.877 3 6a5 5 0 0 1 10 0c0 .877-.304 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                    8.5km distance
                  </p>
                </div>
                <p class="status open">OPEN</p>
                <a href="trail_details.php?id=3" class="card-footer-link"></a>
                <div class="card-footer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                </div>
              </div>
              </div>
            </div>

        <div class="map" id="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15478.71881881518!2d120.62768313466496!3d14.214041748283626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0b1b11e8a4a3%3A0x614a9504c568010f!2sMt.%20Pico%20de%20Loro!5e0!3m2!1sen!2sph!4v1730302000000!5m2!1sen!2sph" 
                width="600" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
    </div>
 </main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Get the dropdown and all the trail cards
    const difficultyFilter = document.getElementById('difficultyFilter');
    const trailCards = document.querySelectorAll('.trail-card');

    // 2. Attach the event listener to the dropdown change
    difficultyFilter.addEventListener('change', (event) => {
        const selectedDifficulty = event.target.value;

        // 3. Loop through all cards to show/hide and flash them
        trailCards.forEach(card => {
            // Remove the 'flash' class first to reset the animation
            card.classList.remove('flash'); 
            
            const cardDifficulty = card.getAttribute('data-difficulty');

            if (selectedDifficulty === "" || cardDifficulty === selectedDifficulty) {
                // Show the card
                card.style.display = 'block';

                // If a specific difficulty is selected, add the 'flash' class
                // The setTimeout ensures the flash happens *after* the card is shown/unhidden
                if (selectedDifficulty !== "") {
                    // Force a reflow to restart the animation (hack for instant re-flash)
                    void card.offsetWidth; 
                    card.classList.add('flash');
                }
            } else {
                // Hide the card
                card.style.display = 'none';
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('map-container');
    const cards = document.querySelectorAll('.trail-card');

    // Define the embed URLs for each map
    const mapEmbeds = {
        'card-pico': 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15478.71881881518!2d120.62768313466496!3d14.214041748283626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0b1b11e8a4a3%3A0x614a9504c568010f!2sMt.%20Pico%20de%20Loro!5e0!3m2!1sen!2sph!4v1730302000000!5m2!1sen!2sph',
        'card-palay': 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15479.914107663246!2d120.65175213465803!3d14.192305748492043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0a32463b08e5%3A0x10d18e878408f653!2sMt%20Palay-Palay!5e0!3m2!1sen!2sph!4v1730302000001!5m2!1sen!2sph',
        'card-talamitam': 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15494.380877995188!2d120.8016421345437!3d13.96215164998816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd01ac9526c8b9%3A0xf6a7e04f056345e6!2sMt.%20Talamitam!5e0!3m2!1sen!2sph!4v1730302000002!5m2!1sen!2sph'
    };

    cards.forEach(card => {
        card.addEventListener('click', () => {
            // Get the map URL for the clicked card
            const mapSrc = mapEmbeds[card.id];
            if (!mapSrc) return; // Do nothing if card has no map

            // Remove 'active' class from all cards
            cards.forEach(c => c.classList.remove('active'));
            // Add 'active' class to the clicked card
            card.classList.add('active');

            // Create the new iframe
            const iframeHTML = `
                <iframe 
                    src="${mapSrc}" 
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>`;
            
            // Replace the map container's content with the new iframe
            mapContainer.innerHTML = iframeHTML;
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const allTrailCards = document.querySelectorAll('.trail-card');

    searchInput.addEventListener('input', (event) => {
        const searchTerm = event.target.value.toLowerCase().trim();

        allTrailCards.forEach(card => {
            const cardId = card.id.toLowerCase();
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();

            // Check if search term is in the ID (e.g., "pico") OR the title (e.g., "mt. pico de loro")
            if (cardId.includes(searchTerm) || cardTitle.includes(searchTerm)) {
                card.style.display = 'block'; // Show card
            } else {
                card.style.display = 'none'; // Hide card
            }
        });
    });
});
</script>

</body>
<footer></footer>
</html>