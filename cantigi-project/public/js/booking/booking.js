let currentVehicleId = null;
let currentVehiclePrice = 0;
let selectedStartDate = null;
let selectedEndDate = null;
let currentDate = new Date();
let selectionMode = "start";

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".booking-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
            const vehicleId = button.dataset.vehicleId;
            const vehicleName = button.dataset.vehicleName;
            const vehicleImage = button.dataset.vehicleImage;
            const vehiclePrice = parseInt(button.dataset.vehiclePrice, 10);

            // Note: bookingUrl gw ilangin pemakaiannya kalau ga dipake,
            // atau bisa lu tambahin lagi kalau emang dibutuhin.

            openBookingModal(
                vehicleId,
                vehicleName,
                vehicleImage,
                vehiclePrice,
            );
        });
    });
});

const monthNames = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

function openBookingModal(vehicleId, vehicleName, vehicleImage, pricePerDay) {
    currentVehicleId = vehicleId;
    currentVehiclePrice = pricePerDay;

    // Set info kendaraan
    document.getElementById("modalVehicleName").textContent = vehicleName;
    document.getElementById("modalVehicleImage").src = vehicleImage;
    document.getElementById("modalVehiclePrice").textContent =
        `Rp${pricePerDay.toLocaleString("id-ID")}/hari`;

    // Reset pilihan tanggal
    selectedStartDate = null;
    selectedEndDate = null;
    selectionMode = "start";

    // Bersihkan input form
    document.getElementById("startDate").value = "";
    document.getElementById("endDate").value = "";

    // Sembunyikan pesan error & total
    document.getElementById("totalSection").classList.add("hidden");
    document.getElementById("errorMessage").classList.add("hidden");

    // Tampilkan modal dengan animasi
    const modal = document.getElementById("bookingModal");
    const modalContent = document.getElementById("modalContent");

    modal.classList.remove("hidden");

    setTimeout(() => {
        modal.classList.remove("opacity-0");
        modal.classList.add("opacity-100");
        modalContent.classList.remove("scale-95");
        modalContent.classList.add("scale-100");
    }, 10);

    generateCalendar();
}

function closeBookingModal() {
    const modal = document.getElementById("bookingModal");
    const modalContent = document.getElementById("modalContent");

    modal.classList.remove("opacity-100");
    modal.classList.add("opacity-0");
    modalContent.classList.remove("scale-100");
    modalContent.classList.add("scale-95");

    setTimeout(() => {
        modal.classList.add("hidden");
    }, 300);
}

function generateCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    document.getElementById("currentMonth").textContent =
        `${monthNames[month]} ${year}`;

    const calendarGrid = document.getElementById("calendarGrid");
    calendarGrid.innerHTML = "";

    const dayHeaders = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
    dayHeaders.forEach((day) => {
        const dayHeader = document.createElement("div");
        dayHeader.className =
            "text-center text-sm font-medium text-gray-500 p-2";
        dayHeader.textContent = day;
        calendarGrid.appendChild(dayHeader);
    });

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.className = "p-2";
        calendarGrid.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dayCell = document.createElement("div");
        const cellDate = new Date(year, month, day);

        const isPast = cellDate < today;
        const isSelected = isDateSelected(cellDate);
        const isInRange = isDateInRange(cellDate);

        // Logika styling lengkungan dari obrolan sebelumnya
        const isStart =
            selectedStartDate &&
            cellDate.getTime() === selectedStartDate.getTime();
        const isEnd =
            selectedEndDate && cellDate.getTime() === selectedEndDate.getTime();

        dayCell.className = "py-2 text-center cursor-pointer transition-all";

        if (isPast) {
            dayCell.className += " text-gray-300 cursor-not-allowed rounded-lg";
        } else if (isSelected) {
            dayCell.className += " bg-blue-500 text-white";

            if (isStart && selectedEndDate && !isEnd) {
                dayCell.className += " rounded-l-lg";
            } else if (isEnd && selectedStartDate && !isStart) {
                dayCell.className += " rounded-r-lg";
            } else {
                dayCell.className += " rounded-lg";
            }
        } else if (isInRange) {
            dayCell.className += " bg-blue-200 text-blue-800";
        } else {
            dayCell.className += " hover:bg-blue-100 rounded-lg";
        }

        dayCell.textContent = day;

        if (!isPast) {
            dayCell.addEventListener("click", () => selectDate(cellDate));
        }

        calendarGrid.appendChild(dayCell);
    }
}

