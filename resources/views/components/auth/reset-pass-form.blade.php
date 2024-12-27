<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function ResetPass() {
    let password = document.getElementById('password').value;
    let cpassword = document.getElementById('cpassword').value;

    // Validation checks
    if (password.length === 0) {
        errorToast('Password is required');
        return;
    } else if (cpassword.length === 0) {
        errorToast('Confirm Password is required');
        return;
    } else if (password !== cpassword) {
        errorToast('Password and Confirm Password must be the same');
        return;
    }

    // Show loader before the request
    showLoader();

    try {
        // Make the API request
        let res = await axios.post("/reset-password", { password: password });
        hideLoader();

        if (res.status === 200 && res.data['status'] === 'success') {
            // If reset is successful, show a success message and redirect
            successToast(res.data['message']);
            setTimeout(function () {
                window.location.href = "/userLogin";
            }, 1000);
        } else {
            // Show error from backend response
            errorToast(res.data['message']);
        }

    } catch (error) {
        hideLoader();

        // Check if the error is a network error or API error
        if (error.response) {
            // This is an API response error (e.g., 400 or 500)
            if (error.response.status === 400) {
                // Example: Password not strong enough or some other validation error
                errorToast('Invalid data provided. Please check your password and try again.');
            } else if (error.response.status === 500) {
                // Backend server error
                errorToast('Server error. Please try again later.');
            } else {
                // Generic API error
                errorToast('Something went wrong. Please try again.');
            }
        } else if (error.request) {
            // The request was made, but no response was received (network error)
            errorToast('Network error. Please check your connection and try again.');
        } else {
            // Unknown error
            errorToast('An unknown error occurred. Please try again later.');
        }

        // Log the error for debugging
        console.error("Password reset error:", error);
    }
}


</script>
