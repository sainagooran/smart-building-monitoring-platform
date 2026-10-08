const energyChart = document.querySelector("#energyChart");

fetch("../api/energy.php")
    .then(function (response) {
        return response.json();
    })
    .then(function (energyData) {

        console.log("Energy data:", energyData);

        const labels = energyData.map(function (item) {
            return item.recorded_at;
        });

        const values = energyData.map(function (item) {
            return parseFloat(item.energy_consumption);
        });

        new Chart(energyChart, {
            type: "line",

            data: {
                labels: labels,

                datasets: [
                    {
                        label: "Energy Consumption (kWh)",

                        data: values,

                        borderColor: "#5A5E27",

                        backgroundColor: "rgba(90, 94, 39, 0.12)",

                        borderWidth: 2,

                        tension: 0.35,

                        fill: true,

                        pointRadius: 3,

                        pointBackgroundColor: "#EFEFC9"
                    }
                ]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: true,

                        labels: {
                            color: "#b8b69a"
                        }
                    }

                },

                scales: {

                    x: {
                        ticks: {
                            color: "#b8b69a"
                        },

                        grid: {
                            color: "rgba(239, 239, 201, 0.05)"
                        }
                    },

                    y: {

                        beginAtZero: true,

                        ticks: {
                            color: "#b8b69a"
                        },

                        grid: {
                            color: "rgba(239, 239, 201, 0.05)"
                        }

                    }

                }

            }

        });

    })
    .catch(function (error) {

        console.error(
            "Failed to load energy data:",
            error
        );

    });