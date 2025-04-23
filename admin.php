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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schemeName = $_POST['schemeName'];
    $category = $_POST['category'];
    $eligibility = implode(", ", $_POST['eligibility']);
    $benefits = implode(", ", $_POST['benefits']);
    $documents = implode(", ", $_POST['documents']);
    $applicationSteps = implode(", ", $_POST['applicationSteps']);
    $schemeLink = $_POST['schemeLink'];  // Get scheme link from form

    // Insert data into database
    $sql = "INSERT INTO schemes (scheme_name, category, eligibility, benefits, documents, application_steps, scheme_link) 
            VALUES ('$schemeName', '$category', '$eligibility', '$benefits', '$documents', '$applicationSteps', '$schemeLink')";

    if ($conn->query($sql) === TRUE) {
        $message = "New scheme added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-blue-100 to-white py-12">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h1 class="text-3xl font-bold text-blue-900 mb-8">Add New Scheme</h1>

            <?php if (!empty($message)) : ?>
                <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form id="schemeForm" class="space-y-8" method="POST">
                <!-- Scheme Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Scheme Name</label>
                    <input type="text" name="schemeName" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring focus:ring-blue-500">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring focus:ring-blue-500">
                        <option value="Education">Education</option>
                        <option value="Health">Health</option>
                        <option value="Business">Business</option>
                        <option value="Agriculture">Agriculture</option>
                        <option value="Women Empowerment">Women Empowerment</option>
                    </select>
                </div>

                <!-- Eligibility -->
                <div id="eligibilityFields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Eligibility</label>
                    <div class="flex gap-2">
                        <input type="text" name="eligibility[]" required class="w-full px-4 py-3 rounded-2xl border border-gray-300">
                        <button type="button" onclick="addField('eligibilityFields', 'eligibility[]')" class="bg-blue-500 text-white px-3 py-2 rounded-full flex items-center">
                            <i data-lucide="plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Benefits -->
                <div id="benefitsFields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Benefits</label>
                    <div class="flex gap-2">
                        <input type="text" name="benefits[]" required class="w-full px-4 py-3 rounded-2xl border border-gray-300">
                        <button type="button" onclick="addField('benefitsFields', 'benefits[]')" class="bg-blue-500 text-white px-3 py-2 rounded-full flex items-center">
                            <i data-lucide="plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Documents -->
                <div id="documentsFields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Documents Required</label>
                    <div class="flex gap-2">
                        <input type="text" name="documents[]" required class="w-full px-4 py-3 rounded-2xl border border-gray-300">
                        <button type="button" onclick="addField('documentsFields', 'documents[]')" class="bg-blue-500 text-white px-3 py-2 rounded-full flex items-center">
                            <i data-lucide="plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Application Steps -->
                <div id="applicationStepsFields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Application Steps</label>
                    <div class="flex gap-2">
                        <input type="text" name="applicationSteps[]" required class="w-full px-4 py-3 rounded-2xl border border-gray-300">
                        <button type="button" onclick="addField('applicationStepsFields', 'applicationSteps[]')" class="bg-blue-500 text-white px-3 py-2 rounded-full flex items-center">
                            <i data-lucide="plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Scheme Link -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Scheme Link (Official Website)</label>
                    <input type="url" name="schemeLink" required placeholder="https://example.com" 
                           class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:ring focus:ring-blue-500">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-2xl font-semibold flex items-center">
                        <i data-lucide="save" class="mr-2"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function addField(containerId, inputName) {
            const container = document.getElementById(containerId);
            const div = document.createElement("div");
            div.classList.add("flex", "gap-2", "mt-2");

            const input = document.createElement("input");
            input.type = "text";
            input.name = inputName;
            input.required = true;
            input.classList.add("w-full", "px-4", "py-3", "rounded-2xl", "border", "border-gray-300");

            const removeButton = document.createElement("button");
            removeButton.classList.add("bg-red-500", "text-white", "px-3", "py-2", "rounded-full", "flex", "items-center");
            removeButton.innerHTML = '<i data-lucide="x"></i>';
            removeButton.onclick = function () {
                container.removeChild(div);
            };

            div.appendChild(input);
            div.appendChild(removeButton);
            container.appendChild(div);
            lucide.createIcons();
        }
    </script>

</body>
</html>
