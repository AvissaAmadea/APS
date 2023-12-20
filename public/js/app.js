// sidebar-toggle
const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function() {
    document.querySelector("#sidebar").classList.toggle("collapsed");
    document.querySelector(".main").classList.toggle("expanded");
});

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
