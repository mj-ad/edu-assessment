$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('input', function() {
        const name = $(this).val();
        $.get(`/students/search?name=${name}`, function(data) {
            $('#studentList').empty();
            data.forEach(student => {
                $('#studentList').append(`
                    <li>
                        ${student.first_name} ${student.last_name} (Reg No: ${student.reg_no})
                        <a href="/students/${student.id}">View</a>
                        <a href="/students/${student.id}/edit">Edit</a>
                        <span class="fee-status" data-id="${student.id}" data-status="${student.fee_status}">
                            ${student.fee_status === 'unpaid' ? 'Owing' : 'Paid'}
                        </span>
                    </li>
                `);
            });
        });
    });

    // Fee status modal
    $(document).on('click', '.fee-status', function() {
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'unpaid' ? 'paid' : 'unpaid';
        $('#feeStatusModal').data('id', id).data('status', newStatus).css('display', 'block');
    });

    $('.close').on('click', function() {
        $('#feeStatusModal').css('display', 'none');
    });

    $('#confirmFeeStatus').on('click', function() {
        const id = $('#feeStatusModal').data('id');
        const feeStatus = $('#feeStatusModal').data('status');
        $.ajax({
            url: `/students/feestatus/${id}`,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({ fee_status: feeStatus }),
            success: function() {
                $('#feeStatusModal').css('display', 'none');
                // $('#searchInput').trigger('input'); // Refresh list
            },
            error: function(xhr) {
                alert(JSON.parse(xhr.responseText).error);
            }
        });
    });
});