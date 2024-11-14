// Console log helper function
function consoleLog(message) {
    console.log(`[Lead Management System] ${message}`);
}

// Show alert message
function showAlert(type, message) {
    $('.alert').hide();
    if (type === 'success') {
        $('.alert-success').fadeIn();
    } else {
        $('.error-message').text(message);
        $('.alert-danger').fadeIn();
    }
    
    // Hide alert after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

// Phone number formatting function
function formatPhoneNumber(phone) {
    // Remove all non-digits
    let value = phone.replace(/\D/g, '');
    
    // Check if it's an Israeli number
    if (value.startsWith('972')) {
        value = '0' + value.substring(3); // Convert 972 to 0
    }
    
    // Format according to Israeli phone number pattern
    if (value.startsWith('0')) {
        if (value.length >= 3) {
            value = value.substring(0,3) + '-' + value.substring(3);
        }
        if (value.length >= 7) {
            value = value.substring(0,7) + '-' + value.substring(7);
        }
    }
    
    return value;
}

// Form submission handler
$(document).ready(function() {
    consoleLog('Page loaded successfully');
    
    // Phone number formatting
    $('#phone').on('input', function() {
        let formattedNumber = formatPhoneNumber($(this).val());
        $(this).val(formattedNumber);
    });

    $('#leadForm').on('submit', function(e) {
        e.preventDefault();
        consoleLog('Form submission started');
        
        // Show spinner
        $('.spinner').show();
        $('button[type="submit"]').prop('disabled', true);
        
        // Get form data
        const formData = {
            firstName: $('#firstName').val().trim(),
            lastName: $('#lastName').val().trim(),
            email: $('#email').val().trim(),
            phone: $('#phone').val().trim(),
            department: $('#department').val(),
            content: $('#content').val().trim()
        };
        
        // Validate form data
        if (!validateForm(formData)) {
            $('.spinner').hide();
            $('button[type="submit"]').prop('disabled', false);
            return;
        }
        
        // Submit form via AJAX
        $.ajax({
            url: 'process_lead.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                consoleLog('Form submitted successfully');
                showAlert('success');
                $('#leadForm')[0].reset();
            },
            error: function(xhr, status, error) {
                consoleLog('Form submission error: ' + error);
                showAlert('error', 'Error submitting lead: ' + error);
            },
            complete: function() {
                $('.spinner').hide();
                $('button[type="submit"]').prop('disabled', false);
            }
        });
    });
});

// Form validation function
function validateForm(data) {
    consoleLog('Validating form data');
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        Swal.fire({
            icon: 'error',
            title: 'שגיאה',
            text: 'נא להזין כתובת אימייל תקינה'
        });
        return false;
    }
    
    // Israeli phone validation
    const phoneRegex = /^0(5[^7]|[2-4]|[8-9]|7[0-9])-?\d{3}-?\d{4}$/;
    if (!phoneRegex.test(data.phone)) {
        Swal.fire({
            icon: 'error',
            title: 'שגיאה',
            text: 'נא להזין מספר טלפון ישראלי תקין (לדוגמה: 052-123-4567)'
        });
        return false;
    }
    
    // Check if all fields are filled
    for (let key in data) {
        if (!data[key]) {
            Swal.fire({
                icon: 'error',
                title: 'שגיאה',
                text: 'נא למלא את כל השדות'
            });
            return false;
        }
    }
    
    return true;
} 