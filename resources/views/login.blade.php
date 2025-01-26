<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: black;;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .image-section {
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') no-repeat center center/cover; /* Travel-related image */
            width: 70%;
        }

        .form-section {
            width: 30%;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .form-section .logo {
            margin-bottom: 20px;
        }

        .form-section .logo img {
            max-width: 150px; /* Adjust size of the logo */
        }

        .form-container {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(15px);
        }

        .btn {
            background: linear-gradient(45deg, #ff7f50, #ff4500);
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: linear-gradient(45deg, #ff6347, #ff8c00);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 140, 0, 0.3);
        }

        .extras a {
            color: #ffa07a;
            text-decoration: none;
            transition: 0.3s;
        }

        .extras a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="padding: 0px; !important">
        <!-- Image Section -->
        <div class="image-section">
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div class="logo">
                <img src="https://via.placeholder.com/150x50" alt="Company Logo"> <!-- Replace with your logo -->
            </div>
            <div class="form-container">
                <h2>Admin Login</h2>
                <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
                    @csrf
                    @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const errorMessage = document.getElementById('errorMessage');

            // Reset error message
            if (errorMessage) errorMessage.style.display = 'none';

            // Validate inputs
            if (!email.value.trim()) {
                errorMessage.textContent = 'Email is required.';
                errorMessage.style.display = 'block';
                e.preventDefault();
                return;
            }
            if (!validateEmail(email.value.trim())) {
                errorMessage.textContent = 'Enter a valid email address.';
                errorMessage.style.display = 'block';
                e.preventDefault();
                return;
            }
            if (!password.value.trim()) {
                errorMessage.textContent = 'Password is required.';
                errorMessage.style.display = 'block';
                e.preventDefault();
                return;
            }
            if (password.value.trim().length < 6) {
                errorMessage.textContent = 'Password must be at least 6 characters long.';
                errorMessage.style.display = 'block';
                e.preventDefault();
                return;
            }
        });

        // Function to validate email format
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>
</html>
