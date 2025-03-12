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
            const row = document.querySelector(`#row-${id}`);
            const dateCell = row.querySelector('.tanggal-kembali');
            if (status === 'Dikembalikan') {
                const now = new Date();
                const formattedDate = now.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                dateCell.textContent = formattedDate;
                row.querySelector('.status-dropdown').value = 'Dikembalikan';
            } else {
                dateCell.textContent = '';
                row.querySelector('.status-dropdown').value = 'Dipinjam';
            }
        } else {
            alert('Gagal memperbarui status.');
        }
    })
    .catch(error => console.error('Error:', error));
}