function isDateSelected(date) {
    return (
        (selectedStartDate && date.getTime() === selectedStartDate.getTime()) ||
        (selectedEndDate && date.getTime() === selectedEndDate.getTime())
    );
}

function isDateInRange(date) {
    if (!selectedStartDate || !selectedEndDate) return false;
    return date > selectedStartDate && date < selectedEndDate;
}

function selectDate(date) {
    hideError();

    if (selectionMode === "start") {
        selectedStartDate = date;
        selectedEndDate = null;
        selectionMode = "end";
        document.getElementById("startDate").value = formatDate(date);
        document.getElementById("endDate").value = "";
        document.getElementById("totalSection").classList.add("hidden");
    } else {
        // Handle kalau user klik tanggal akhir yang lebih kecil dari tanggal awal
        if (date < selectedStartDate) {
            selectedEndDate = selectedStartDate;
            selectedStartDate = date;
        } else {
            selectedEndDate = date;
        }
        selectionMode = "start";
        document.getElementById("startDate").value =
            formatDate(selectedStartDate);
        document.getElementById("endDate").value = formatDate(selectedEndDate);
        calculateTotal();
    }

    generateCalendar();
}

function formatDate(date) {
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function calculateTotal() {
    if (selectedStartDate && selectedEndDate) {
        const timeDiff =
            selectedEndDate.getTime() - selectedStartDate.getTime();
        let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        // Kalau pilih tanggal yang sama, hitung sebagai 1 hari booking
        if (dayDiff === 0) {
            dayDiff = 1;
        }

        const totalPrice = dayDiff * currentVehiclePrice;

        document.getElementById("totalDays").textContent = `${dayDiff} hari`;
        document.getElementById("totalPrice").textContent =
            `Rp${totalPrice.toLocaleString("id-ID")}`;

        document.getElementById("totalSection").classList.remove("hidden");
    }
}

function showError(message) {
    document.getElementById("errorText").textContent = message;
    document.getElementById("errorMessage").classList.remove("hidden");
    document.getElementById("totalSection").classList.add("hidden");
}

function hideError() {
    document.getElementById("errorMessage").classList.add("hidden");
}

function submitBooking() {
    if (!selectedStartDate || !selectedEndDate) {
        showError("Silakan pilih tanggal mulai dan selesai");
        return;
    }

    const phoneNumber = "6283180200916";
    const vehicleName = document.getElementById("modalVehicleName").textContent;

    const startDateFormatted = selectedStartDate.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });

    const endDateFormatted = selectedEndDate.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });

    // Kalkulasi ulang buat dimunculin di chat WA biar lebih informatif
    const timeDiff = selectedEndDate.getTime() - selectedStartDate.getTime();
    let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if (dayDiff === 0) dayDiff = 1;
    const totalPrice = dayDiff * currentVehiclePrice;

    const message = `Halo, saya ingin memesan kendaraan berikut:

Kendaraan: *${vehicleName}*
Tanggal Mulai: *${startDateFormatted}*
Tanggal Selesai: *${endDateFormatted}*
Total Durasi: *${dayDiff} Hari*
Estimasi Harga: *Rp${totalPrice.toLocaleString("id-ID")}*

Mohon konfirmasi ketersediaannya. Terima kasih!`;

    const encodedMessage = encodeURIComponent(message);
    const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

    window.open(whatsappURL, "_blank");
}

// Navigasi bulan kalender
document.getElementById("prevMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    generateCalendar();
});

document.getElementById("nextMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    generateCalendar();
});

// Tutup modal kalau klik area luar
document.getElementById("bookingModal").addEventListener("click", (e) => {
    if (e.target === document.getElementById("bookingModal")) {
        closeBookingModal();
    }
});

// Support tombol ESC di keyboard buat nutup modal
document.addEventListener("keydown", (e) => {
    if (
        e.key === "Escape" &&
        !document.getElementById("bookingModal").classList.contains("hidden")
    ) {
        closeBookingModal();
    }
});
