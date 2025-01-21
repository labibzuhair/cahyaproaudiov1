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

    function show_events(events, month, day) {
        $(".events-container").empty();
        $(".events-container").show(250);
        if (events.length === 0) {
            var event_card = $("<div class='event-card'></div>");
            var event_name = $(
                "<div class='event-name'>There are no events planned for " +
                    month +
                    " " +
                    day +
                    ".</div>"
            );
            $(event_card).css({ "border-left": "10px solid #FF1744" });
            $(event_card).append(event_name);
            $(".events-container").append(event_card);
        } else {
            for (var i = 0; i < events.length; i++) {
                var event_card = $("<div class='event-card'></div>");
                var event_name = $(
                    "<div class='event-name'>" +
                        events[i]["occasion"] +
                        ":</div>"
                );
                var event_count = $(
                    "<div class='event-count'>" +
                        events[i]["invited_count"] +
                        " Invited</div>"
                );
                if (events[i]["cancelled"] === true) {
                    $(event_card).css({ "border-left": "10px solid #FF1744" });
                    event_count = $(
                        "<div class='event-cancelled'>Cancelled</div>"
                    );
                }
                $(event_card).append(event_name).append(event_count);
                $(".events-container").append(event_card);
            }
        }
    }

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

    // Cek rental dates untuk highlight hijau
    function highlight_rentals(transactions) {
        transactions.forEach((transaction) => {
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
                        .addClass("rental-date")
                        .attr("data-transaction", JSON.stringify(transaction));
                    rentalDate.setDate(rentalDate.getDate() + 1);
                }
            });
        });
    }

    $(document).on("click", ".table-date.rental-date", function () {
        var transaction = JSON.parse($(this).attr("data-transaction"));
        $("#transaction-details").html(`
        <p>Order Name: ${transaction.order_name}</p>
        <p>WhatsApp: ${transaction.order_whatsapp}</p>
        <p>Installation Address: ${transaction.installation_address}</p>
        <p>District: ${transaction.district}</p>
        <p>Total Amount: ${transaction.total_amount}</p>
        <p>Status: ${transaction.status}</p>
      `);

        $(".details-container").show();
    });

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
