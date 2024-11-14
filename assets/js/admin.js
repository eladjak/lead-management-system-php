// Console log helper function
function consoleLog(message) {
    console.log(`[Lead Management System - Admin] ${message}`);
}

// Delete lead function
function deleteLead(id) {
    consoleLog(`Attempting to delete lead ${id}`);
    
    if (confirm('Are you sure you want to delete this lead?')) {
        $.ajax({
            url: 'delete_lead.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                consoleLog('Lead deleted successfully');
                $(`tr[data-id="${id}"]`).fadeOut(400, function() {
                    $(this).remove();
                });
            },
            error: function(xhr, status, error) {
                consoleLog('Error deleting lead: ' + error);
                alert('Error deleting lead. Please try again.');
            }
        });
    }
}

// Document ready handler
$(document).ready(function() {
    consoleLog('Admin page loaded successfully');

    // Initialize DataTable
    $('#leadsTable').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        return 'Lead Details: ' + row.data()[1];
                    }
                }),
                renderer: function(api, rowIdx, columns) {
                    let data = $.map(columns, function(col, i) {
                        return col.hidden ?
                            '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                            '<td class="dtr-title">' + col.title + ':</td> ' +
                            '<td class="dtr-data">' + col.data + '</td>' +
                            '</tr>' :
                            '';
                    }).join('');

                    return data ?
                        $('<table class="table dtr-details" width="100%"/>').append(data) :
                        false;
                }
            }
        },
        order: [[0, 'desc']],
        pageLength: 25,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            emptyTable: "No data available",
            zeroRecords: "No matching records found"
        },
        columnDefs: [
            {
                targets: -1,
                orderable: false
            }
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
    });

    // Initialize phone formatting for edit form
    $('#editPhone').on('input', formatPhoneNumber);
});

// Phone number formatting function
function formatPhoneNumber(e) {
    let input = e.target || this;
    let value = input.value.replace(/\D/g, '');
    
    // Check if it's an Israeli number
    if (value.startsWith('972') || value.startsWith('05')) {
        if (value.startsWith('972')) {
            value = value.substring(3);
        }
        if (value.startsWith('0')) {
            value = value.substring(1);
        }
        // Format as Israeli number: 05X-XXX-XXXX
        if (value.length > 0) {
            value = '05' + value;
            value = value.match(/.{1,3}/g).join('-');
        }
    } else {
        // Format as international number
        if (value.length > 0) {
            value = value.match(/.{1,3}/g).join('-');
        }
    }
    
    input.value = value;
}

// View lead details
function viewLead(id) {
    $.ajax({
        url: 'get_lead.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            if (typeof response === 'string') {
                response = JSON.parse(response);
            }
            
            Swal.fire({
                title: 'Lead Details',
                html: `
                    <div class="text-start">
                        <div class="lead-details">
                            <p><strong>Full Name:</strong> ${response.first_name} ${response.last_name}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Phone:</strong> ${response.phone}</p>
                            <p><strong>Department:</strong> ${response.department_name}</p>
                            <p><strong>Date:</strong> ${new Date(response.date_and_time).toLocaleString()}</p>
                            <p><strong>Message:</strong></p>
                            <div class="lead-content p-2 bg-light rounded">
                                ${response.content}
                            </div>
                        </div>
                    </div>
                `,
                width: '600px',
                confirmButtonText: 'Close'
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error loading lead: ' + error
            });
        }
    });
}

// Edit lead function
function editLead(id) {
    consoleLog(`Loading lead ${id} for editing`);
    
    $.ajax({
        url: 'get_lead.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            if (typeof response === 'string') {
                response = JSON.parse(response);
            }
            
            consoleLog('Lead data loaded successfully');
            
            // Populate the form fields
            $('#editId').val(response.id);
            $('#editFirstName').val(response.first_name);
            $('#editLastName').val(response.last_name);
            $('#editEmail').val(response.email);
            $('#editPhone').val(response.phone);
            $('#editDepartment').val(response.department_id);
            $('#editContent').val(response.content);
            
            // Show the modal
            new bootstrap.Modal('#editModal').show();
        },
        error: function(xhr, status, error) {
            consoleLog('Error loading lead: ' + error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error loading lead: ' + error
            });
        }
    });
}

// Update lead
function updateLead() {
    const data = {
        id: $('#editId').val(),
        firstName: $('#editFirstName').val().trim(),
        lastName: $('#editLastName').val().trim(),
        email: $('#editEmail').val().trim(),
        phone: $('#editPhone').val().trim(),
        department: $('#editDepartment').val(),
        content: $('#editContent').val().trim()
    };

    if (!validateForm(data)) return;

    $.ajax({
        url: 'update_lead.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Lead updated successfully',
                timer: 1500
            }).then(() => {
                location.reload();
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update lead: ' + error
            });
        }
    });
}

// Delete lead
function deleteLead(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_lead.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Lead has been deleted.',
                        'success'
                    ).then(() => {
                        $(`tr[data-id="${id}"]`).fadeOut();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Failed to delete lead: ' + error,
                        'error'
                    );
                }
            });
        }
    });
}

// Form validation
function validateForm(data) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^(\+972|05)\d{1,2}-?\d{3}-?\d{4}$/;

    if (!emailRegex.test(data.email)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email',
            text: 'Please enter a valid email address'
        });
        return false;
    }

    if (!phoneRegex.test(data.phone)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Phone',
            text: 'Please enter a valid Israeli phone number'
        });
        return false;
    }

    return true;
} 