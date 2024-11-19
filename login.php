<?php
    include "./component/header.php";


    if (isset($_POST['login'])) {
        // Connect to the database
        $mysqli = new mysqli("localhost", "root", "root", "php");
    
        // Check for errors
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
    
        // Prepare and bind the SQL statement
        $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ?");
        
        // Sanitize the email input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $stmt->bind_param("s", $email);
    
        // Get the password input
        $password = $_POST['password'];
    
        print_r($password);
        // Execute the SQL statement
        $stmt->execute();
        $stmt->store_result();
    
        // Check if the user exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $hashed_password);
    
            // Fetch the result
            $stmt->fetch();
    
            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Regenerate session ID
                session_regenerate_id(true);
    
                // Set the session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $email;
    
                // Redirect to the user's dashboard
                header("Location: home.php");
                exit;
            } else {
                $message = "Incorrect password!";
            }
        } else {
            $message = "User not found!";
        }
    
        // Close the connection
        $stmt->close();
        $mysqli->close();
    }
    
?>

<section class="bg-gray-50 dark:bg-gray-800">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-[400px] xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <!-- Display Message -->
                <?php if (isset($message)): ?>
                    <div class="p-4 text-white bg-red-500 rounded">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-4" action="#" method="post">

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="./signup.php" class="font-medium text-green-600 hover:underline dark:text-green-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php 
    include "./component/footer.php";