 // NOTIFICATION
 function markAllAsRead() {
    fetch('/admin/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            document.querySelectorAll('.unread').forEach(notification => {
                notification.classList.remove('unread');
                notification.classList.add('read');
            });
            document.querySelector('.badge-counter').style.display = 'none';
        }
    });
}

function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            document.querySelector(`[href$="${notificationId}"]`).classList.remove('unread');
            document.querySelector(`[href$="${notificationId}"]`).classList.add('read');
        }
    });
}


// district search
document.getElementById('search').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    let districtRows = document.querySelectorAll('.district-row');

    districtRows.forEach(row => {
        let districtName = row.querySelector('.district-name').textContent.toLowerCase();
        if (districtName.includes(searchValue)) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
});

document.getElementById('reset-search').addEventListener('click', function() {
    document.getElementById('search').value = '';
    let districtRows = document.querySelectorAll('.district-row');
    districtRows.forEach(row => {
        row.classList.remove('hidden');
    });
});

// preview photo in crate and edit Produks
function previewPhoto(input, previewId) {
    var preview = document.getElementById(previewId);
    var file = input.files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.style.display = 'none';
    }
}

function removePhoto(photoId, previewId) {
    document.getElementById(previewId).style.display = 'none';
    document.getElementById('remove_' + photoId).value = "1";
}

// search and filter in produks
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

function filterTable() {
    var filter, table, tr, td, i;
    filter = document.getElementById("filterType").value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[4]; // Kolom kelima untuk filter type
        if (td) {
            if (filter == "" || td.textContent.toUpperCase() == filter) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// add produk in transactions create and edit
