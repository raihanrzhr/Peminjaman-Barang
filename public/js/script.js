// function updateStatus(detailId, status) {
//     fetch(`/borrowings/update/${detailId}`, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({ status: status })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             alert('Status berhasil diperbarui.');
//             location.reload(); // Reload the page to reflect changes
//         } else {
//             alert('Gagal memperbarui status: ' + data.message);
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         alert('Terjadi kesalahan saat memperbarui status.');
//     });
// }

function confirmDelete(deleteUrl) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Delete URL:', deleteUrl); // Debugging line
            fetch(deleteUrl, {
                method: 'DELETE', // Ubah dari POST ke DELETE
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response:', response); // Debugging line
                if (response.ok) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil dihapus.",
                        icon: "success"
                    }).then(() => {
                        location.reload(); // Reload halaman setelah penghapusan
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menghapus data.",
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menghapus data.",
                    icon: "error"
                });
            });
        }
    });
}

function toggleBorrowerFields() {
    const borrowerStatus = document.getElementById('borrower_status').value;
    const borrowerFields = document.getElementById('borrower_fields');
    const borrowerName = document.getElementById('borrower_name');
    const borrowerIdentifier = document.getElementById('borrower_identifier');

    if (borrowerStatus === 'Pegawai Ditmawa') {
        borrowerFields.style.display = 'none'; // Sembunyikan input
        borrowerName.disabled = true; // Nonaktifkan validasi
        borrowerIdentifier.disabled = true; // Nonaktifkan validasi
    } else {
        borrowerFields.style.display = 'block'; // Tampilkan input
        borrowerName.disabled = false; // Aktifkan validasi
        borrowerIdentifier.disabled = false; // Aktifkan validasi
    }
}

function filterItems() {
    const searchInput = document.getElementById('search_item').value.toLowerCase();
    const items = document.querySelectorAll('#item_list .item-row');

    items.forEach(item => {
        const label = item.querySelector('label').textContent.toLowerCase();
        if (label.includes(searchInput)) {
            item.style.display = 'flex'; // Tampilkan item
        } else {
            item.style.display = 'none'; // Sembunyikan item
        }
    });
}

// Auto-upload file & show file name for .auto-upload-form
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.auto-upload-form').forEach(form => {
        const input = form.querySelector('input[type="file"]');
        const fileNameSpan = form.querySelector('.file-name');
        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
                form.submit();
            } else {
                fileNameSpan.textContent = '';
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const fileNameSpan = this.closest('form').querySelector('.file-name');
            if (this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = '';
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#itemsTable tbody tr').forEach(function(row) {
                const name = row.querySelector('.item-name').textContent.toLowerCase();
                const spec = row.querySelector('.item-spec').textContent.toLowerCase();
                row.style.display = (name.includes(filter) || spec.includes(filter)) ? '' : 'none';
            });
        });
    }
});