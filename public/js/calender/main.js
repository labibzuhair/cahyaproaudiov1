(function ($) {
    "use strict";

    $(document).ready(function () {
        var date = new Date();
        var today = date.getDate();
        $(".right-button").click({ date: date }, next_year);
        $(".left-button").click({ date: date }, prev_year);
        $(".month").click({ date: date }, month_click);
        $(".months-row")
            .children()
            .eq(date.getMonth())
            .addClass("active-month");
        init_calendar(date);
        load_transactions(); // Pastikan transaksi dimuat setelah inisialisasi kalender
    });

    function init_calendar(date) {
        $(".tbody").empty();
        $(".events-container").empty();
        $(".details-container").hide();
        var calendar_days = $(".tbody");
        var month = date.getMonth();
        var year = date.getFullYear();
        var day_count = days_in_month(month, year);
        var row = $("<tr class='table-row'></tr>");
        var today = date.getDate();
        date.setDate(1);
        var first_day = date.getDay();
        for (var i = 0; i < 35 + first_day; i++) {
            var day = i - first_day + 1;
            if (i % 7 === 0) {
                calendar_days.append(row);
                row = $("<tr class='table-row'></tr>");
            }
            if (i < first_day || day > day_count) {
                var curr_date = $("<td class='table-date nil'>" + "</td>");
                row.append(curr_date);
            } else {
                var curr_date = $("<td class='table-date'>" + day + "</td>");
                var events = check_events(day, month + 1, year);
                if (today === day && $(".active-date").length === 0) {
                    curr_date.addClass("active-date");
                    show_events(events, months[month], day);
                }
                if (events.length !== 0) {
                    curr_date.addClass("event-date");
                }
                curr_date.click(
                    { events: events, month: months[month], day: day },
                    date_click
                );
                row.append(curr_date);
            }
        }
        calendar_days.append(row);
        $(".year").text(year);
    }

    function days_in_month(month, year) {
        var monthStart = new Date(year, month, 1);
        var monthEnd = new Date(year, month + 1, 1);
        return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
    }

    function date_click(event) {
        $(".events-container").show(250);
        $("#dialog").hide(250);
        $(".active-date").removeClass("active-date");
        $(this).addClass("active-date");
        show_events(event.data.events, event.data.month, event.data.day);
    }

    function month_click(event) {
        $(".events-container").show(250);
        $("#dialog").hide(250);
        var date = event.data.date;
        $(".active-month").removeClass("active-month");
        $(this).addClass("active-month");
        var new_month = $(".month").index(this);
        date.setMonth(new_month);
        init_calendar(date);
        load_transactions(); // Periksa transaksi setiap kali bulan berubah
    }

    function next_year(event) {
        $("#dialog").hide(250);
        var date = event.data.date;
        var new_year = date.getFullYear() + 1;
        $(".year").text(new_year); // Pastikan elemen tahun diperbarui
        date.setFullYear(new_year);
        init_calendar(date);
        load_transactions(); // Periksa transaksi setiap kali tahun berubah
    }

    function prev_year(event) {
        $("#dialog").hide(250);
        var date = event.data.date;
        var new_year = date.getFullYear() - 1;
        $(".year").text(new_year); // Pastikan elemen tahun diperbarui
        date.setFullYear(new_year);
        init_calendar(date);
        load_transactions(); // Periksa transaksi setiap kali tahun berubah
    }

// Fungsi untuk mengambil produk yang dipilih
function getSelectedProducts() {
    let selectedProducts = [];
    $("#products .product-group").each(function () {
        let selectedProduct = $(this).find("select").val();
        if (selectedProduct) {
            selectedProducts.push(selectedProduct);
        }
    });
    return selectedProducts;
}

// Fungsi untuk mengecek apakah ada produk yang sama disewa pada tanggal yang sama
function checkProductAvailability(date, rentals, selectedProductIds) {
    const conflictingProducts = [];

    rentals.forEach((rental) => {
        if (rental.rental_date <= date && rental.return_date >= date) {
            selectedProductIds.forEach((productId) => {
                if (rental.produk.id == productId) {
                    conflictingProducts.push(rental.produk);
                }
            });
        }
    });

    return conflictingProducts;
}



    function highlight_rentals(transactions) {
        const colors = ["rental-date-a", "rental-date-b", "rental-date-c"];

        // Urutkan transaksi berdasarkan tanggal rental_date secara ascending
        transactions.sort(
            (a, b) =>
                new Date(a.rentals[0].rental_date) -
                new Date(b.rentals[0].rental_date)
        );

        transactions.forEach((transaction, index) => {
            const colorClass = colors[index % colors.length];
            transaction.rentals.forEach((rental) => {
                let rentalDate = new Date(rental.rental_date);
                let returnDate = new Date(rental.return_date);
                while (rentalDate <= returnDate) {
                    let day = rentalDate.getDate();
                    let month = rentalDate.getMonth();
                    let year = rentalDate.getFullYear();
                    $(`.table-date:contains(${day})`)
                        .filter(function () {
                            return (
                                $(this).text() == day.toString() &&
                                !$(this).hasClass("nil") &&
                                $(".year").text() == year.toString() &&
                                $(".months-row .active-month").index() == month
                            );
                        })
                        .each(function () {
                            // Hapus semua kelas warna sebelumnya dan tambahkan yang baru
                            $(this)
                                .removeClass(colors.join(" "))
                                .addClass(colorClass)
                                .attr(
                                    "data-transaction",
                                    JSON.stringify(transaction)
                                )
                            .data("original-class", `table-date ${colorClass}`);
                        });
                    rentalDate.setDate(rentalDate.getDate() + 1);
                }
            });
        });

        $(document).on("click", ".table-date", function () {

            // Kembalikan semua tanggal menjadi kelas asli mereka
            $(".table-date").each(function () {
                var originalClass = $(this).data("original-class");
                if (originalClass) {
                    $(this).attr("class", originalClass);
                } else {
                    $(this).removeClass("active-date");
                }
            });

            // Tambahkan highlight aktif pada tanggal yang diklik
            $(this).removeClass("rental-date-a rental-date-b rental-date-c").addClass("active-date");
        });

        $(document).on(
            "click",
            ".table-date.rental-date-a, .table-date.rental-date-b, .table-date.rental-date-c",
            function () {
                var transaction = JSON.parse($(this).attr("data-transaction"));
                show_events(transaction.rentals);
            }
        );


        if (window.location.pathname.includes('/admin/transactions/create')) {
            $(document).on("click", ".table-date", function () {
                let day = $(this).text();
                let month = $(".months-row .active-month").index() + 1;
                let year = $(".year").text();
                let selectedDate = `${year}-${month < 10 ? "0" + month : month}-${day < 10 ? "0" + day : day}`;

                const selectedProductIds = getSelectedProducts();
                const conflictingProducts = checkProductAvailability(selectedDate, rentals, selectedProductIds);

                if (conflictingProducts.length > 0) {
                    const productNames = conflictingProducts.map((product) => product.name).join(" dan ");
                    const placeholderMessage = `Produk ${productNames} sedang disewa pada tanggal tersebut.`;
                    $("#rental_date").val("").attr("placeholder", placeholderMessage);
                } else {
                    $("#rental_date").val(selectedDate).attr("placeholder", "Tanggal Rental");
                }
            });
        }

    }

    function show_events(rentals, month, day) {
        $(".events-container").empty();
        $(".events-container").show(250);
        if (rentals.length === 0) {
            var rental_card = $("<div class='event-card'></div>");
            var rental_name = $(
                "<div class='event-name'>Tidak ada persewaan yang direncanakan untuk " +
                    month +
                    " " +
                    day +
                    ".</div>"
            );
            $(rental_card).css({ "border-left": "10px solid #32CD32" });
            $(rental_card).append(rental_name);
            $(".events-container").append(rental_card);
        } else {
            for (var i = 0; i < rentals.length; i++) {
                var rental_card = $("<div class='event-card'></div>");
                var rental_details = $(
                    "<table class='rental-details'>" +
                        "<tr><th>Mulai Sewa</th><td>" +
                        rentals[i]["rental_date"] +
                        "</td></tr>" +
                        "<tr><th>Pengembalian</th><td>" +
                        rentals[i]["return_date"] +
                        "</td></tr>" +
                        "<tr><th>Nama Order</th><td>" +
                        rentals[i]["order_name"] +
                        "</td></tr>" +
                        "<tr><th>WhatsApp</th><td>" +
                        rentals[i]["order_whatsapp"] +
                        "</td></tr>" +
                        "<tr><th>Alamat Pemasangan</th><td>" +
                        rentals[i]["installation_address"] +
                        "</td></tr>" +
                        "<tr><th>Status</th><td>" +
                        rentals[i]["status"] +
                        "</td></tr>" +
                        "</table>"
                );

                // Tambahkan atribut data-id dan event click untuk menuju ke halaman transaksi
                $(rental_card)
                    .attr("data-id", rentals[i]["transaction_id"])
                    .css({ "border-left": "10px solid #32CD32" })
                    .append(rental_details)
                    .click(function () {
                        var transactionId = $(this).data("id");

                        // Navigasi ke halaman transaksi
                        window.location.href =
                            "/admin/transactions/" + transactionId;
                    });

                $(".events-container").append(rental_card);
            }
        }
    }

    $(document).on("click", ".table-date.rental-date", function () {
        var transaction = JSON.parse($(this).attr("data-transaction"));
        show_events(transaction.rentals, $(this).data("month"), $(this).text());
    });

    function check_events(day, month, year) {
        var events = [];
        for (var i = 0; i < event_data["events"].length; i++) {
            var event = event_data["events"][i];
            if (
                event["day"] === day &&
                event["month"] === month &&
                event["year"] === year
            ) {
                events.push(event);
            }
        }
        return events;
    }

    function load_transactions() {
        $.ajax({
            url: "/fetch-transactions", // URL untuk fetch transaksi
            method: "GET",
            success: function (data) {
                highlight_rentals(data);
            },
            error: function (error) {
                console.error("Error fetching transactions:", error);
            },
        });
    }

    load_transactions();
})(jQuery);

const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

var event_data = {
    events: [
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
            cancelled: true,
        },
        {
            occasion: "Repeated Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 10,
        },
        {
            occasion: "Test Event",
            invited_count: 120,
            year: 2020,
            month: 5,
            day: 11,
        },
    ],
};

// input tanggal with calender
