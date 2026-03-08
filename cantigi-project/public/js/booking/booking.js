let currentVehicleId = null;
let currentVehiclePrice = 0;
let selectedStartDate = null;
let selectedEndDate = null;
let currentDate = new Date();
let selectionMode = "start";

// Global vars for Best Deal & Bus
let currentIsBestDeal = false;
let currentCarType = "reguler";
let currentBestDealPrices = {};
let currentBusRoute = null; // Store selected bus route object

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".booking-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
            const vehicleId = button.dataset.vehicleId;
            const vehicleName = button.dataset.vehicleName;
            const vehicleImage = button.dataset.vehicleImage;
            const vehiclePrice = parseInt(button.dataset.vehiclePrice, 10);
            
            const isBestDeal = button.dataset.isBestDeal;
            const carType = button.dataset.carType;
            const bestDealPrices = {
                drop: button.dataset.hargaDrop,
                city: button.dataset.hargaCity,
                full: button.dataset.hargaFull,
                luarKota: button.dataset.hargaLuarKota
            };

            openBookingModal(
                vehicleId,
                vehicleName,
                vehicleImage,
                vehiclePrice,
                isBestDeal,
                carType,
                bestDealPrices
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

function openBookingModal(vehicleId, vehicleName, vehicleImage, pricePerDay, isBestDeal, carType, bestDealPrices) {
    currentVehicleId = vehicleId;
    currentVehiclePrice = pricePerDay;
    currentIsBestDeal = isBestDeal === 'true';
    currentCarType = carType || "reguler";
    currentBestDealPrices = bestDealPrices || {};
    currentBusRoute = null;

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

    // Reset Options
    document.getElementById("serviceType").value = "lepas_kunci";
    document.getElementById("driverArea").value = "150000";
    document.getElementById("droppingRoute").value = "100000";
    document.getElementById("driverAreaSection").classList.add("hidden");
    document.getElementById("droppingRouteSection").classList.add("hidden");

    // Reset Bus Options
    document.getElementById("kategoriRute").value = "";
    document.getElementById("pilihanRute").innerHTML = '<option value="" disabled selected>Pilih Rute spesifik...</option>';
    document.getElementById("pilihanRuteContainer").classList.add("hidden");
    document.getElementById("busMinHariInfo").textContent = "Sewa bus akan mengikuti ketentuan minimum hari berdasarkan rute yang dipilih.";

    const isBus = ['hiace_elf', 'medium', 'of', 'oh'].includes(currentCarType);

    // UI Toggle for Regular / Best Deal / Bus
    if (isBus) {
        document.getElementById("regularServiceContainer").classList.add("hidden");
        document.getElementById("bestDealContainer").classList.add("hidden");
        document.getElementById("busServiceContainer").classList.remove("hidden");

        // Kalau bus, kita ga tunjukin harga reguler default di modal header
        document.getElementById("modalVehiclePrice").textContent = `Pilih rute untuk melihat tarif`;
    } else if (currentIsBestDeal) {
        document.getElementById("regularServiceContainer").classList.add("hidden");
        document.getElementById("bestDealContainer").classList.remove("hidden");
        document.getElementById("busServiceContainer").classList.add("hidden");
        
        // Populate options based on dataset
        document.getElementById("opt_drop_bandara").textContent = `Drop Bandara (Rp ${parseInt(currentBestDealPrices.drop).toLocaleString('id-ID')} / 1x Jalan)`;
        document.getElementById("opt_city_tour").textContent = `City Tour 8 Jam (Rp ${parseInt(currentBestDealPrices.city).toLocaleString('id-ID')} / hari)`;
        document.getElementById("opt_full_day").textContent = `Full Day 12 Jam (Rp ${parseInt(currentBestDealPrices.full).toLocaleString('id-ID')} / hari)`;
        document.getElementById("opt_luar_kota").textContent = `Luar Kota (Rp ${parseInt(currentBestDealPrices.luarKota).toLocaleString('id-ID')} / hari)`;
        
        document.getElementById("bestDealPackage").value = "city_tour"; // Default for best deal
    } else {
        document.getElementById("regularServiceContainer").classList.remove("hidden");
        document.getElementById("bestDealContainer").classList.add("hidden");
        document.getElementById("busServiceContainer").classList.add("hidden");
    }

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

        const isBus = ['hiace_elf', 'medium', 'of', 'oh'].includes(currentCarType);

        if (isBus && currentBusRoute) {
            if (dayDiff < currentBusRoute.min_hari) {
                showError(`Rute Bus ini mewajibkan sewa minimal ${currentBusRoute.min_hari} hari. Silakan ubah tanggal. (Terpilih: ${dayDiff} hari)`);
                return; // Stop rendering the total calculation
            }
        }
        hideError(); // Clean up previous error if day diff gets valid

        let totalPrice = 0;

        if (isBus) {
            if (!currentBusRoute) {
                // Jangan show calculation kalau rute belum dipilih
                document.getElementById("totalSection").classList.add("hidden");
                return;
            }
            
            // Find price based on car/bus type
            const busPriceItem = currentBusRoute.prices.find(p => p.tipe_bus === currentCarType);
            const busPrice = busPriceItem ? busPriceItem.harga : 0;
            
            totalPrice = busPrice * dayDiff;
            document.getElementById("totalDays").textContent = `${dayDiff} hari (Min. ${currentBusRoute.min_hari} hari)`;
        } else if (currentIsBestDeal) {
            const packageType = document.getElementById("bestDealPackage").value;
            let packagePrice = 0;
            
            if (packageType === "drop_bandara") {
                packagePrice = parseInt(currentBestDealPrices.drop, 10);
                totalPrice = packagePrice; // flat
                document.getElementById("totalDays").textContent = `- (1x Jalan)`;
            } else {
                if (packageType === "city_tour") packagePrice = parseInt(currentBestDealPrices.city, 10);
                if (packageType === "full_day") packagePrice = parseInt(currentBestDealPrices.full, 10);
                if (packageType === "luar_kota") packagePrice = parseInt(currentBestDealPrices.luarKota, 10);
                
                totalPrice = packagePrice * dayDiff;
                document.getElementById("totalDays").textContent = `${dayDiff} hari`;
            }
        } else {
            let additionalServicePrice = 0;
            const serviceType = document.getElementById("serviceType").value;
            if (serviceType === "sewa_driver") {
                const driverPricePerDay = parseInt(document.getElementById("driverArea").value, 10);
                additionalServicePrice = driverPricePerDay * dayDiff;
            } else if (serviceType === "dropping") {
                const droppingPriceFlat = parseInt(document.getElementById("droppingRoute").value, 10);
                additionalServicePrice = droppingPriceFlat;
            }
    
            totalPrice = (dayDiff * currentVehiclePrice) + additionalServicePrice;
            document.getElementById("totalDays").textContent = `${dayDiff} hari`;
        }
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

    const isBus = ['hiace_elf', 'medium', 'of', 'oh'].includes(currentCarType);

    if (isBus && currentBusRoute) {
        if (dayDiff < currentBusRoute.min_hari) {
            showError(`Rute Bus ini mewajibkan sewa minimal ${currentBusRoute.min_hari} hari. Silakan ubah tanggal.`);
            return; 
        }
    }

    let message = `Halo, saya ingin memesan kendaraan berikut:\n\n`;

    if (isBus) {
        if (!currentBusRoute) {
            showError("Silakan pilih rute bus spesifik.");
            return;
        }

        const busPriceItem = currentBusRoute.prices.find(p => p.tipe_bus === currentCarType);
        const busPrice = busPriceItem ? busPriceItem.harga : 0;
        const totalPrice = busPrice * dayDiff;

        message += `Bus Pariwisata: *${vehicleName}*\n`;
        message += `Tanggal Mulai: *${startDateFormatted}*\n`;
        message += `Tanggal Selesai: *${endDateFormatted}*\n`;
        message += `Total Durasi: *${dayDiff} Hari (Min. ${currentBusRoute.min_hari} hari)*\n\n`;
        message += `Kategori Rute: *${currentBusRoute.kategori.replace('_', ' ').toUpperCase()}*\n`;
        message += `Rute Spesifik: *${currentBusRoute.rute}*\n`;
        message += `Estimasi Harga Total: *Rp${totalPrice.toLocaleString("id-ID")}*\n\n`;
        message += `Mohon konfirmasi ketersediaannya. Terima kasih!`;
        
    } else if (currentIsBestDeal) {
        const packageType = document.getElementById("bestDealPackage").value;
        const packageSelect = document.getElementById("bestDealPackage");
        const packageText = packageSelect.options[packageSelect.selectedIndex].text.split(" (Rp")[0];

        let totalPrice = 0;
        let finalDays = `${dayDiff} Hari`;
        if (packageType === "drop_bandara") {
            totalPrice = parseInt(currentBestDealPrices.drop, 10);
            finalDays = '1x Jalan';
        } else {
            if (packageType === "city_tour") totalPrice = parseInt(currentBestDealPrices.city, 10) * dayDiff;
            if (packageType === "full_day") totalPrice = parseInt(currentBestDealPrices.full, 10) * dayDiff;
            if (packageType === "luar_kota") totalPrice = parseInt(currentBestDealPrices.luarKota, 10) * dayDiff;
        }

        message += `Kendaraan: *${vehicleName}* - 🔥 *BEST DEAL*\n`;
        message += `Tanggal Mulai: *${startDateFormatted}*\n`;
        message += `Tanggal Selesai: *${endDateFormatted}*\n`;
        message += `Total Durasi: *${finalDays}*\n\n`;
        message += `Paket Pilihan: *${packageText}*\n`;
        message += `Estimasi Harga Total: *Rp${totalPrice.toLocaleString("id-ID")}*\n\n`;
        message += `Mohon konfirmasi ketersediaannya. Terima kasih!`;

    } else {
        let additionalServicePrice = 0;
        const serviceType = document.getElementById("serviceType").value;
        let serviceText = "Lepas Kunci";
        let detailText = "-";
        
        if (serviceType === "sewa_driver") {
            const driverPricePerDay = parseInt(document.getElementById("driverArea").value, 10);
            additionalServicePrice = driverPricePerDay * dayDiff;
            
            const driverAreaSelect = document.getElementById("driverArea");
            const areaText = driverAreaSelect.options[driverAreaSelect.selectedIndex].text.split(" (+")[0];
            serviceText = "Sewa + Driver";
            detailText = areaText;
        } else if (serviceType === "dropping") {
            const droppingPriceFlat = parseInt(document.getElementById("droppingRoute").value, 10);
            additionalServicePrice = droppingPriceFlat;
            
            const droppingRouteSelect = document.getElementById("droppingRoute");
            const routeText = droppingRouteSelect.options[droppingRouteSelect.selectedIndex].text.split(" (+")[0];
            serviceText = "Dropping";
            detailText = routeText;
        }
    
        const totalVehiclePrice = dayDiff * currentVehiclePrice;
        const totalPrice = totalVehiclePrice + additionalServicePrice;
    
        message += `Kendaraan: *${vehicleName}*\n`;
        message += `Tanggal Mulai: *${startDateFormatted}*\n`;
        message += `Tanggal Selesai: *${endDateFormatted}*\n`;
        message += `Total Durasi: *${dayDiff} Hari*\n\n`;
        message += `Tipe Layanan: *${serviceText}*\n`;
        message += `Detail Rute/Area: *${detailText}*\n`;
        message += `Biaya Layanan Tambahan: *Rp${additionalServicePrice.toLocaleString("id-ID")}*\n\n`;
        message += `Estimasi Harga Total: *Rp${totalPrice.toLocaleString("id-ID")}*\n\n`;
        message += `Mohon konfirmasi ketersediaannya. Terima kasih!`;
    }

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

// Event Listener Tipe Layanan
document.getElementById("serviceType").addEventListener("change", function (e) {
    const driverAreaSection = document.getElementById("driverAreaSection");
    const droppingRouteSection = document.getElementById("droppingRouteSection");
    
    if (e.target.value === "sewa_driver") {
        driverAreaSection.classList.remove("hidden");
        droppingRouteSection.classList.add("hidden");
    } else if (e.target.value === "dropping") {
        driverAreaSection.classList.add("hidden");
        droppingRouteSection.classList.remove("hidden");
    } else {
        driverAreaSection.classList.add("hidden");
        droppingRouteSection.classList.add("hidden");
    }
    calculateTotal();
});

document.getElementById("driverArea").addEventListener("change", function () {
    calculateTotal();
});

document.getElementById("droppingRoute").addEventListener("change", function () {
    calculateTotal();
});

document.getElementById("bestDealPackage").addEventListener("change", function () {
    calculateTotal();
});

// Event Listeners for Bus Routes Cascading Logic
document.getElementById("kategoriRute").addEventListener("change", function(e) {
    const categoryName = e.target.value;
    const routeSelect = document.getElementById("pilihanRute");
    const routeWrapper = document.getElementById("pilihanRuteContainer");
    
    // Check if JSON bus routes is globally defined
    if(typeof window.busRoutesData === "undefined") {
        console.error("busRoutesData is not defined. Make sure @json($busRoutes) is working in Blade.");
        return;
    }

    // Pastikan type comparison aman (jadikan lowercase semua)
    const activeCarType = currentCarType ? currentCarType.toLowerCase() : "";

    // Filter bus routes match with category
    const filteredRoutes = window.busRoutesData.filter(r => r.kategori === categoryName);
    
    // Reset dropdown
    routeSelect.innerHTML = '<option value="" disabled selected>Pilih Rute spesifik...</option>';
    
    let hasValidOptions = false;

    if (filteredRoutes.length > 0) {
        filteredRoutes.forEach(r => {
            // Find specific price for current displayed car_type bus
            // Pakai toLowerCase() biar aman kalau data di DB beda casing
            const itemPriceInfo = (r.prices || []).find(p => p.tipe_bus.toLowerCase() === activeCarType);
            
            const hargaDisplayed = itemPriceInfo ? itemPriceInfo.harga : 0;
            
            // Generate option text only if the specific bus type price is exist
            if (hargaDisplayed > 0) {
                const opt = document.createElement("option");
                opt.value = r.id;
                opt.textContent = `${r.rute} (Rp ${parseInt(hargaDisplayed).toLocaleString('id-ID')} / hari)`;
                routeSelect.appendChild(opt);
                hasValidOptions = true;
            }
        });
        
        // Remove hidden class if options exist
        if (hasValidOptions) {
            routeWrapper.classList.remove("hidden");
        } else {
            routeWrapper.classList.add("hidden");
            // Kasih tau user kalo rute di kategori ini harganya belum di-set buat bus tipe ini
            routeSelect.innerHTML = '<option value="" disabled selected>Tidak ada rute tersedia untuk tipe bus ini.</option>';
            routeWrapper.classList.remove("hidden"); // Tetap tampilkan pesan kosong
        }
    } else {
        routeWrapper.classList.add("hidden");
    }

    currentBusRoute = null; // Reset selection Object
    document.getElementById("busMinHariInfo").textContent = "Sewa bus akan mengikuti ketentuan minimum hari berdasarkan rute yang dipilih.";
    calculateTotal();
});

document.getElementById("pilihanRute").addEventListener("change", function(e) {
    const selectedRouteId = parseInt(e.target.value);
    currentBusRoute = window.busRoutesData.find(r => r.id === selectedRouteId);
    
    if (currentBusRoute) {
        document.getElementById("busMinHariInfo").innerHTML = `<b>Pemberitahuan:</b> Rute <i>${currentBusRoute.rute}</i> membutuhkan batas minimal sewa <b>${currentBusRoute.min_hari} hari</b>.`;
    }
    
    calculateTotal();
});

// Logic Real-time Search & Filter Component UI //
let currentActiveFilter = 'all';

function filterVehiclesUI() {
    const searchVal = document.getElementById("vehicleSearchInput") ? document.getElementById("vehicleSearchInput").value.toLowerCase() : "";
    const cards = document.querySelectorAll('.vehicle-card');
    
    cards.forEach(card => {
        // Karena DOM ini dibuild php foreach, kita tangkap info card dari btn di dalamnya
        const btn = card.querySelector('.booking-btn');
        if (!btn) return;
        
        const carName = btn.dataset.vehicleName.toLowerCase();
        const carType = btn.dataset.carType;
        const isBestDeal = btn.dataset.isBestDeal === 'true';

        // Tentukan apakah memenuhi syarat filter kategori
        let matchFilter = false;
        if (currentActiveFilter === 'all') {
            matchFilter = true;
        } else if (currentActiveFilter === 'bus') {
            matchFilter = ['hiace_elf', 'medium', 'of', 'oh'].includes(carType);
        } else if (currentActiveFilter === 'best_deal') {
            matchFilter = isBestDeal;
        } else if (currentActiveFilter === 'reguler') {
            const isBusCheck = ['hiace_elf', 'medium', 'of', 'oh'].includes(carType);
            matchFilter = !isBusCheck && !isBestDeal;
        }

        // Tentukan apakah memenuhi syarat string search input
        const matchSearch = carName.includes(searchVal);

        if (matchFilter && matchSearch) {
            // Un-hide parent container card (.slide -> section ..)
            card.parentElement.closest('.slide').classList.remove("hidden"); 
            card.classList.remove("hidden");
        } else {
            card.classList.add("hidden");
        }
    });
}

// Attach Search Listeners
if (document.getElementById("vehicleSearchInput")) {
    document.getElementById("vehicleSearchInput").addEventListener("input", filterVehiclesUI);
}

// Attach Filter Buttons Click Handlers
const filterBtns = document.querySelectorAll('.filter-btn');
filterBtns.forEach(fbtn => {
    fbtn.addEventListener('click', function(e) {
        // Update active class UI 
        filterBtns.forEach(b => {
            b.classList.remove('bg-green-500', 'text-white', 'active');
            b.classList.add('bg-gray-100', 'text-gray-600');
        });
        
        this.classList.remove('bg-gray-100', 'text-gray-600');
        this.classList.add('bg-green-500', 'text-white', 'active');
        
        // Save current filter param
        currentActiveFilter = this.dataset.filter;
        
        // Execute Filtering
        filterVehiclesUI();
        
        // Opsional: krn kita pake slider, kalo filter applied semua card mending display grid langsung di slide 0 
        // Logicnya akan menutupi behavior default slider. Buat UX ini kita abaikan sementara page-nya.
    });
});
