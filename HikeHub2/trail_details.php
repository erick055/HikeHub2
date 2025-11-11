<?php
session_start();
require_once 'config.php'; // Include your database connection

// --- 1. GET USER INFO (for header) ---
$loggedIn = isset($_SESSION['email']); 
$username = $_SESSION['name'] ?? "Guest";
// --- ADDED: Get pic path, use default if not logged in or no pic ---
$profile_picture_path = $_SESSION['profile_picture'] ?? 'img/default-avatar.png';

// --- 2. GET TRAIL ID FROM URL ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // If no ID is provided, stop
    die("Error: Invalid Trail ID.");
}
$trail_id = (int)$_GET['id']; // Cast to integer for security

// --- 3. FETCH TRAIL DATA FROM DATABASE ---
$stmt = $conn->prepare("SELECT * FROM trails WHERE id = ?");
$stmt->bind_param("i", $trail_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // If ID doesn't exist in database, stop
    die("Error: Trail not found.");
}
// All good, fetch the data into $trail variable
$trail = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/details.css"> 
    <title><?php echo htmlspecialchars($trail['name']); ?> - HikeHub</title>
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
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0 4"/>
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
    <div class="prof-svg">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
          </svg>
      </div>
       
      <a href="logout.php" class="logout-btn">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
  </svg>
</a>

    </button>
    </div>
   
  </header>

    <main class="details-container">
        
        <div class="left-column">
            
            <div class="card trail-info-card">
                <img src="<?php echo htmlspecialchars($trail['image_path']); ?>" alt="<?php echo htmlspecialchars($trail['name']); ?>">
                <h2><?php echo htmlspecialchars($trail['name']); ?></h2>
                <p><?php echo htmlspecialchars($trail['location']); ?></p>
                <div class="stats">
                    <span>🕒 <?php echo htmlspecialchars($trail['time_hours']); ?></span>
                    <span>📏 <?php echo htmlspecialchars($trail['length_km']); ?> km distance</span>
                    <span class="difficulty-tag"><?php echo htmlspecialchars($trail['difficulty']); ?></span>
                </div>
            </div>

            <div class="card">
                <h3><span class="icon">📅</span> Set Date & Time</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <select id="time" name="time">
                            <option value="">Select Time</option>
                            <option value="06:00">6:00 AM</option>
                            <option value="07:00">7:00 AM</option>
                            <option value="08:00">8:00 AM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3><span class="icon">👨‍👩‍👧‍👦</span> Group Size</h3>
                <div class="group-size-selector">
                    <button class="stepper-btn" id="btn-minus">−</button>
                    <span class="group-size-number" id="group-size">1</span>
                    <button class="stepper-btn" id="btn-plus">+</button>
                </div>
                <p class="group-size-label">Maximum of 10 people</p>
            </div>

            <button class="book-now-btn">Book Now</button>

        </div>

        <div class="right-column" id="organization-panel">
            <div class="card">
                <h3>Contact Organization</h3>
                <p class="sub-text">Choose an organization to coordinate your hiking adventure outside the platform.</p>
                
                <div class="org-card">
                    <h4>Juan Faith Adventure</h4>
                    <p>Professional hiking organizers with 10 years experience</p>
                    <span>Contact: 0910 802 5667</span>
                    <a href="#">https://www.fb.com/JuanFaithAdventure</a>
                </div>

                <div class="org-card">
                    <h4>Hiking Buddies PH</h4>
                    <p>Community-based hiking group with certified guides</p>
                    <span>Contact: 275861286</span>
                    <a href="#">https://www.fb.com/hikingbuddiesph/</a>
                </div>

                <div class="org-card">
                    <h4>Peak Explorers</h4>
                    <p>Eco-friendly hiking tours and outdoor adventures</p>
                    <a href="#">info@peakexplorers.ph</a>
                </div>

            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Group Size Stepper ---
            const sizeDisplay = document.getElementById('group-size');
            const btnMinus = document.getElementById('btn-minus');
            const btnPlus = document.getElementById('btn-plus');
            let currentSize = 1;

            btnMinus.addEventListener('click', () => {
                if (currentSize > 1) {
                    currentSize--;
                    sizeDisplay.textContent = currentSize;
                }
            });

            btnPlus.addEventListener('click', () => {
                if (currentSize < 10) { // Max 10 people
                    currentSize++;
                    sizeDisplay.textContent = currentSize;
                }
            });

            // --- *** NEW CODE: Show Organization Panel on "Book Now" click *** ---
            const bookButton = document.querySelector('.book-now-btn');
            const orgPanel = document.getElementById('organization-panel');

            if (bookButton && orgPanel) {
                bookButton.addEventListener('click', () => {
                    // Set display to 'block' to make it visible
                    // (The CSS 'flex: 1' will still apply from the parent container)
                    orgPanel.style.display = 'block'; 
                });
            }
            // --- *** END OF NEW CODE *** ---
        });
    </script>

</body>
</html>