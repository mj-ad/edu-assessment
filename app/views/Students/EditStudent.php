<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu Assessment - Edit Student</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header><h1>Edu Assessment System</h1></header>
    <nav><a href="/students">Student List</a> <a href="/add-student">Add Student</a></nav>
    <div class="content">
        <h2>Edit Student</h2>
        <?php
        require_once __DIR__ . '/../../models/Student.php';
        $classes = Student::getClasses();
        ?>
        <form id="editStudentForm" method="POST" action="/students/<?php echo $student['id']; ?>/edit" enctype="application/x-www-form-urlencoded">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="reg_no">Registration No:</label>
                <input type="text" name="reg_no" id="reg_no" value="<?php echo htmlspecialchars($student['reg_no']); ?>" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="class_id">Class:</label>
                <select name="class_id" id="class_id" required>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php echo $class['id'] == $student['class_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($class['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fee_status">Fee Status:</label>
                <select name="fee_status" id="fee_status">
                    <option value="unpaid" <?php echo $student['fee_status'] === 'unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="paid" <?php echo $student['fee_status'] === 'paid' ? 'selected' : ''; ?>>Paid</option>
                </select>
            </div>
            <button type="submit">Update Student</button>
            <div id="errorMessage" class="error"></div>
        </form>
        <a href="/students/<?php echo $student['id']; ?>">Back to Student</a>
    </div>

    <script>
        document.getElementById('editStudentForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = `/students/${<?php echo $student['id']; ?>}/edit`;
            const response = await fetch(url, {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
            });
            console.log(response);
            const data = await response.json();
            if (response.ok) {
                window.location.href = `/students`;
            } else {
                document.getElementById('errorMessage').textContent = data.error || 'An error occurred';
                document.getElementById('errorMessage').style.display = 'block';
            }
        });
    </script>
</body>
</html>