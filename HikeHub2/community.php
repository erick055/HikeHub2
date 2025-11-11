<?php

session_start();
require_once 'config.php';

$loggedIn = isset($_SESSION['email']); 
$username = $_SESSION['name'] ?? "Guest";
// --- ADDED: Get pic path, use default if not logged in or no pic ---
$profile_picture_path = $_SESSION['profile_picture'] ?? 'img/default-avatar.png';

$sql = "SELECT 
            r.*, 
            u.name AS user_name, 
            t.name AS trail_name 
        FROM 
            reviews r
        JOIN 
            users u ON r.user_id = u.id
        JOIN 
            trails t ON r.trail_id = t.id
        ORDER BY 
            r.created_at DESC";

$reviews_result = $conn->query($sql);

// 2. Function to generate star ratings
function render_stars($rating) {
    $stars_html = '';
    for ($i = 1; $i <= 5; $i++) {
        // Use filled star for ratings, empty star for the rest
        $stars_html .= ($i <= $rating) ? '★' : '☆'; 
    }
    return $stars_html;
}

// 3. Function to format time
function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);

    if ($seconds <= 60) return "Just now";
    else if ($minutes <= 60) return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
    else if ($hours <= 24) return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
    else if ($days <= 7) return ($days == 1) ? "1 day ago" : "$days days ago";
    else if ($weeks <= 4.3) return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
    else if ($months <= 12) return ($months == 1) ? "1 month ago" : "$months months ago";
    else return ($years == 1) ? "1 year ago" : "$years years ago";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HikeHub Cavite</title>
  <link rel="stylesheet" href="style/community.css" />
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
      <a href="#">
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
<div class="community-hub-container">
    <div class="community-header">
        <h1>Community Hub</h1>
        <p>Connect with fellow hikers, share experiences, and get advice.</p>
    </div>

    <div class="hub-tabs">
        <a href="#" class="tab-link active">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.172 3h3.656a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.828 2H6.172a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 2.172 4H2z"/>
                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
            Reviews & Photos
        </a>
        
    </div>

    <button class="share-experience-btn" id="openReviewModalBtn">
        Share your Hiking Experience
    </button>

    <div class="review-feed">
        <?php if ($reviews_result->num_rows > 0): ?>
            <?php while($review = $reviews_result->fetch_assoc()): ?>
                <?php 
                    // Create user initials
                    $names = explode(' ', $review['user_name']);
                    $initials = '';
                    if (isset($names[0])) $initials .= strtoupper(substr($names[0], 0, 1));
                    if (isset($names[1])) $initials .= strtoupper(substr($names[1], 0, 1));
                    if (empty($initials)) $initials = '??';
                ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="avatar-initials" title="<?php echo htmlspecialchars($review['user_name']); ?>"><?php echo $initials; ?></div>
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($review['user_name']); ?></span>
                            <span class="trail-name"><?php echo htmlspecialchars($review['trail_name']); ?></span>
                        </div>
                        <div class="review-meta">
                            <div class="review-stars">
                                <?php echo render_stars($review['rating']); ?>
                            </div>
                            <span class="time-ago"><?php echo time_ago($review['created_at']); ?></span>
                        </div>
                    </div>
                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    
                    <?php if (!empty($review['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($review['image_path']); ?>" alt="Hike photo" class="review-image">
                    <?php endif; ?>

                    <div class="review-actions">
                        <button class="action-btn like-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                <path d="M8.864.046C7.973-.059 7.718.06 8.045.272l1.396 4.42-.405 2.15C9.207 6.22 8.509 6 7.825 6H5.25A1.75 1.75 0 0 0 3.5 7.75v3.5A1.75 1.75 0 0 0 5.25 13h.875c.041.244.1.488.18.729.09.265.196.51.328.704h3.79c.079-.13.166-.266.25-.41.087-.146.17-.301.24-.465.1-.2.167-.38.22-.536.053-.156.083-.298.083-.399v-.41c0-.13-.02-.246-.045-.353-.01-.04-.02-.091-.03-.163l.04-.001c.072-.016.152-.027.23-.034.146-.013.296-.024.459-.026h.875A1.75 1.75 0 0 0 16 9.25V7.5a1.75 1.75 0 0 0-1.75-1.75h-5.562c-.067 0-.134-.001-.2-.003M15.25 7.5v1.75c0 .138-.112.25-.25.25H8.75c-.138 0-.25-.112-.25-.25V6.837c0-.285.056-.503.1-.643.078-.231.17-.384.29-.499.125-.125.26-.237.4-.342.06-.045.105-.088.138-.12.02-.02.04-.035.045-.038a.2.2 0 0 0 .007-.004l1.396-4.42c.038-.12.036-.217-.035-.29-.07-.074-.194-.131-.35-.16L8.864.046Zm-8.407 6.438h-.875c-.138 0-.25-.112-.25-.25v-3.5c0-.138.112-.25.25-.25h.875c.138 0 .25.112.25.25v3.5c0 .138-.112.25-.25.25z"/>
                            </svg>
                            <?php echo $review['likes']; ?>
                        </button>
                        <button class="action-btn comment-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                            </svg>
                            <?php echo $review['comments']; ?>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #555;">No reviews yet. Be the first to share your experience!</p>
        <?php endif; ?>
    </div>
</div>

<div class="modal" id="reviewModal">
    <div class="modal-content">
        <span class="close-btn" id="closeReviewModalBtn">&times;</span>
        <h2>Share your Hiking Experience</h2>
        
        <form id="addReviewForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="trailSelect">Which trail did you hike?</label>
                <select id="trailSelect" name="trail_id" required>
                    <option value="" disabled selected>Select a trail</option>
                    <?php
                    // Fetch trails again for the modal
                    $trails_sql = "SELECT id, name FROM trails ORDER BY name ASC";
                    $trails_result = $conn->query($trails_sql);
                    if ($trails_result->num_rows > 0) {
                        while($trail = $trails_result->fetch_assoc()) {
                            echo '<option value="' . $trail['id'] . '">' . htmlspecialchars($trail['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Your Rating</label>
                <div class="modal-stars" id="modalStarRating">
                    <span data-value="1">☆</span>
                    <span data-value="2">☆</span>
                    <span data-value="3">☆</span>
                    <span data-value="4">☆</span>
                    <span data-value="5">☆</span>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="0">
            </div>

            <div class="form-group">
                <label for="reviewText">Your Review</label>
                <textarea id="reviewText" name="review_text" rows="5" placeholder="Tell us about your hike, the views, the guide..." required></textarea>
            </div>

            <div class="form-group">
                <label for="reviewImage">Add a Photo (Optional)</label>
                <input type="file" id="reviewImage" name="review_image" accept="image/*">
            </div>

            <button type="submit" class="submit-review-btn" id="submitReviewBtn">Post Review</button>
            <div class="form-message" id="reviewFormMessage"></div>
        </form>
    </div>
</div>

  </main>
  </body>

</html>
<script src="jquery-3.3.1.js"></script>
 <script src="scripts/community.js"></script>