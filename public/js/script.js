function updateStatus(detailId, status) {
    fetch(`/borrowings/update/${detailId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status berhasil diperbarui.');
            location.reload(); // Reload the page to reflect changes
        } else {
            alert('Gagal memperbarui status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui status.');
    });
}

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