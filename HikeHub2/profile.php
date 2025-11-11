<?php
session_start();
require_once 'config.php'; 

// 2. Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$loggedIn = true; 
$exploreLink = 'explore.php';
$email = $_SESSION['email']; 

// 3. Fetch ALL user data from database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Set variables for display
    $username = $user['name'];
    $bio = $user['bio'] ?: "No bio yet. Click 'Edit Profile' to add one!";
    $location = $user['location'] ?: "Not set";
    $experience_level = $user['experience_level'] ?: "Not set";
    $phone_number = $user['phone_number'] ?: "Not set";
    $emergency_contact = $user['emergency_contact'] ?: "Not set";
    $favorite_trail_type = $user['favorite_trail_type'] ?: "Not set";
    $best_hiking_time = $user['best_hiking_time'] ?: "Not set";
    $companion_preference = $user['companion_preference'] ?: "Not set";
    
    // --- ADDED: Get profile pic path, use default if NULL ---
    $profile_picture_path = $user['profile_picture'] ?: 'img/default-avatar.png';

    // Ensure session variables are up to date
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['profile_picture'] = $user['profile_picture']; // <-- ADDED

} else {
    // Fallback if user not found
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/profile.css">
    <title>My Profile - HikeHub</title>
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
    
  <section class="profile-section">
    <div class="profile-card">
      <div class="profile-info">
        <div class="profile-icon">👤</div>
        <div class="profile-text">
          <h2 id="displayName"><?php echo htmlspecialchars($username); ?></h2>
          <p id="displayBio"><?php echo htmlspecialchars($bio); ?></p>
          <p id="displaySince" class="since">Since January 2023</p> </div>
        </div>
      </div>
      <button class="edit-btn" id="editProfileBtn">✏️ Edit Profile</button>
    </div>

    <div class="stats">
      <div class="stat">
        <h3>12</h3>
        <p>Trails Completed</p>
      </div>
      <div class="stat">
        <h3>85.5 km</h3>
        <p>Total Distance</p>
      </div>
      <div class="stat">
        <h3>28</h3>
        <p>Hiking Days</p>
      </div>
    </div>
  </section>
 <section class="main-content">
    <div class="recent-hikes">
      <h3>Recent Hikes</h3>

      <div class="hike-card">
        <div class="hike-details">
          <h4>Mt. Pico de Loro</h4>
          <p>1/25/24 • Difficulty: Moderate</p>
        </div>
        <div class="hike-meta">
          <p>Duration: 6.5 hours</p>
          <span>⭐⭐⭐⭐⭐</span>
        </div>
      </div>

      <div class="hike-card">
        <div class="hike-details">
          <h4>Mt. Pukay-Pukay</h4>
          <p>1/12/24 • Difficulty: Easy</p>
        </div>
        <div class="hike-meta">
          <p>Duration: 2.5 hours</p>
          <span>⭐⭐⭐⭐⭐</span>
        </div>
      </div>

      <div class="hike-card">
        <div class="hike-details">
          <h4>Mt. Talamitam</h4>
          <p>12/29/23 • Difficulty: Moderate</p>
        </div>
        <div class="hike-meta">
          <p>Duration: 4 hours</p>
          <span>⭐⭐⭐⭐⭐</span>
        </div>
      </div>

      <a href="#" class="view-all">View All Hikes →</a>
    </div>

    <div class="right-column-profile">
        <div class="quick-action">
          <h3>Quick Action</h3>
          <button class="action-btn plan" onclick="location.href='explore.php'">Plan New Hike</button>
          <button class="action-btn find" onclick="location.href='community.php'">Find Hiking Buddies</button>
          <button class="action-btn share" onclick="location.href='community.php'">Share Experience</button>
        </div>

        <div class="profile-details-card">
            <h3>Profile Details</h3>
            <ul>
                <li>
                    <strong>Location:</strong>
                    <span id="displayLocation"><?php echo htmlspecialchars($location); ?></span>
                </li>
                <li>
                    <strong>Experience:</strong>
                    <span id="displayExperience"><?php echo htmlspecialchars($experience_level); ?></span>
                </li>
                <li>
                    <strong>Phone:</strong>
                    <span id="displayPhone"><?php echo htmlspecialchars($phone_number); ?></span>
                </li>
                <li>
                    <strong>Emergency Contact:</strong>
                    <span id="displayEmergency"><?php echo htmlspecialchars($emergency_contact); ?></span>
                </li>
                <li>
                    <strong>Favorite Trail:</strong>
                    <span id="displayTrailType"><?php echo htmlspecialchars($favorite_trail_type); ?></span>
                </li>
                <li>
                    <strong>Best Hike Time:</strong>
                    <span id="displayHikeTime"><?php echo htmlspecialchars($best_hiking_time); ?></span>
                </li>
                <li>
                    <strong>Prefers:</strong>
                    <span id="displayCompanion"><?php echo htmlspecialchars($companion_preference); ?></span>
                </li>
            </ul>
        </div>
    </div>
  </section>

  <section class="achievements">
    <div class="badge">
      <h4>🏔️ First Summit</h4>
      <p>Completed your first trail</p>
    </div>
    <div class="badge">
      <h4>🧭 Explorer</h4>
      <p>Visited 20 different trails</p>
    </div>
    <div class="badge">
      <h4>💪 Endurance Hiker</h4>
      <p>Hiked for more than 50km total</p>
    </div>
    <div class="badge">
      <h4>🤝 Community Helper</h4>
      <p>Shared 5 helpful guides</p>
    </div>
  </section>
  <div id="editProfileModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeModal">&times;</span>
      <h2>Edit Profile</h2>

      <div class="edit-container">
        <div class="left">
          <div class="profile-pic-section">
            <div class="profile-avatar">👤</div>
            <button class="upload-btn">📤 Upload New Photo</button>
          </div>

          <label>Full Name</label>
          <input type="text" id="nameInput" placeholder="Enter full name" value="<?php echo htmlspecialchars($username); ?>" />

          <label>Location</label>
          <input type="text" id="locationInput" placeholder="Enter location" value="<?php echo htmlspecialchars($location); ?>" />

          <label>Bio</label>
          <textarea id="bioInput" placeholder="Write something..."><?php echo htmlspecialchars($bio); ?></textarea>

          <label>Experience Level</label>
          <select id="experienceInput">
            <option value="Beginner" <?php if($experience_level == 'Beginner') echo 'selected'; ?>>Beginner</option>
            <option value="Intermediate" <?php if($experience_level == 'Intermediate') echo 'selected'; ?>>Intermediate</option>
            <option value="Expert" <?php if($experience_level == 'Expert') echo 'selected'; ?>>Expert</option>
          </select>
        </div>

        <div class="right">
          <h3>Contact Information</h3>
          <label>Email</label>
          <input type="email" id="emailInput" value="<?php echo htmlspecialchars($email); ?>" readonly />

          <label>Phone Number</label>
          <input type="text" id="phoneInput" value="<?php echo htmlspecialchars($phone_number); ?>" />

          <label>Emergency Contact</label>
          <input type="text" id="emergencyInput" value="<?php echo htmlspecialchars($emergency_contact); ?>" />

          <h3>Hiking Preference</h3>
          <label>Favorite Trail Type</label>
          <select id="trailInput">
            <option value="Mountain" <?php if($favorite_trail_type == 'Mountain') echo 'selected'; ?>>Mountain</option>
            <option value="Forest" <?php if($favorite_trail_type == 'Forest') echo 'selected'; ?>>Forest</option>
            <option value="Waterfall" <?php if($favorite_trail_type == 'Waterfall') echo 'selected'; ?>>Waterfall</option>
          </select>

          <label>Best Hiking Time</label>
          <select id="timeInput">
            <option value="Morning" <?php if($best_hiking_time == 'Morning') echo 'selected'; ?>>Morning</option>
            <option value="Afternoon" <?php if($best_hiking_time == 'Afternoon') echo 'selected'; ?>>Afternoon</option>
            <option value="Evening" <?php if($best_hiking_time == 'Evening') echo 'selected'; ?>>Evening</option>
          </select>

          <label>Hiking Companion Preference</label>
          <select id="companionInput">
            <option value="Solo" <?php if($companion_preference == 'Solo') echo 'selected'; ?>>Solo</option>
            <option value="Friends" <?php if($companion_preference == 'Friends') echo 'selected'; ?>>Friends</option>
            <option value="Groups" <?php if($companion_preference == 'Groups') echo 'selected'; ?>>Groups</option>
          </select>
        </div>
      </div>

      <div class="modal-actions">
        <button id="cancelBtn" class="cancel-btn">Cancel</button>
        <button id="saveBtn" class="save-btn">💾 Save Changes</button>
      </div>
    </div>
  </div>

  <script src="scripts/profile.js"></script>


  </main>
</body>
</html>