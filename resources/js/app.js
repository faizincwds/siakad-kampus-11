// Impor CSS eksternal. Ini adalah cara yang benar di Vite.
import "jsvectormap/dist/jsvectormap.min.css";
import "flatpickr/dist/flatpickr.min.css";
import "dropzone/dist/dropzone.css";
import "../css/app.css";

// Impor pustaka pihak ketiga.
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
import Dropzone from "dropzone";


// Gunakan impor dinamis untuk memecah kode (code splitting).
// Ini membantu mengurangi ukuran bundel utama dengan hanya memuat
// komponen yang dibutuhkan saat DOMContentLoaded.
// Ini adalah cara terbaik untuk mengatasi peringatan ukuran bundel yang Anda lihat.

const loadDashboardComponents = async () => {
  try {
    const [
      { default: chart01 },
      { default: chart02 },
      { default: chart03 },
      { default: map01 },
    ] = await Promise.all([
      import("./components/charts/chart-01"),
      import("./components/charts/chart-02"),
      import("./components/charts/chart-03"),
      import("./components/map-01"),
    ]);

    chart01();
    chart02();
    chart03();
    map01();
  } catch (error) {
    console.error("Gagal memuat komponen dashboard:", error);
  }
};

// Impor file JS lainnya.
import "./components/calendar-init.js";
import "./components/image-resize";

// Inisialisasi Alpine.js
Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Inisialisasi Flatpickr
flatpickr(".datepicker", {
  mode: "range",
  static: true,
  monthSelectorType: "static",
  dateFormat: "M j, Y",
  defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
  prevArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  nextArrow:
    '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  onReady: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
  },
});

// Inisialisasi Dropzone
const dropzoneArea = document.querySelectorAll("#demo-upload");

if (dropzoneArea.length) {
  let myDropzone = new Dropzone("#demo-upload", { url: "/file/post" });
}

// Handler saat dokumen dimuat
document.addEventListener("DOMContentLoaded", () => {
  // Panggil fungsi untuk memuat komponen dashboard secara dinamis
  loadDashboardComponents();
});

// Dapatkan tahun saat ini
const year = document.getElementById("year");
if (year) {
  year.textContent = new Date().getFullYear();
}

// Logika untuk fungsionalitas salin (copy)
document.addEventListener("DOMContentLoaded", () => {
  const copyInput = document.getElementById("copy-input");
  if (copyInput) {
    const copyButton = document.getElementById("copy-button");
    const copyText = document.getElementById("copy-text");
    const websiteInput = document.getElementById("website-input");

    copyButton.addEventListener("click", () => {
      // Gunakan document.execCommand('copy') sebagai fallback
      // karena navigator.clipboard.writeText mungkin tidak berfungsi di beberapa iframe
      try {
        const tempInput = document.createElement("input");
        tempInput.value = websiteInput.value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        copyText.textContent = "Disalin";
        setTimeout(() => {
          copyText.textContent = "Salin";
        }, 2000);
      } catch (err) {
        console.error('Gagal menyalin:', err);
        // Tampilkan pesan error jika salin gagal
      }
    });
  }
});
