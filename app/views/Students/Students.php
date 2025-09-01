<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu Assessment - Student List</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/app.js" defer></script>
</head>
<body>
    <header><h1>Edu Assessment System</h1></header>
    <nav><a href="/students">Student List</a> <a href="/add-student">Add Student</a></nav>
    <div class="content">
        <h2>Student List</h2>
        <input type="text" id="searchInput" placeholder="Search by name...">
        <ul id="studentList">
            <?php
            $students = Student::all();
            foreach ($students as $student): ?>
                <li>
                    <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?> 
                    (Reg No: <?php echo htmlspecialchars($student['reg_no']); ?>)
                    <a href="/students/<?php echo $student['id']; ?>">View</a>
                    <a href="/students/<?php echo $student['id']; ?>/edit">Edit</a>
                    <span class="fee-status" data-id="<?php echo $student['id']; ?>" data-status="<?php echo $student['fee_status']; ?>">
                        <?php echo $student['fee_status'] === 'unpaid' ? 'Owing' : 'Paid'; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="feeStatusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Update Fee Status</h3>
            <p>Are you sure you want to change the fee status?</p>
            <button id="confirmFeeStatus">Confirm</button>
        </div>
    </div>
</body>
</html>