const monthlyData = [
    { month: "Jan", value: 30 },
    { month: "Feb", value: 60 },
    { month: "Mar", value: 45 },
    { month: "Apr", value: 20 },
    { month: "May", value: 35 },
    { month: "Jun", value: 50 },
    { month: "Jul", value: 40 },
    { month: "Aug", value: 70 },
    { month: "Sep", value: 25 },
    { month: "Oct", value: 55 },
    { month: "Nov", value: 40 },
    { month: "Dec", value: 60 },
];

const weeklyData = [
    { week: "Week 1", value: 10 },
    { week: "Week 2", value: 15 },
    { week: "Week 3", value: 20 },
    { week: "Week 4", value: 25 },
];

const dailyData = [
    { day: "Sun", value: 5 },
    { day: "Mon", value: 10 },
    { day: "Tue", value: 15 },
    { day: "Wed", value: 20 },
    { day: "Thu", value: 25 },
    { day: "Fri", value: 30 },
    { day: "Sat", value: 35 },
];

const barChart = document.getElementById("bar-chart");
const buttons = document.querySelectorAll(".view-buttons button");

buttons.forEach(button => {
    button.addEventListener("click", () => {
        const period = button.getAttribute("data-period");
        barChart.innerHTML = ''; // Clear previous bars

        let data;
        if (period === "monthly") {
            data = monthlyData;
        } else if (period === "weekly") {
            data = weeklyData;
        } else if (period === "daily") {
            data = dailyData;
        }

        data.forEach(item => {
            const bar = document.createElement("div");
            bar.classList.add("bar");
            bar.style.height = `${(item.value / 100) * 100}%`; // Change the height according to value
            bar.innerHTML = `<span class="bar-label">${item.value}</span> ${period === "monthly" ? item.month : period === "weekly" ? item.week : item.day}`;
            barChart.appendChild(bar);
        });
    });
});

// Trigger the monthly view on page load
buttons[0].click();


const viewButtons = document.querySelectorAll('.view-buttons button');

// Add event listeners to each button
viewButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove 'active' class from all buttons
        viewButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add 'active' class to the clicked button
        button.classList.add('active');
        
        // Get the selected time period from data-period attribute
        const selectedPeriod = button.getAttribute('data-period');
        
        // Handle functionality based on the selected period
        if (selectedPeriod === 'monthly') {
            // Code for handling Monthly button press
        } else if (selectedPeriod === 'weekly') {
            // Code for handling Weekly button press
        } else if (selectedPeriod === 'daily') {
            // Code for handling Daily button press
        }
    });
});





document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Default view is the month view
        headerToolbar: {
            left: 'prev,next today', // Previous/Next/Today buttons
            center: 'title', // Title in the center
            right: 'dayGridDay,dayGridWeek,dayGridMonth,listYear' // Switch between day, week, month, and year views
        },
        events: [
            {
                title: 'Root Canal',
                start: '2024-10-04T10:30:00',
                end: '2024-10-04T12:30:00'
            },
            {
                title: 'Tooth Extraction',
                start: '2024-10-05T14:00:00',
                end: '2024-10-05T15:00:00'
            }
        ] // Add more events here or fetch them from a server
    });

    calendar.render();
});
