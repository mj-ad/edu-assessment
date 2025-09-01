<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu Assessment - Student Details</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header><h1>Edu Assessment System</h1></header>
    <nav><a href="/students">Student List</a> <a href="/add-student">Add Student</a></nav>
    <div class="content">
        <h2>Student Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
        <p><strong>Registration No:</strong> <?php echo htmlspecialchars($student['reg_no']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?></p>
        <p><strong>Fee Status:</strong> 
            <span class="fee-status" data-id="<?php echo $student['id']; ?>" data-status="<?php echo $student['fee_status']; ?>">
                <?php echo $student['fee_status'] === 'unpaid' ? 'Owing' : 'Paid'; ?>
            </span>
        </p>
        <a href="/students/<?php echo $student['id']; ?>/edit">Edit</a>
        <a href="/students">Back to List</a>
    </div>
</body>
</html>