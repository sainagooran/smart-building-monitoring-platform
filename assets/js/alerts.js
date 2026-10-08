const totalAlerts =
    document.querySelector("#total-alerts");

const criticalAlerts =
    document.querySelector("#critical-alerts");

const warningAlerts =
    document.querySelector("#warning-alerts");

const informationAlerts =
    document.querySelector("#information-alerts");

const alertSearch = document.querySelector("#alert-search");
const alertFilter = document.querySelector("#alert-filter");


const alertContainer =
    document.querySelector(".alerts-list");


function loadAlerts() {

    fetch("../api/alerts.php")
        .then(function (response) {
            return response.json();
        })
        .then(function (alerts) {

            console.log("Alerts data:", alerts);

            totalAlerts.textContent = alerts.length;

criticalAlerts.textContent =
    alerts.filter(function (alert) {
        return alert.type.toLowerCase() === "critical";
    }).length;

warningAlerts.textContent =
    alerts.filter(function (alert) {
        return alert.type.toLowerCase() === "warning";
    }).length;

informationAlerts.textContent =
    alerts.filter(function (alert) {
        return alert.type.toLowerCase() === "information";
    }).length;

            alertContainer.innerHTML = "";

            alerts.forEach(function (alert) {

                const alertItem =
                    document.createElement("div");

                alertItem.className = "alert-item";

                alertItem.dataset.type =
                    alert.type;

 alertItem.innerHTML = `
    <div class="alert-icon ${alert.type}">
        !
    </div>

    <div class="alert-content">
        <div class="alert-main">
            <strong>${alert.title}</strong>

            <span>
                ${alert.description}
            </span>
        </div>

        <small>
            ${alert.type}
        </small>
    </div>
`;

                alertContainer.appendChild(
                    alertItem
                );

            });

            updateAlerts();

        })
        .catch(function (error) {

            console.error(
                "Failed to load alerts:",
                error
            );

        });

}


function updateAlerts() {

    const searchValue =
        alertSearch.value.trim().toLowerCase();

    const filterValue =
        alertFilter.value;


    const alertItems =
        document.querySelectorAll(".alert-item");


    alertItems.forEach(function (alert) {

        const alertText =
            alert.textContent
                .trim()
                .toLowerCase();

        const alertType =
            alert.dataset.type;


        const searchMatch =
            searchValue === "" ||
            alertText.includes(searchValue);


        const filterMatch =
            filterValue === "All" ||
            alertType === filterValue;


        if (searchMatch && filterMatch) {

            alert.style.display = "flex";

        } else {

            alert.style.display = "none";

        }

    });

}


if (alertSearch) {

    alertSearch.addEventListener(
        "input",
        updateAlerts
    );

}


if (alertFilter) {

    alertFilter.addEventListener(
        "change",
        updateAlerts
    );

}


loadAlerts();