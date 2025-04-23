<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "schemes_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all schemes
$sql = "SELECT * FROM schemes";
$result = $conn->query($sql);
$schemes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schemes[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GovSchemes</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="bg-gray-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="/" class="text-2xl font-bold text-blue-400">
                    GovSchemes
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-700">Home</a>
                    <a href="/about" class="px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-700">About</a>
                    <a href="/contact" class="px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-700">Contact</a>
                    <a href="admin.php" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl text-sm font-medium">
                        Admin
                    </a>
                </div>

                <button id="menu-toggle" class="md:hidden p-2 rounded-xl hover:bg-gray-700">
                    ☰
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-gray-800">
            <a href="/" class="block px-6 py-3 hover:bg-gray-700">Home</a>
            <a href="/about" class="block px-6 py-3 hover:bg-gray-700">About</a>
            <a href="/contact" class="block px-6 py-3 hover:bg-gray-700">Contact</a>
            <a href="admin.php" class="block px-6 py-3 hover:bg-gray-700">Admin</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative text-white py-32 text-center" style="background: url('https://img.freepik.com/free-photo/flag-india_1401-132.jpg?t=st=1739111898~exp=1739115498~hmac=4167de4398f2f08f5338a576897617e607854d2ba691aa7f600440318abd0585&w=740') no-repeat center center/cover;">
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="relative z-10">
            <h1 class="text-5xl font-bold text-white">Discover Government Schemes</h1>
            <p class="mt-8 text-lg text-gray-100">
                Find and access government schemes that can benefit you and your family.
            </p>
            
            <div class="mt-12 max-w-xl mx-auto">
                <div class="flex rounded-full bg-gray-700 border border-gray-600 p-2">
                    <input type="text" id="searchInput" class="flex-1 px-6 py-4 bg-transparent text-white placeholder-gray-400 focus:outline-none" placeholder="Search for schemes..." onkeyup="filterSchemes()">
                    <button class="px-8 py-4 rounded-full bg-blue-600 hover:bg-blue-700 text-white">Search</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Schemes Section -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-blue-400 mb-8">Available Schemes</h2>
            <div id="schemesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($schemes as $scheme) : ?>
                    <div class="bg-gray-800 p-6 rounded-xl shadow-md transform hover:scale-105 transition">
                        <h3 class="text-xl font-semibold text-blue-400"><?php echo htmlspecialchars($scheme['scheme_name']); ?></h3>
                        <p class="mt-2 text-sm text-gray-300"><strong>Category:</strong> <?php echo htmlspecialchars($scheme['category']); ?></p>
                        <p class="mt-2 text-sm text-gray-300"><strong>Eligibility:</strong> <?php echo htmlspecialchars($scheme['eligibility']); ?></p>
                        <p class="mt-2 text-sm text-gray-300"><strong>Benefits:</strong> <?php echo htmlspecialchars($scheme['benefits']); ?></p>
                        <p class="mt-2 text-sm text-gray-300"><strong>Documents:</strong> <?php echo htmlspecialchars($scheme['documents']); ?></p>
                        <p class="mt-2 text-sm text-gray-300"><strong>Application Steps:</strong> <?php echo nl2br(htmlspecialchars($scheme['application_steps'])); ?></p>
                        <a href="<?php echo htmlspecialchars($scheme['scheme_link']); ?>" target="_blank" class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-sm font-medium">Apply Now</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="text-center">
            <p class="text-sm">© 2025 Government Schemes Portal. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.getElementById("menu-toggle").addEventListener("click", function () {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });

        function filterSchemes() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let schemes = document.querySelectorAll("#schemesContainer div");

            schemes.forEach(scheme => {
                let text = scheme.textContent.toLowerCase();
                scheme.style.display = text.includes(input) ? "block" : "none";
            });
        }
    </script>
</body>
</html>
