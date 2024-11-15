<?php require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lead Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="nav-container">
        <div>
            <a href="index.php"><i class="fas fa-plus-circle"></i> Submit Lead</a>
            <a href="admin.php" class="active"><i class="fas fa-cog"></i> Admin Panel</a>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <h2 class="mb-4"><i class="fas fa-users"></i> Leads Management</h2>
            
            <div class="table-responsive-wrapper">
                <table id="leadsTable" class="table table-striped table-hover dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="1">Name</th>
                            <th data-priority="3">Email</th>
                            <th data-priority="2">Phone</th>
                            <th data-priority="4">Department</th>
                            <th data-priority="4">Date</th>
                            <th data-priority="1" class="no-sort">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $db = new Database();
                            $conn = $db->getConnection();
                            
                            $query = "SELECT l.*, d.title as department_name 
                                    FROM leads l 
                                    JOIN departments d ON l.department_id = d.id 
                                    ORDER BY l.date_and_time DESC";
                            
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr data-id='{$row['id']}'>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td><div class='lead-name'>{$row['first_name']} {$row['last_name']}</div></td>";
                                echo "<td><div class='lead-email'>{$row['email']}</div></td>";
                                echo "<td><div class='lead-phone'>{$row['phone']}</div></td>";
                                echo "<td><div class='lead-dept'>{$row['department_name']}</div></td>";
                                echo "<td><div class='lead-date'>" . date('Y-m-d H:i', strtotime($row['date_and_time'])) . "</div></td>";
                                echo "<td>
                                        <div class='action-buttons'>
                                            <button class='btn btn-sm btn-edit' onclick='editLead({$row['id']})' title='Edit'>
                                                <i class='fas fa-edit'></i>
                                            </button>
                                            <button class='btn btn-sm btn-view' onclick='viewLead({$row['id']})' title='View'>
                                                <i class='fas fa-eye'></i>
                                            </button>
                                            <button class='btn btn-sm btn-delete' onclick='deleteLead({$row['id']})' title='Delete'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </div>
                                      </td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Lead</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" id="editId">
                            <div class="mb-3">
                                <label for="editFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="editFirstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="editLastName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="editPhone" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDepartment" class="form-label">Department</label>
                                <select class="form-select" id="editDepartment" required>
                                    <option value="1">Customer Service</option>
                                    <option value="2">Sales</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editContent" class="form-label">Content</label>
                                <textarea class="form-control" id="editContent" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateLead()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-content">
            <div class="copyright">
                © <?php echo date('Y'); ?> Lead Management System. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="https://github.com/eladjak" target="_blank">
                    <i class="fab fa-github"></i>
                    <span>GitHub</span>
                </a>
                <a href="https://www.linkedin.com/in/eladyaakobovitchcodingdeveloper" target="_blank">
                    <i class="fab fa-linkedin"></i>
                    <span>LinkedIn</span>
                </a>
                <a href="mailto:eladhiteclearning@gmail.com">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </div>
            <div class="social-links">
                <a href="https://github.com/eladjak/lead-management-system-php" target="_blank" title="View Source">
                    <i class="fas fa-code-branch"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html> 