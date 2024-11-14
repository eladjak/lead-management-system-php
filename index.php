<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="nav-container">
        <div>
            <a href="index.php" class="active"><i class="fas fa-plus-circle"></i> Submit Lead</a>
            <a href="admin.php"><i class="fas fa-cog"></i> Admin Panel</a>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4"><i class="fas fa-user-plus"></i> New Lead</h2>
        
        <!-- Alert Messages -->
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i> Lead submitted successfully!
        </div>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i> <span class="error-message"></span>
        </div>

        <form id="leadForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select class="form-select" id="department" required>
                    <option value="">Please choose...</option>
                    <option value="1">Customer Service</option>
                    <option value="2">Sales</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="content" class="form-label">Message</label>
                <textarea class="form-control" id="content" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Submit
                <div class="spinner"></div>
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html> 