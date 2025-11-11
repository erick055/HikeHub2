<?php
session_start();

$host = "127.0.0.1:3307";
$user = "root";
$password = "";
$database = "users_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username from session directly
$loggedIn = isset($_SESSION['email']); 
$username = $_SESSION['name'] ?? "Guest";
// --- ADDED: Get pic path, use default if not logged in or no pic ---
$profile_picture_path = $_SESSION['profile_picture'] ?? 'img/default-avatar.png';

$conn->close();

if (!isset($_SESSION['email'])) {
    // Not logged in, redirect to login
    header("Location: login.php");
    exit();}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HikeHub Cavite</title>
  <link rel="stylesheet" href="styles.css" />
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
    <section class="welcome">
      <h1>Welcome to HikeHub!</h1>
      <p>Your digital companion for safe and memorable hiking adventures in beautiful Cavite Province.</p>
    </section>

    <section class="advisory">
      
      <h2>🌤️ Weather Advisory</h2>
    
    </section>

     
    <section class="weather">
     <h1>Current Weather</h1>
      <div class="overall-weather">
        <div class="cur-weather">
         <div class="cards">
           <div class="card1"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-thermometer-half" viewBox="0 0 16 16">
           <path d="M9.5 12.5a1.5 1.5 0 1 1-2-1.415V6.5a.5.5 0 0 1 1 0v4.585a1.5 1.5 0 0 1 1 1.415"/>
            <path d="M5.5 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0zM8 1a1.5 1.5 0 0 0-1.5 1.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0l-.166-.15V2.5A1.5 1.5 0 0 0 8 1"/>
              </svg></div>
                <div class="card2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-moisture" viewBox="0 0 16 16">
                    <path d="M13.5 0a.5.5 0 0 0 0 1H15v2.75h-.5a.5.5 0 0 0 0 1h.5V7.5h-1.5a.5.5 0 0 0 0 1H15v2.75h-.5a.5.5 0 0 0 0 1h.5V15h-1.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 .5-.5V.5a.5.5 0 0 0-.5-.5zM7 1.5l.364-.343a.5.5 0 0 0-.728 0l-.002.002-.006.007-.022.023-.08.088a29 29 0 0 0-1.274 1.517c-.769.983-1.714 2.325-2.385 3.727C2.368 7.564 2 8.682 2 9.733 2 12.614 4.212 15 7 15s5-2.386 5-5.267c0-1.05-.368-2.169-.867-3.212-.671-1.402-1.616-2.744-2.385-3.727a29 29 0 0 0-1.354-1.605l-.022-.023-.006-.007-.002-.001zm0 0-.364-.343zm-.016.766L7 2.247l.016.019c.24.274.572.667.944 1.144.611.781 1.32 1.776 1.901 2.827H4.14c.58-1.051 1.29-2.046 1.9-2.827.373-.477.706-.87.945-1.144zM3 9.733c0-.755.244-1.612.638-2.496h6.724c.395.884.638 1.741.638 2.496C11 12.117 9.182 14 7 14s-4-1.883-4-4.267"/>
                    </svg>
                    </div>
                      <div class="card3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wind" viewBox="0 0 16 16">
                        <path d="M12.5 2A2.5 2.5 0 0 0 10 4.5a.5.5 0 0 1-1 0A3.5 3.5 0 1 1 12.5 8H.5a.5.5 0 0 1 0-1h12a2.5 2.5 0 0 0 0-5m-7 1a1 1 0 0 0-1 1 .5.5 0 0 1-1 0 2 2 0 1 1 2 2h-5a.5.5 0 0 1 0-1h5a1 1 0 0 0 0-2M0 9.5A.5.5 0 0 1 .5 9h10.042a3 3 0 1 1-3 3 .5.5 0 0 1 1 0 2 2 0 1 0 2-2H.5a.5.5 0 0 1-.5-.5"/>
                        </svg>
           </div>
         </div>
        <ul>
          <li>
            <h2>Temperature:</h2>
          </li>
          <li>
            <h2>Humidity: </h2>
          </li>
          <li>
            <h2>Wind Speed: </h2>
          </li>
        </ul>
         </div>
        <div class="weather-card">
        <ul>
          <li><h2><span class="temp" >28°C</span></h2></li>
          <li><h2><span class="humid" >65%</span></h2></li>
          <li><h2><span class="wind" >12</span></h2></li>
        </ul>
        </div>
      </div>
    </section>
    <section class="trails">
      <h2>🏞️ Featured Trails</h2>
      <div class="trail-cards">
        <div class="card">
          <img src="img/pico.png" alt="Mt. Pico de Loro" />
          <h3>Mt. Pico de Loro</h3>
          <p><strong>Location:</strong> Maragondon, Cavite</p>
          <p>One of the most popular hiking destinations in Cavite, known for its iconic parrot's beak summit.</p>
          <p><strong>Difficulty:</strong> Intermediate</p>
          <p><strong>Length:</strong> 7.2 km</p>
          <p><strong>Estimated Time:</strong> 4–5 hours</p>
          <div class="card-pico"> 
            
             <button onclick="location.href='trail_details.php?id=1'">View Details!</button>
          
          </div>
         
        </div>
        <div class="card">
          <img src="img/palaypalay.png" alt="Mt. Palay-Palay" />
          <h3>Mt. Palay-Palay</h3>
          <p><strong>Location:</strong> Maragondon, Cavite</p>
          <p>A scenic trail with lush forests and diverse wildlife, perfect for nature enthusiasts.</p>
          <p><strong>Difficulty:</strong> Beginner</p>
          <p><strong>Length:</strong> 5.5 km</p>
          <p><strong>Estimated Time:</strong> 3–4 hours</p>
            <div class="card-pico"> 
            <button onclick="location.href='trail_details.php?id=2'">View Details!</button>
            </div>
        </div>
        <div class="card">
          <img src="img/talamits.png" alt="Mt. Talamitam" />
          <h3>Mt. Talamitam</h3>
          <p><strong>Location:</strong> Nasugbu, Batangas</p>
          <p>A relatively easy climb with open trails and a rewarding summit view.</p>
          <p><strong>Difficulty:</strong> Beginner</p>
          <p><strong>Length:</strong> 6 km</p>
          <p><strong>Estimated Time:</strong> 3–4 hours</p>
             <div class="card-pico"> 
            
            <button onclick="location.href='trail_details.php?id=3'">View Details!</button>
             </div>
        </div>
      </div>
    </section>
    <section class="safety">
      <h2>⚠️ Safety First</h2>
      <p>Before heading out, make sure to check trail conditions, pack essentials, and check weather conditions. HikeHub is not liable for any accidents or injuries.</p>
    </section>
  </main>


