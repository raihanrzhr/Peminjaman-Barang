function updateStatus(id, status) {
    const url = `/borrowings/update/${id}`;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update the table row directly
            const row = document.querySelector(`#row-${id}`);
            const dateCell = row.querySelector('.tanggal-kembali'); // Pastikan Anda memiliki class ini di sel tanggal kembali
            if (status === 'Dikembalikan') {
                const currentDate = new Date().toLocaleString(); // Ambil waktu saat ini
                dateCell.textContent = currentDate; // Atur tanggal kembali ke waktu sekarang
                row.querySelector('.status-dropdown').value = 'Dikembalikan'; // Set dropdown ke 'Dikembalikan'
            } else {
                dateCell.textContent = ''; // Kosongkan tanggal kembali jika status 'Dipinjam'
                row.querySelector('.status-dropdown').value = 'Dipinjam'; // Set dropdown ke 'Dipinjam'
            }
        } else {
            alert('Gagal memperbarui status.');
        }
    })
    .catch(error => console.error('Error:', error));
}
