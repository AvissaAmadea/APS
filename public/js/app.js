// sidebar-toggle
const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function() {
    document.querySelector("#sidebar").classList.toggle("collapsed");
    document.querySelector(".main").classList.toggle("expanded");
});

// pada form pengembalian untuk melaporkan rusak/hilang
function showKeteranganRusakBukti() {
    if (document.getElementById('rusakYa').checked || document.getElementById('hilangYa').checked) {
        showKeteranganRusak();
        showBukti();
    } else {
        hideKeteranganRusak();
        hideBukti();
    }
}

function hideKeteranganRusakBukti() {
    if (!document.getElementById('rusakYa').checked && !document.getElementById('hilangYa').checked) {
        hideKeteranganRusak();
        hideBukti();
    } else if (!document.getElementById('rusakYa').checked && document.getElementById('hilangYa').checked) {
        hideKeteranganRusak();
    } else if (document.getElementById('rusakYa').checked && !document.getElementById('hilangYa').checked) {
        hideBukti();
    }
}

function showKeteranganHilangBukti() {
    if (document.getElementById('hilangYa').checked) {
        showKeteranganHilang();
        showBukti();
    } else {
        hideKeteranganHilang();
    }
}

function hideKeteranganHilangBukti() {
    if (!document.getElementById('hilangYa').checked && !document.getElementById('rusakYa').checked) {
        hideKeteranganHilang();
        hideBukti();
    } else if (!document.getElementById('hilangYa').checked && document.getElementById('rusakYa').checked) {
        hideKeteranganHilang();
    } else if (document.getElementById('hilangYa').checked && !document.getElementById('rusakYa').checked) {
        hideBukti();
    }
}

function showKeteranganRusak() {
    document.getElementById('keteranganRusak').style.display = 'flex';
}

function hideKeteranganRusak() {
    document.getElementById('keteranganRusak').style.display = 'none';
}

function showKeteranganHilang() {
    document.getElementById('keteranganHilang').style.display = 'flex';
}

function hideKeteranganHilang() {
    document.getElementById('keteranganHilang').style.display = 'none';
}

function showBukti() {
    document.getElementById('bukti').style.display = 'flex';
}

function hideBukti() {
    document.getElementById('bukti').style.display = 'none';
}

// form alasan tolak
function toggleAlasanTolakPeminjaman() {
    const statusPinjamRadios = document.querySelectorAll('input[name="status_pinjam"]');
    const alasanTolakPinjam = document.getElementById('alasanTolakPinjam');

    statusPinjamRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (radio.value === 'Ditolak') {
                alasanTolakPinjam.style.display = 'block';
            } else {
                alasanTolakPinjam.style.display = 'none';
            }
        });
    });
}

// Panggil fungsi jika DOM sudah dimuat
document.addEventListener("DOMContentLoaded", toggleAlasanTolakPeminjaman);

function toggleAlasanTolakPengembalian() {
    const statusPinjamRadios = document.querySelectorAll('input[name="status_kembali"]');
    const alasanTolakKembali = document.getElementById('alasanTolakKembali');

    statusPinjamRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (radio.value === 'Ditolak') {
                alasanTolakKembali.style.display = 'block';
            } else {
                alasanTolakKembali.style.display = 'none';
            }
        });
    });
}

// Panggil fungsi jika DOM sudah dimuat
document.addEventListener("DOMContentLoaded", toggleAlasanTolakPengembalian);


    // Dapatkan elemen textarea
    // var textarea1 = document.getElementById('detail');
    // var textarea2 = document.getElementById('tujuan');

    // // Buat fungsi untuk menyesuaikan tinggi textarea
    // var adjustHeight = function(textarea) {
    //     textarea.addEventListener('input', function() {
    //         // Tetapkan lineHeight jika belum ditetapkan
    //         var lineHeight = textarea.style.lineHeight;
    //         if (!lineHeight) {
    //             lineHeight = 20; // Ganti dengan nilai yang Anda inginkan
    //         }

    //         // Hitung jumlah baris dengan membagi tinggi elemen dengan tinggi satu baris
    //         var numberOfLines = textarea.scrollHeight / lineHeight;

    //         // Atur tinggi textarea sesuai dengan jumlah baris
    //         var newHeight = numberOfLines * lineHeight;

    //         // Tambahkan batas atas dan bawah untuk tinggi textarea
    //         var minHeight = 80; // Ganti dengan nilai yang Anda inginkan
    //         var maxHeight = 100; // Ganti dengan nilai yang Anda inginkan
    //         if (newHeight < minHeight) {
    //             newHeight = minHeight;
    //         } else if (newHeight > maxHeight) {
    //             newHeight = maxHeight;
    //         }

    //         textarea.style.height = newHeight + 'px';
    //     });
    // };

    // // Panggil fungsi untuk setiap textarea
    // adjustHeight(textarea1);
    // adjustHeight(textarea2);


// function autoExpand(textarea) {
//     textarea.style.height = 'auto';
//     textarea.style.height = textarea.scrollHeight + 'px';
// }

// Fungsi untuk menampilkan loading indicator
// function showLoadingIndicator() {
//     document.querySelector('.loading-indicator').style.display = 'flex';
// }

// // Fungsi untuk menyembunyikan loading indicator
// function hideLoadingIndicator() {
//     document.querySelector('.loading-indicator').style.display = 'none';
// }

// // Fungsi untuk mengambil data
// function fetchData() {
//     showLoadingIndicator(); // Tampilkan loading indicator saat data diambil

//     // Simulasi pengambilan data (ganti dengan kode pengambilan data sesungguhnya)
//     setTimeout(function () {
//         // ... (Proses pengambilan data)

//         // Sembunyikan loading indicator setelah data ditampilkan
//         hideLoadingIndicator();
//     }, 2000); // Ganti dengan waktu pengambilan data
// }

// // Panggil fungsi fetchData saat halaman dimuat
// window.onload = function () {
//     fetchData();
// };