</body>
</html>
<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background-color: #f0f9f6;
  color: #2e4e3f;
  line-height: 1.6;
}

header {
  background-color: #2e8b57;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
}

.logo {
  font-size: 24px;
  font-weight: bold;
}

nav {
  display: flex;
  gap: 20px;
  align-items: center;
  padding-left: 1100px;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.profile {
  background-color: white;
  color: #2e8b57;
  padding: 0px 5px;
  
  border-radius: 5px;
  font-weight: bold;
  display: flex;
 align-items: center;
}

.profile-pic{
  display: flex;
  align-items: center;
  
}
.profile-pic .sos-button{

  display: flex;
  
  padding-right: 20px;
  color: inherit;
}
.prof-svg{
  padding-top: 5px;
  padding-left: 10px ;
  
}
main {
  padding: 30px;
}

.welcome h1 {
  font-size: 28px;
  color: #2e8b57;
  
}
.welcome{
  text-align: center;
  padding-bottom: 60px;
}
.weather, .trails, .safety {
  margin-top: 40px;
}
.overall-weather{

  display:flex;
  justify-content: space-between;
  
}
.weather{
  border: solid;
  border-radius: 20px;
  border-color: black;
  border-width: 1px;
  background-color: white;
  
}
.cur-weather{
  display: flex;
  
}
.cards{
  display: flex;
  flex-direction: column;
  
}

.cur-weather li{
  display: flex;
}
.cur-weather li h2{
  padding-left: 20px;
}

.weather ul {
  list-style: none;
  padding: 20px;
}
.weather h1 {
  padding-left: 20px;
}
.weather ul li {
  padding-bottom: 30px;
}
.cards{
  padding-left: 20px;
}
.card1{
  padding-top: 20px;
  padding-bottom: 10px;
}
.card2{
padding-bottom: 10px;
}


.trail-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.card {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 15px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%; 

}

.card img {
  width: 100%;
  border-radius: 8px;
  height: 260px;
}

.card h3 {
  margin-top: 10px;
  color: #2e8b57;
}

.safety {
  background-color: #fff3cd;
  padding: 20px;
  border-radius: 10px;
  border-left: 5px solid #ffc107;
}
.advisory{
  background-color: #eff6ff;
  padding: 20px;
  border-radius: 20px;
  border-left: 5px solid #69a0f7;
  border-right: 1px solid black;
  border-bottom: 1px solid black;
  border-top: 1px solid black;
}
.card .card-pico button{
    color: black;
    width: 100%;
    padding: 5px;
    background-color: #16a34a;
    border-radius: 5px;
    
  
}
.card .card-pico{
  
  display: flex;
  justify-content:center;
  padding-top: 20px;

}
.logout-btn {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 5px 5px;
  background-color: #ff4d4f;
  color: white;
  font-weight: bold;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  margin-left: 10px;
}

.logout-btn:hover {
  background-color: #d9363e;
}
.profile-tag{
  text-decoration: none;
  color: inherit;
}
.profile-tag .name-profile{
  color:inherit;
  margin:0;
  padding:0;
}

.logo-link {
text-decoration: none;     
color: inherit;            
display: flex;            
align-items: center;
 gap: 10px;                
 }

   .logo-link img {
  height: 40px;             
   }   
   header h1{
    font-size: 22px;
   }  
   .header-profile-pic {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 10px;
}
.prof-svg {
    padding-top: 5px;
    padding-left: 10px;
}
</style>

<script src="jquery-3.3.1.js"></script>
<script src="scripts/weather.js"></script>