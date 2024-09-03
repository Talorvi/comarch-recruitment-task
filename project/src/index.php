<?php

require_once '../vendor/autoload.php';

use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Services\DatabaseService;
use App\Services\EmailSenderService;
use App\Services\FileSystem\LocalFileSystem;
use App\Services\Mailer\SimpleMailer;

// Database configuration -> can be moved to env
$servername = "db";
$username = "user";
$password = "password";
$dbname = "mydatabase";

// Instantiate the mailer and file system services
$mailer = new SimpleMailer();
$fileSystem = new LocalFileSystem();

// Initialize the DatabaseService
$dbService = DatabaseService::getInstance($servername, $username, $password, $dbname);
$conn = $dbService->getConnection();

$errors = [];
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
    $messageTemplate = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validation: Ensure a category is selected and is a valid integer
    if (empty($categoryId)) {
        $errors[] = "Please select a valid category.";
    }

    // Validation: Ensure the message template is not empty
    if (empty(trim($messageTemplate))) {
        $errors[] = "Message template cannot be empty.";
    }

    if (empty($errors)) {
        $users = UserRepository::getUsersByCategory($categoryId, $conn);
        if (empty($users)) {
            $errors[] = "No users found for the selected category.";
        } else {
            $emailService = new EmailSenderService($mailer, $fileSystem);
            foreach ($users as $user) {
                $emailService->send($user, $messageTemplate);
            }
            $successMessage = "Emails sent successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-md mx-auto bg-white p-8 border border-gray-300 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Send Emails To Users From Category</h2>
    <form method="POST" class="space-y-4">
        <?php if (!empty($errors)): ?>
            <div class="text-red-500">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div>
            <label for="category" class="block text-gray-700 font-bold mb-2">Choose a category:</label>
            <label>
                <select name="category"
                        class="w-full border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select a Category --</option>
                    <?php
                    $categories = CategoryRepository::getAllCategories($conn);
                    foreach ($categories as $category) {
                        echo "<option value='" . htmlspecialchars($category->getId()) . "'>" . htmlspecialchars($category->getName()) . "</option>";
                    }
                    ?>
                </select>
            </label>
        </div>
        <div>
            <label for="message" class="block text-gray-700 font-bold mb-2">Message Template:</label>
            <label>
                <textarea name="message" rows="10" cols="30"
                          class="w-full border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">Hello {first_name} {last_name}, this is your message!</textarea>
            </label>
        </div>
        <div class="text-center">
            <input type="submit" value="Send Emails"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer">
        </div>
    </form>
    <?php if ($successMessage): ?>
        <div class="text-green-500 mt-4 text-center">
            <p><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
    <?php endif; ?>
</div>

<?php
$dbService->close();
?>
</body>
</html>
