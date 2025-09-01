<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu Assessment - <?php echo isset($title) ? $title : 'Home'; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #34495e;
            padding: 1rem;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #ecf0f1;
        }
        .content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edu Assessment System</h1>
    </header>
    <nav>
        <a href="/Students/Students">Student List</a>
        <a href="/Students/AddStudent">Add Student</a> <!-- Placeholder for future form -->
    </nav>
    <div class="content">
        <?php echo $content ?? ''; ?>
    </div>
</body>
</html>