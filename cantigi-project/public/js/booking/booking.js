
let currentVehicleId = null;
let currentVehiclePrice = 0;
let selectedStartDate = null;
let selectedEndDate = null;
let selectedStartTime = null;
let selectedEndTime = null;
let currentDate = new Date();
let selectionMode = "start";
let bookedDates = [];

function openAuthModal() {
    const modal = document.getElementById("authModal");
    const modalContent = document.getElementById("authModalContent");
    modal.classList.remove("hidden");
    setTimeout(() => {
        modal.classList.remove("opacity-0");
        modalContent.classList.remove("scale-95");
    }, 10);
}

function closeAuthModal() {
    const modal = document.getElementById("authModal");
    const modalContent = document.getElementById("authModalContent");
    modal.classList.add("opacity-0");
    modalContent.classList.add("scale-95");
    setTimeout(() => modal.classList.add("hidden"), 300);
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".booking-btn").forEach((button) => {
        button.addEventListener("click", function () {
            if (event.target.matches(".booking-btn")) {
                const button = event.target;
                if (window.App.isUserLoggedIn) {
                    const vehicleId = button.dataset.vehicleId;
                    const vehicleName = button.dataset.vehicleName;
                    const vehicleImage = button.dataset.vehicleImage;
                    const vehiclePrice = parseInt(
                        button.dataset.vehiclePrice,
                        10
                    );
                    bookingUrl = button.dataset.bookingUrl; // ✨ Get the URL from the button

                    let existingBookings = [];
                    try {
                        existingBookings = JSON.parse(
                            button.dataset.existingBookings || "[]"
                        );
                    } catch (e) {
                        console.error("Error parsing existing bookings:", e);
                    }

                    openBookingModal(
                        vehicleId,
                        vehicleName,
                        vehicleImage,
                        vehiclePrice,
                        existingBookings
                    );
                } else {
                    openAuthModal();
                }
            }
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

// Time options from 07:00 to 16:00
const timeOptions = [
    "08:00",
    "08:30",
    "09:00",
    "09:30",
    "10:00",
    "10:30",
    "11:00",
    "11:30",
    "12:00",
    "12:30",
    "13:00",
    "13:30",
    "14:00",
    "14:30",
    "15:00",
    "15:30",
    "16:00",
];

function populateTimeOptions() {
    const startTimeSelect = document.getElementById("startTime");
    const endTimeSelect = document.getElementById("endTime");

    // Clear existing options except the first one
    startTimeSelect.innerHTML = '<option value="">Pilih waktu mulai</option>';
    endTimeSelect.innerHTML = '<option value="">Pilih waktu selesai</option>';

    // Add time options
    timeOptions.forEach((time) => {
        const startOption = document.createElement("option");
        startOption.value = time;
        startOption.textContent = time;
        startTimeSelect.appendChild(startOption);

        const endOption = document.createElement("option");
        endOption.value = time;
        endOption.textContent = time;
        endTimeSelect.appendChild(endOption);
    });
}

function validateTimeSelection() {
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;

    if (!startTime || !endTime) {
        return true; // Skip validation if times not selected
    }

    // Convert time to minutes for comparison
    const startMinutes = timeToMinutes(startTime);
    const endMinutes = timeToMinutes(endTime);

    // Check if it's same day booking
    const isSameDay =
        selectedStartDate &&
        selectedEndDate &&
        selectedStartDate.getTime() === selectedEndDate.getTime();

    if (isSameDay) {
        // For same day booking, end time must be at least 2 hours after start time
        const minEndMinutes = startMinutes + 120; // 2 hours = 120 minutes

        if (endMinutes <= startMinutes) {
            showError("Waktu selesai harus lebih dari waktu mulai");
            return false;
        }

        if (endMinutes < minEndMinutes) {
            showError("Minimal booking 2 jam");
            return false;
        }
    }

    return true;
}

function timeToMinutes(time) {
    const [hours, minutes] = time.split(":").map(Number);
    return hours * 60 + minutes;
}

function minutesToTime(minutes) {
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${hours.toString().padStart(2, "0")}:${mins
        .toString()
        .padStart(2, "0")}`;
}

function openBookingModal(
    vehicleId,
    vehicleName,
    vehicleImage,
    pricePerDay,
    existingBookings
) {
    currentVehicleId = vehicleId;
    currentVehiclePrice = pricePerDay;
    bookedDates = existingBookings || [];

    // Set vehicle info
    document.getElementById("modalVehicleName").textContent = vehicleName;
    document.getElementById("modalVehicleImage").src = vehicleImage;
    document.getElementById(
        "modalVehiclePrice"
    ).textContent = `Rp${pricePerDay.toLocaleString("id-ID")}/hari`;

    // Reset selections
    selectedStartDate = null;
    selectedEndDate = null;
    selectedStartTime = null;
    selectedEndTime = null;
    selectionMode = "start";

    // Clear form inputs
    document.getElementById("startDate").value = "";
    document.getElementById("endDate").value = "";
    document.getElementById("startTime").value = "";
    document.getElementById("endTime").value = "";

    // Hide sections
    document.getElementById("totalSection").classList.add("hidden");
    document.getElementById("errorMessage").classList.add("hidden");

    // Populate time options
    populateTimeOptions();

    // Show modal with animation
    const modal = document.getElementById("bookingModal");
    const modalContent = document.getElementById("modalContent");

    modal.classList.remove("hidden");

    setTimeout(() => {
        modal.classList.remove("opacity-0");
        modal.classList.add("opacity-100");
        modalContent.classList.remove("scale-95");
        modalContent.classList.add("scale-100");
    }, 10);

    // Generate calendar
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

    document.getElementById(
        "currentMonth"
    ).textContent = `${monthNames[month]} ${year}`;

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

        // Create a date for the PREVIOUS day to check its booking status
        const previousDay = new Date(year, month, day - 1);

        const isPast = cellDate < today;
        const isBooked = isDateBooked(cellDate);
        // Check if the day before the current one is booked
        const isPreviousDayBooked = isDateBooked(previousDay);
        const isSelected = isDateSelected(cellDate);
        const isInRange = isDateInRange(cellDate);

        dayCell.className = `p-2 text-center cursor-pointer rounded-lg transition-all`;

        // If the current day OR the previous day is booked, disable it
        if (isBooked || isPreviousDayBooked) {
            dayCell.className += " bg-red-500 text-white cursor-not-allowed";
            dayCell.title = isBooked
                ? "Tanggal sudah dibooking"
                : "Tidak tersedia";
        } else if (isPast) {
            dayCell.className += " text-gray-300 cursor-not-allowed";
        } else if (isSelected) {
            dayCell.className += " bg-blue-500 text-white";
        } else if (isInRange) {
            dayCell.className += " bg-blue-200 text-blue-800";
        } else {
            dayCell.className += " hover:bg-blue-100";
        }

        dayCell.textContent = day;

        // Add the click event listener only if the date is not in the past,
        // not booked, AND the previous day is not booked.
        if (!isPast && !isBooked && !isPreviousDayBooked) {
            dayCell.addEventListener("click", () => selectDate(cellDate));
        }

        calendarGrid.appendChild(dayCell);
    }
}

function isDateBooked(date) {
    const checkDate = new Date(date);
    checkDate.setHours(0, 0, 0, 0);

    return bookedDates.some((booking) => {
        const startDate = new Date(booking.start_date);
        const endDate = new Date(booking.end_date);

        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);

        return checkDate >= startDate && checkDate <= endDate;
    });
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

        // Clear time selections when date changes
        document.getElementById("startTime").value = "";
        document.getElementById("endTime").value = "";
    } else {
        if (date <= selectedStartDate) {
            selectedEndDate = selectedStartDate;
            selectedStartDate = date;
        } else {
            selectedEndDate = date;
        }

        if (checkDateOverlap(selectedStartDate, selectedEndDate)) {
            showError(
                "Tanggal yang dipilih tidak tersedia karena bertabrakan dengan booking yang sudah ada. Silakan pilih tanggal lain."
            );
            selectedStartDate = null;
            selectedEndDate = null;
            selectionMode = "start";
            document.getElementById("startDate").value = "";
            document.getElementById("endDate").value = "";
        } else {
            selectionMode = "start";
            document.getElementById("startDate").value =
                formatDate(selectedStartDate);
            document.getElementById("endDate").value =
                formatDate(selectedEndDate);
            calculateTotal();
        }
    }

    generateCalendar();
}

function checkDateOverlap(startDate, endDate) {
    return bookedDates.some((booking) => {
        const bookedStart = new Date(booking.start_date);
        const bookedEnd = new Date(booking.end_date);

        return startDate <= bookedEnd && endDate >= bookedStart;
    });
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
        const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
        const totalPrice = dayDiff * currentVehiclePrice;

        document.getElementById("totalDays").textContent = `${dayDiff} hari`;
        document.getElementById(
            "totalPrice"
        ).textContent = `Rp${totalPrice.toLocaleString("id-ID")}`;

        // Update time display
        updateTimeDisplay();

        document.getElementById("totalSection").classList.remove("hidden");
    }
}

function updateTimeDisplay() {
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;
    const timeDisplay = document.getElementById("totalTime");

    if (startTime && endTime) {
        const isSameDay =
            selectedStartDate &&
            selectedEndDate &&
            selectedStartDate.getTime() === selectedEndDate.getTime();

        if (isSameDay) {
            timeDisplay.textContent = `${startTime} - ${endTime}`;
        } else {
            timeDisplay.textContent = `${startTime} (mulai) - ${endTime} (selesai)`;
        }
    } else {
        timeDisplay.textContent = "-";
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

    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;

    if (!startTime || !endTime) {
        showError("Silakan pilih waktu mulai dan selesai");
        return;
    }

    if (!validateTimeSelection()) {
        return;
    }

    // --- VALIDATION ADDED HERE ---

    // 1. Prevent booking on the same day as today
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time for accurate date comparison

    if (selectedStartDate.getTime() === today.getTime()) {
        showError(
            "Pemesanan tidak bisa dimulai pada hari ini. Silakan pilih tanggal lain."
        );
        return;
    }

    // 2. Prevent same-day booking (minimum 1 day rental)
    if (selectedEndDate.getTime() === selectedStartDate.getTime()) {
        showError(
            "Minimal durasi pemesanan adalah 1 hari. Tanggal selesai tidak boleh sama dengan tanggal mulai."
        );
        return;
    }

    // --- END OF VALIDATION ---

    // Show loading state
    const submitButton = document.querySelector(
        'button[onclick="submitBooking()"]'
    );
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = "Memproses...";

    const formData = new FormData();
    formData.append("vehicle_id", currentVehicleId);
    formData.append(
        "start_booking_date",
        selectedStartDate.toISOString().split("T")[0]
    );
    formData.append(
        "end_booking_date",
        selectedEndDate.toISOString().split("T")[0]
    );
    formData.append("start_booking_time", startTime);
    formData.append("end_booking_time", endTime);
    formData.append('_token', window.App.csrfToken);

    // Option 1: Using the exact route URL
    fetch(bookingUrl, {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest", // Important for Laravel to detect AJAX
            Accept: "application/json", // Ensure JSON response
        },
    })
        .then((response) => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success && data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                showError(data.message || "An unknown error occurred.");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat memproses booking: " + error.message);
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
}

// Event listeners for time selection
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("startTime")
        .addEventListener("change", function () {
            selectedStartTime = this.value;
            updateTimeDisplay();
            if (!validateTimeSelection()) {
                this.value = "";
                selectedStartTime = null;
            }
        });

    document.getElementById("endTime").addEventListener("change", function () {
        selectedEndTime = this.value;
        updateTimeDisplay();
        if (!validateTimeSelection()) {
            this.value = "";
            selectedEndTime = null;
        }
    });
});

// Navigation buttons
document.getElementById("prevMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    generateCalendar();
});

document.getElementById("nextMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    generateCalendar();
});

// Close modal when clicking outside
document.getElementById("bookingModal").addEventListener("click", (e) => {
    if (e.target === document.getElementById("bookingModal")) {
        closeBookingModal();
    }
});

// Keyboard support
document.addEventListener("keydown", (e) => {
    if (
        e.key === "Escape" &&
        !document.getElementById("bookingModal").classList.contains("hidden")
    ) {
        closeBookingModal();
    }
});
