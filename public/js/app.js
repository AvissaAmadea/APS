// sidebar-toggle
const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function() {
    document.querySelector("#sidebar").classList.toggle("collapsed");
    document.querySelector(".main").classList.toggle("expanded");
});

// Fungsi untuk menampilkan loading indicator
function showLoadingIndicator() {
    document.querySelector('.loading-indicator').style.display = 'flex';
}

// Fungsi untuk menyembunyikan loading indicator
function hideLoadingIndicator() {
    document.querySelector('.loading-indicator').style.display = 'none';
}

// Fungsi untuk mengambil data
function fetchData() {
    showLoadingIndicator(); // Tampilkan loading indicator saat data diambil

    // Simulasi pengambilan data (ganti dengan kode pengambilan data sesungguhnya)
    setTimeout(function () {
        // ... (Proses pengambilan data)

        // Sembunyikan loading indicator setelah data ditampilkan
        hideLoadingIndicator();
    }, 2000); // Ganti dengan waktu pengambilan data
}

// Panggil fungsi fetchData saat halaman dimuat
window.onload = function () {
    fetchData();
};
