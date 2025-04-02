<?php
session_start();
include 'db.php';

if (!isset($_SESSION['namee'])) {
    header("Location: admin.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    if (!$recipe) {
        echo "<script>alert('Recipe not found!'); window.location.href='adminrecipes.php';</script>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $image = $_POST['image'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $video_url = $_POST['video_url'];
        $suggestions = $_POST['suggestions'];

        $updateSQL = "UPDATE recipes SET name=?, image=?, ingredients=?, instructions=?, video_url=?, suggestions=? WHERE id=?";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("ssssssi", $name, $image, $ingredients, $instructions, $video_url, $suggestions, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Recipe updated successfully!'); window.location.href='adminrecipes.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='adminrecipes.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Reset */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container for the form */
        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Form groups */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box; /* ensures padding doesn't overflow */
        }

        .form-group textarea {
            height: 120px;
            resize: vertical; /* allows vertical resizing */
        }

        .form-group button {
            padding: 12px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: darkgreen;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            .form-group button {
                font-size: 14px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input,
            .form-group textarea {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media (min-width: 601px) {
            .container {
                width: 60%;
            }

            h2 {
                font-size: 26px;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Recipe</h2>

        <form method="POST">
            <div class="form-group">
                <label for="name">Recipe Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image Path</label>
                <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($recipe['image']); ?>" required>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" id="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="instructions">Instructions</label>
                <textarea name="instructions" id="instructions" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="video_url">Recipe Video URL</label>
                <textarea name="video_url" id="video_url" required><?php echo htmlspecialchars($recipe['video_url']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="suggestions">Suggestions</label>
                <textarea name="suggestions" id="suggestions"><?php echo htmlspecialchars($recipe['suggestions']); ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="update-btn">Update Recipe</button>
            </div>
        </form>
    </div>

</body>
</html>
 
