document.addEventListener('DOMContentLoaded', function() {
    
    const modal = document.getElementById('reviewModal');
    const openBtn = document.getElementById('openReviewModalBtn');
    const closeBtn = document.getElementById('closeReviewModalBtn');

    // --- Modal Open/Close ---
    if (openBtn) {
        openBtn.onclick = function() {
            // Check if user is logged in (you'll need to pass this from PHP)
            // For now, we assume if the button is there, they can click it.
            // A better check would be in add_review.php (which we did)
            modal.classList.add('show');
        }
    }

    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.classList.remove('show');
            resetForm();
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.remove('show');
            resetForm();
        }
    }

    // --- Modal Star Rating ---
    const modalStars = document.querySelectorAll('.modal-stars span');
    const ratingInput = document.getElementById('ratingInput');
    
    modalStars.forEach(star => {
        star.addEventListener('click', () => {
            const ratingValue = star.dataset.value;
            ratingInput.value = ratingValue;
            updateStarDisplay(ratingValue);
        });
    });

    function updateStarDisplay(rating) {
        modalStars.forEach(star => {
            if (star.dataset.value <= rating) {
                star.innerHTML = '★'; // Filled star
                star.classList.add('filled');
            } else {
                star.innerHTML = '☆'; // Empty star
                star.classList.remove('filled');
            }
        });
    }

    // --- AJAX Form Submission ---
    const reviewForm = document.getElementById('addReviewForm');
    const formMessage = document.getElementById('reviewFormMessage');
    const submitBtn = document.getElementById('submitReviewBtn');

    reviewForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Posting...';
        formMessage.textContent = '';
        formMessage.className = 'form-message';

        const formData = new FormData(reviewForm);

        fetch('add_review.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                formMessage.textContent = data.message;
                formMessage.classList.add('success');
                // Reload the page to show new review
                setTimeout(() => {
                    location.reload(); 
                }, 1500);
            } else {
                formMessage.textContent = data.message;
                formMessage.classList.add('error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Post Review';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            formMessage.textContent = 'A network error occurred. Please try again.';
            formMessage.classList.add('error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Post Review';
        });
    });

    function resetForm() {
        reviewForm.reset();
        ratingInput.value = '0';
        updateStarDisplay('0');
        formMessage.textContent = '';
        formMessage.className = 'form-message';
    }
});