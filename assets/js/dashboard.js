// Dashboard data

fetch("api/dashboard.php")
    .then(function(response) {
        return response.json();
    })
    .then(function(result) {

        if (result.success) {

            document.querySelector("#energy-consumption").textContent =
                result.data.energy.energy_consumption + " kWh";

            document.querySelector("#active-devices").textContent =
                result.data.devices.online_devices + " / " +
                result.data.devices.total_devices;

            document.querySelector("#alerts-count").textContent =
                result.data.alerts.total_alerts;
        }
    })
    .catch(function(error) {
        console.error("Dashboard error:", error);
    });


// Temperature value

fetch("api/temperature.php")
    .then(function(response) {
        return response.json();
    })
    .then(function(result) {

        if (result.success && result.data.length > 0) {

            var latest =
                result.data[result.data.length - 1].temperature;

            document.querySelector("#temperature-value").textContent =
                latest + " °C";
        }
    })
    .catch(function(error) {
        console.error("Temperature error:", error);
    });


    
// Energy chart

var energyArea = document.querySelector(
    ".chart-card:first-child .chart-placeholder"
);

if (energyArea) {

    energyArea.innerHTML = "";

    var energyCanvas = document.createElement("canvas");

    energyArea.appendChild(energyCanvas);

    fetch("api/energy.php")
        .then(function(response) {
            return response.json();
        })
        .then(function(result) {

            console.log("Energy data:", result);

            if (result.length > 0) {

                var energyData = [];
                var energyLabels = [];

                result.forEach(function(item) {

                    energyData.push(
                        parseFloat(item.energy_consumption)
                    );

                    energyLabels.push(
                        item.recorded_at.substring(11, 16)
                    );
                });

                console.log("Energy values:", energyData);

                new Chart(energyCanvas, {

                    type: "line",

                    data: {
                        labels: energyLabels,

                        datasets: [{
                            label: "Energy Consumption",
                            data: energyData,
                            borderColor: "#5A5E27",
                            backgroundColor: "rgba(90, 94, 39, 0.15)",
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            }
                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: "#b8b69a"
                                }
                            },

                            y: {
                                beginAtZero: true,

                                ticks: {
                                    color: "#b8b69a",

                                    callback: function(value) {
                                        return value + " kWh";
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })
        .catch(function(error) {
            console.error("Energy chart error:", error);
        });
}
// Temperature chart

var temperatureArea = document.querySelector(
    ".chart-card:nth-child(2) .chart-placeholder"
);

if (temperatureArea) {

    temperatureArea.innerHTML = "";

    var temperatureCanvas = document.createElement("canvas");

    temperatureArea.appendChild(temperatureCanvas);

    fetch("api/temperature.php")
        .then(function(response) {
            return response.json();
        })
        .then(function(result) {

            if (result.success && result.data.length > 0) {

                var values = [];
                var labels = [];

                result.data.forEach(function(item) {

                    values.push(
                        parseFloat(item.temperature)
                    );

                    labels.push(
                        item.recorded_at.substring(11, 16)
                    );
                });

                console.log("Temperature:", values);

                new Chart(temperatureCanvas, {

                    type: "line",

                    data: {
                        labels: labels,

                        datasets: [{
                            label: "Temperature",
                            data: values,
                            borderColor: "#640017",
                            backgroundColor: "rgba(100, 0, 23, 0.12)",
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            }
                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: "#b8b69a"
                                }
                            },

                            y: {
                                suggestedMin: 18,
                                suggestedMax: 26,

                                ticks: {
                                    color: "#b8b69a",

                                    callback: function(value) {
                                        return value + " °C";
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })
        .catch(function(error) {
            console.error("Temperature chart error:", error);
        });
}