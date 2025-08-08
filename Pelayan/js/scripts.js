const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})

const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})


// POPUP PESANAN

function openPopup(id) {
    document.getElementById("popup-" + id).style.display = "block";
}
function closePopup(id) {
    document.getElementById("popup-" + id).style.display = "none";
}
window.onclick = function(event) {
    document.querySelectorAll('.popup-modal').forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
};
function filterMeja() {
    const jumlahTamu = parseInt(document.getElementById('guest_count').value);
    const mejaOptions = document.querySelectorAll('#table_number option');
    mejaOptions.forEach(opt => {
        const kapasitas = parseInt(opt.getAttribute('data-kapasitas'));
        opt.style.display = (kapasitas >= jumlahTamu) ? 'block' : 'none';
    });
}


// Memperbaiki Tombol Pesanan (Tambah)

function tambahPesanan(event, idMeja) {
    event.preventDefault();

    const form = document.getElementById('form-tambah-' + idMeja);
    const formData = new FormData(form);

    const food = form.food.value;
    const qty = form.qty.value;

    fetch('tambah_pesanan.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Hapus pesan "Belum ada pesanan" jika ada
            const listGroup = document.querySelector(`#popup-${idMeja} ul.list-group`);
            const kosong = listGroup.querySelector('li.text-muted');
            if (kosong) kosong.remove();

            // Buat <li> baru
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <div>
                    
                    <form onsubmit="updatePesanan(event, this)" class="d-inline-flex align-items-center">
                        <input type="hidden" name="order_id" value="${data.order_id}">
                        <span class="me-2">${data.food}x</span>
                        <input type="number" name="qty" value="${data.qty}" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                        <span class="me-2 badge bg-secondary">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>
                        <button type="submit" class="btn btn-sm btn-success onclick="updatePesanan(${data.order_id}, this)">💾</button>
                    </form>
					
                    <button type="button" class="btn btn-sm btn-danger ms-2" onclick="hapusPesanan(${data.order_id}, this)">❌</button>

                </div>
            `;

            listGroup.appendChild(li);

            // Reset form
            form.reset();
            form.qty.value = 1;
        } else {
            alert("❌ Gagal menambahkan pesanan.");
        }
    })
    .catch(err => {
        console.error(err);
        alert("⚠️ Terjadi kesalahan.");
    });
}


// Memperbaiki Tombol HAPUS Di PopUp

function hapusPesanan(orderId, btn) {
    if (!confirm("Hapus pesanan ini?")) return;

    const formData = new FormData();
    formData.append('order_id', orderId);

    fetch('hapus_pesanan.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const li = btn.closest('li');
            const ul = li.parentElement;
            li.remove();

            if (ul.querySelectorAll('li').length === 0) {
                const kosong = document.createElement('li');
                kosong.className = 'list-group-item text-muted';
                kosong.innerHTML = '<em>Belum ada pesanan</em>';
                ul.appendChild(kosong);
            }
        } else {
            alert("❌ Gagal menghapus pesanan: " + (data.error || ""));
        }
    })
    .catch(error => {
        console.error(error);
        alert("⚠️ Terjadi kesalahan jaringan.");
    });
}

// Perbaiki Kode SAVE

function updatePesanan(event, form) {
    event.preventDefault(); // ⛔ Cegah submit biasa / reload

    const formData = new FormData(form);

    fetch('update.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            alert('✅ Pesanan berhasil diperbarui');
            // opsional: ubah teks status badge jika perlu
            // form.querySelector('.badge').textContent = 'diproses';
        } else {
            alert('❌ Gagal memperbarui: ' + (response.error || 'unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('⚠️ Terjadi kesalahan.');
    });
}





