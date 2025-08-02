document.addEventListener('DOMContentLoaded', function () {
    const $ = jQuery;

    // Normal Filter Submit
    $('#normal-filter-form').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serializeArray();
        const params = {};
        formData.forEach(field => params[field.name] = field.value);
        loadEvents(params);
    });

    // Reset Normal Filter
    $('#reset-normal-filter').on('click', function (e) {
        e.preventDefault();
        $('#normal-filter-form')[0].reset();
        loadEvents();
    });

   $('#ajax-pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        window.loadEvents({ paged: page });
    });

    // Reset Calendar
    $('#reset-calendar').on('click', function (e) {
        e.preventDefault();
        loadEvents();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const resetButton = document.querySelector('.reset-btn');
    if (resetButton) {
        resetButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = window.location.pathname; 
            // This reloads the page without query parameters
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const resetBtn = document.querySelector('.reset-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Build the base URL (remove query parameters)
            let url = window.location.origin + window.location.pathname;
            
            // Redirect to the same page but without filters
            window.location.href = url;
        });
    }
});

// window.loadEvents = function (params = {}) {
//     $.post(calendarData.ajaxurl, { action: 'load_events', ...params }, function (response) {
//         $('#ajax-events').html(response.html);

//         if (response.max_pages > 1) {
//             let currentPage = params.paged ? parseInt(params.paged) : 1;
//             let totalPages = response.max_pages;
//             let pagHtml = '<div class="pagination-inner" role="navigation">';

//             // Prev Button
//             if (currentPage > 1) {
//                 pagHtml += `<a class="prev page-numbers page-link" data-page="${currentPage - 1}" href="#">
//                     <img src="images/right-arrow.svg" alt="icon">
//                 </a>`;
//             }

//             // Page Numbers
//             for (let i = 1; i <= totalPages; i++) {
//                 if (i === currentPage) {
//                     pagHtml += `<span aria-current="page" class="page-numbers current">${i}</span>`;
//                 } else {
//                     pagHtml += `<a class="page-numbers page-link" data-page="${i}" href="#">${i}</a>`;
//                 }
//             }

//             // Next Button
//             if (currentPage < totalPages) {
//                 pagHtml += `<a class="next page-numbers page-link" data-page="${currentPage + 1}" href="#">
//                     <img src="images/right-arrow.svg" alt="icon">
//                 </a>`;
//             }

//             pagHtml += '</div>';
//             $('#ajax-pagination').html(pagHtml);
//         } else {
//             $('#ajax-pagination').empty();
//         }
//     });
// };


// 	// Calender js

// 	const calendar = flatpickr("#calendar", {
//     inline: true,
//     "locale": "pl",
//     onDayCreate: function(dObj, dStr, fp, dayElem) {
//         const date = dayElem.dateObj.toLocaleDateString('sv-SE');
//         if (events.includes(date)) {
//             dayElem.classList.add("event-day");
//         }
//     },
//     onReady: function(selectedDates, dateStr, instance) {
//         createCustomHeader(instance);
//     },
//     onMonthChange: function(selectedDates, dateStr, instance) {
//         updateCustomMonthLabel(instance);
//     },
//     onYearChange: function(selectedDates, dateStr, instance) {
//         updateCustomMonthLabel(instance);
//     }
// });

// // Add event listener for date click
// if (typeof calendar !== 'undefined' && calendar.config) {
//     calendar.config.onChange.push(function (selectedDates, dateStr) {
//         if (dateStr) {
//             console.log("Selected date from calendar:", dateStr);
//            window.loadEvents({ calendar_date: dateStr });
//         }
//     });
// }