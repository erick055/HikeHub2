// Get modal elements
const modal = document.getElementById("editProfileModal");
const editBtn = document.getElementById("editProfileBtn");
const closeModal = document.getElementById("closeModal");
const cancelBtn = document.getElementById("cancelBtn");
const saveBtn = document.getElementById("saveBtn");

// --- Display fields on main page ---
const displayName = document.getElementById("displayName");
const displayBio = document.getElementById("displayBio");
const displayLocation = document.getElementById("displayLocation");
const displayExperience = document.getElementById("displayExperience");
const displayPhone = document.getElementById("displayPhone");
const displayEmergency = document.getElementById("displayEmergency");
const displayTrailType = document.getElementById("displayTrailType");
const displayHikeTime = document.getElementById("displayHikeTime");
const displayCompanion = document.getElementById("displayCompanion");
// *** NEW: Get image display elements ***
const mainProfilePic = document.getElementById("mainProfilePic");
const headerProfilePic = document.getElementById("headerProfilePic"); // Assumes header pic has id 'headerProfilePic'
const profilePicPreview = document.getElementById("profilePicPreview");


// --- Input fields in modal ---
const nameInput = document.getElementById("nameInput");
const bioInput = document.getElementById("bioInput");
const locationInput = document.getElementById("locationInput");
const experienceInput = document.getElementById("experienceInput");
const emailInput = document.getElementById("emailInput"); // Already readonly
const phoneInput = document.getElementById("phoneInput");
const emergencyInput = document.getElementById("emergencyInput");
const trailInput = document.getElementById("trailInput");
const timeInput = document.getElementById("timeInput");
const companionInput = document.getElementById("companionInput");
// *** NEW: Get file input ***
const profilePicInput = document.getElementById("profilePicInput");
let selectedFile = null; // Variable to hold the selected file


// *** NEW: Add event listener for file input change (for preview) ***
profilePicInput.onchange = (e) => {
  if (e.target.files && e.target.files[0]) {
    selectedFile = e.target.files[0]; // Store the file
    
    // Create a URL for the selected file to use as a preview
    const reader = new FileReader();
    reader.onload = (event) => {
      profilePicPreview.src = event.target.result;
    };
    reader.readAsDataURL(selectedFile);
  }
};


// === OPEN MODAL ===
editBtn.onclick = () => {
  // Populate modal inputs from the *display* text on the page
  nameInput.value = displayName.textContent;
  bioInput.value = (displayBio.textContent === "No bio yet. Click 'Edit Profile' to add one!") ? "" : displayBio.textContent;
  locationInput.value = (displayLocation.textContent === "Not set") ? "" : displayLocation.textContent;
  experienceInput.value = (displayExperience.textContent === "Not set") ? "Beginner" : displayExperience.textContent;
  phoneInput.value = (displayPhone.textContent === "Not set") ? "" : displayPhone.textContent;
  emergencyInput.value = (displayEmergency.textContent === "Not set") ? "" : displayEmergency.textContent;
  trailInput.value = (displayTrailType.textContent === "Not set") ? "Mountain" : displayTrailType.textContent;
  timeInput.value = (displayHikeTime.textContent === "Not set") ? "Morning" : displayHikeTime.textContent;
  companionInput.value = (displayCompanion.textContent === "Not set") ? "Solo" : displayCompanion.textContent;
  
  // *** NEW: Reset file input and preview ***
  profilePicInput.value = null; // Clear any selected file
  selectedFile = null;
  profilePicPreview.src = mainProfilePic.src; // Set preview to current main pic

  modal.style.display = "block";
};

// === CLOSE MODAL ===
function closeModalWindow() {
  modal.style.display = "none";
}
closeModal.onclick = closeModalWindow;
cancelBtn.onclick = closeModalWindow;
window.onclick = (e) => {
  if (e.target === modal) closeModalWindow();
};

// === SAVE CHANGES (MODIFIED) ===
saveBtn.onclick = () => {
  const newName = nameInput.value.trim();
  if (newName === "") {
    alert("Name cannot be empty.");
    return;
  }

  // 1. Create a FormData object to send all data
  const formData = new FormData();
  formData.append('name', nameInput.value);
  formData.append('bio', bioInput.value);
  formData.append('location', locationInput.value);
  formData.append('experience_level', experienceInput.value);
  formData.append('phone_number', phoneInput.value);
  formData.append('emergency_contact', emergencyInput.value);
  formData.append('favorite_trail_type', trailInput.value);
  formData.append('best_hiking_time', timeInput.value);
  formData.append('companion_preference', companionInput.value);

  // *** NEW: Append the selected file IF one was chosen ***
  if (selectedFile) {
    formData.append('profile_picture', selectedFile);
  }


  // Disable button to prevent double-clicking
  saveBtn.disabled = true;
  saveBtn.textContent = "Saving...";

  // 2. Send the data to your PHP file
  fetch('update_profile.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json()) // Expect a JSON response
  .then(data => {
    if (data.status === 'success') {
    // The simplest and most reliable way to show all changes
    // is to just reload the page.
    location.reload();
} else {
    // Show an error message from the server
    alert(data.message || 'An error occurred.');
}
  })
  .catch(error => {
    console.error('Error:', error);
    alert('A connection error occurred. Please try again.');
  })
  .finally(() => {
    // Re-enable the save button whether it succeeded or failed
    saveBtn.disabled = false;
    saveBtn.textContent = "💾 Save Changes";
  });
};