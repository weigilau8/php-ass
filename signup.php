<?php
    include "./component/header.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Connect to the database 
        $mysqli = new mysqli("localhost", "root", "root", "php"); 
        
        // Check for errors 
        if ($mysqli->connect_error) { 
            die("Connection failed: " . $mysqli->connect_error); 
        }
        
        // Prepare and bind the SQL statement 
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)"); 
        $stmt->bind_param("sss", $username, $email, $password); 
        
        // Geting the form data 
        $username = $_POST['username']; 
        $email = $_POST['email']; 
        $password = $_POST['password']; 
        
        // Hashing the password for security
        $password = password_hash($password, PASSWORD_DEFAULT); 
        
        // Execute the SQL statement 
        if ($stmt->execute()) { 
            $message = "New account created successfully!";
        } else { 
            $message = "Error: ". $stmt->error;
        } 
        
        // Close the connection 
        $stmt->close(); $mysqli->close();
    }

?>

<section class="bg-gray-50 dark:bg-gray-800">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Create an account
                </h1>
                <?php if (isset($message)) : ?>
                    <div class="p-4 text-white bg-<?php echo strpos($message, 'successfully') !== false ? 'green' : 'red'; ?>-500 rounded">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <form class="space-y-4 md:space-y-6" action="#" method="post">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username" required="">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Already have an account? <a href="./login.php" class="font-medium text-green-600 hover:underline dark:text-green-500">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php 
    include "./component/footer.php";