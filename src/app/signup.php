<?php
require "../config/connect_db.php";

/**
 * CREATE TABLE users (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     fullname VARCHAR(255) NOT NULL,
 *     email VARCHAR(255) NOT NULL UNIQUE,
 *     password VARCHAR(255) NOT NULL
 * );
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../output.css">
    <title>Signup - Todo App</title>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-purple-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md backdrop-blur-sm bg-opacity-95">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Create Account</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-6">
            <!-- Full Name -->
            <div class="relative">
                <input type="text" id="fullname" name="fullname" 
                    required placeholder="John Doe"
                    class="peer w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-transparent">
                <label for="fullname" 
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Full Name
                </label>
            </div>

            <!-- Email -->
            <div class="relative">
                <input type="email" id="email" name="email" 
                    required placeholder="email@example.com"
                    class="peer w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-transparent">
                <label for="email"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Email Address
                </label>
            </div>

            <!-- Password -->
            <div class="relative">
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    class="peer w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-transparent">
                <button type="button" onclick="togglePassword('password')" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400 hover:text-indigo-500" fill="none" id="password-icon" 
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
                <label for="password"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Password
                </label>
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••"
                    class="peer w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-transparent">
                <button type="button" onclick="togglePassword('confirm_password')" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400 hover:text-indigo-500" fill="none" id="confirm_password-icon" 
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
                <label for="confirm_password"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Confirm Password
                </label>
            </div>

            <!-- Terms and Conditions Checkbox -->
            <div class="flex items-start space-x-3">
                <input type="checkbox" id="terms" name="terms" required
                    class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                <label for="terms" class="text-sm text-gray-600">
                    I agree to the
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Terms, Conditions</a>
                    and
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                    Create Account
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                Login here
            </a>
        </p>
    </div>
    <script src="../js//utils.js"></script>
</body>
</html>