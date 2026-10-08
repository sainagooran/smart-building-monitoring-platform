const searchInput = document.querySelector(".device-search input");
const filterSelect = document.querySelector(".device-filter select");

const addDeviceButton = document.querySelector(".add-device-btn");
const addDeviceForm = document.querySelector(".add-device-form");
const cancelDeviceButton = document.querySelector(".cancel-device-btn");
const saveDeviceButton = document.querySelector(".save-device-btn");

const deviceNameInput = document.querySelector("#device-name");
const deviceTypeInput = document.querySelector("#device-type");
const deviceLocationInput = document.querySelector("#device-location");
const deviceStatusInput = document.querySelector("#device-status");

const deviceTableBody = document.querySelector(".device-table tbody");

const deviceModal = document.querySelector("#device-modal");
const closeDeviceModal = document.querySelector(".close-device-modal");

const detailName = document.querySelector("#detail-name");
const detailType = document.querySelector("#detail-type");
const detailLocation = document.querySelector("#detail-location");
const detailStatus = document.querySelector("#detail-status");
const detailUpdate = document.querySelector("#detail-update");

let editingRow = null;


/* -------------------------
   Search and Filter
------------------------- */

function updateDevices() {

    const searchValue =
        searchInput.value.trim().toLowerCase();

    const filterValue =
        filterSelect.value;

    const rows =
        document.querySelectorAll(".device-table tbody tr");

    rows.forEach(function (row) {

        const rowText =
            row.textContent.toLowerCase();

        const statusElement =
            row.querySelector(".status");

        const statusValue = statusElement
            ? statusElement.textContent.trim().toLowerCase()
            : "";

        const searchMatch =
            searchValue === "" ||
            rowText.includes(searchValue);

        let filterMatch = true;

        if (filterValue === "Online") {
            filterMatch = statusValue === "online";
        }

        if (filterValue === "Offline") {
            filterMatch = statusValue === "offline";
        }

        if (filterValue === "Warning") {
            filterMatch = statusValue === "warning";
        }

        row.style.display =
            searchMatch && filterMatch ? "" : "none";

    });
}


/* -------------------------
   Update Device Summary
------------------------- */

function updateSummary() {

    const rows =
        document.querySelectorAll(".device-table tbody tr");

    let total = 0;
    let online = 0;
    let offline = 0;
    let warning = 0;

    rows.forEach(function (row) {

        total++;

        const status =
            row.querySelector(".status");

        if (!status) {
            return;
        }

        const statusValue =
            status.textContent.trim().toLowerCase();

        if (statusValue === "online") {
            online++;
        }

        if (statusValue === "offline") {
            offline++;
        }

        if (statusValue === "warning") {
            warning++;
        }

    });

    document.querySelector("#total-devices").textContent =
        total;

    document.querySelector("#online-devices").textContent =
        online;

    document.querySelector("#offline-devices").textContent =
        offline;

    document.querySelector("#warning-devices").textContent =
        warning;

}


/* -------------------------
   Open Add Device
------------------------- */

addDeviceButton.addEventListener("click", function () {

    editingRow = null;

    addDeviceForm.style.display = "block";

    document.querySelector(".form-title").textContent =
        "Add New Device";

    saveDeviceButton.textContent =
        "Add Device";

    deviceNameInput.value = "";
    deviceTypeInput.value = "";
    deviceLocationInput.value = "";
    deviceStatusInput.value = "Online";

});


/* -------------------------
   Cancel
------------------------- */

cancelDeviceButton.addEventListener("click", function () {

    editingRow = null;

    addDeviceForm.style.display = "none";

});


/* -------------------------
   Save Device
------------------------- */

saveDeviceButton.addEventListener("click", function () {

    const deviceName =
        deviceNameInput.value.trim();

    const deviceType =
        deviceTypeInput.value;

    const deviceLocation =
        deviceLocationInput.value;

    const deviceStatus =
        deviceStatusInput.value;


    if (
        deviceName === "" ||
        deviceType === "" ||
        deviceLocation === ""
    ) {

        alert("Please fill in all required fields.");

        return;

    }
if (editingRow === null) {

    const formData = new URLSearchParams();

    formData.append("name", deviceName);
    formData.append("type", deviceType);
    formData.append("location", deviceLocation);
    formData.append("status", deviceStatus);

    fetch("../api/devices.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {

        if (data.success) {

            alert("Device added successfully.");

            loadDevices();

            addDeviceForm.style.display = "none";

            deviceNameInput.value = "";
            deviceTypeInput.value = "";
            deviceLocationInput.value = "";
            deviceStatusInput.value = "Online";

        } else {

            alert("Failed to add device.");

        }

    })
    .catch(function (error) {

        console.error(error);

        alert("Connection error.");

    });

    return;
}
// start
    let statusClass = "online";

    if (deviceStatus === "Offline") {
        statusClass = "offline";
    }

    if (deviceStatus === "Warning") {
        statusClass = "warning";
    }


    /* -------------------------
       Edit Existing Device
    ------------------------- */

    if (editingRow !== null) {

        const deviceId =
    editingRow.dataset.deviceId;

const formData =
    new URLSearchParams();

formData.append("action", "update");
formData.append("id", deviceId);
formData.append("name", deviceName);
formData.append("type", deviceType);
formData.append("location", deviceLocation);
formData.append("status", deviceStatus);

fetch("../api/devices.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    body: formData
})
.then(function (response) {
    return response.json();
})
.then(function (data) {

    if (data.success) {

        alert("Device updated successfully.");

        loadDevices();

    } else {

        alert("Failed to update device.");

    }

})
.catch(function (error) {

    console.error(error);

    alert("Connection error.");

});

        editingRow.cells[0].innerHTML =
            "<strong>" + deviceName + "</strong>";

        editingRow.cells[1].textContent =
            deviceType;

        editingRow.cells[2].textContent =
            deviceLocation;

        editingRow.cells[3].innerHTML =
            '<span class="status ' +
            statusClass +
            '">' +
            deviceStatus +
            "</span>";

        editingRow.cells[4].textContent =
            "Just now";

        editingRow = null;

    }


    /* -------------------------
       Add New Device
    ------------------------- */

    else {

        const newRow =
            document.createElement("tr");

        newRow.innerHTML = `
            <td>
                <strong>${deviceName}</strong>
            </td>

            <td>
                ${deviceType}
            </td>

            <td>
                ${deviceLocation}
            </td>

            <td>
                <span class="status ${statusClass}">
                    ${deviceStatus}
                </span>
            </td>

            <td>
                Just now
            </td>

            <td>

                <button
                    class="view-device-btn"
                    type="button"
                >
                    View Details
                </button>

                <button
                    class="edit-device-btn"
                    type="button"
                >
                    Edit
                </button>

                <button
                    class="delete-device-btn"
                    type="button"
                >
                    Delete
                </button>

            </td>
        `;

        deviceTableBody.appendChild(newRow);

        setupRowButtons(newRow);

    }


    addDeviceForm.style.display = "none";

    deviceNameInput.value = "";
    deviceTypeInput.value = "";
    deviceLocationInput.value = "";
    deviceStatusInput.value = "Online";

    updateDevices();
    updateSummary();

});


/* -------------------------
   Setup Row Buttons
------------------------- */

function setupRowButtons(row) {

    const viewButton =
        row.querySelector(".view-device-btn");

    const editButton =
        row.querySelector(".edit-device-btn");

    const deleteButton =
        row.querySelector(".delete-device-btn");


    /* -------------------------
       View Details
    ------------------------- */

    if (viewButton) {

        viewButton.addEventListener("click", function () {

            detailName.textContent =
                row.cells[0].textContent.trim();

            detailType.textContent =
                row.cells[1].textContent.trim();

            detailLocation.textContent =
                row.cells[2].textContent.trim();

            detailStatus.textContent =
                row.querySelector(".status").textContent.trim();

            detailUpdate.textContent =
                row.cells[4].textContent.trim();

            deviceModal.style.display = "flex";

        });

    }


    /* -------------------------
       Edit
    ------------------------- */

    editButton.addEventListener("click", function () {

        editingRow = row;

        const deviceName =
            row.cells[0].textContent.trim();

        const deviceType =
            row.cells[1].textContent.trim();

        const deviceLocation =
            row.cells[2].textContent.trim();

        const deviceStatus =
            row.querySelector(".status").textContent.trim();


        deviceNameInput.value =
            deviceName;

        deviceTypeInput.value =
            deviceType;

        deviceLocationInput.value =
            deviceLocation;

        deviceStatusInput.value =
            deviceStatus;


        addDeviceForm.style.display =
            "block";

        document.querySelector(".form-title").textContent =
            "Edit Device";

        saveDeviceButton.textContent =
            "Save Changes";

    });


    /* -------------------------
       Delete
    ------------------------- */

    deleteButton.addEventListener("click", function () {

        const deviceName =
            row.cells[0].textContent.trim();

        const confirmDelete =
            confirm(
                "Delete " + deviceName + "?"
            );

        if (confirmDelete) {

    const deviceId =
        row.dataset.deviceId;

    const formData =
        new URLSearchParams();

    formData.append("id", deviceId);

    fetch("../api/devices.php", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {

        if (data.success) {

            alert("Device deleted successfully.");

            row.remove();

            updateDevices();
            updateSummary();

        } else {

            alert("Failed to delete device.");

        }

    })
    .catch(function (error) {

        console.error(error);

        alert("Connection error.");

    });

}

    });

}


/* -------------------------
   Existing Rows
------------------------- */

const existingRows =
    document.querySelectorAll(
        ".device-table tbody tr"
    );

existingRows.forEach(function (row) {

    setupRowButtons(row);

});


/* -------------------------
   Search Events
------------------------- */

searchInput.addEventListener(
    "input",
    updateDevices
);

filterSelect.addEventListener(
    "change",
    updateDevices
);


/* -------------------------
   Initial Summary
------------------------- */

updateSummary();


/* -------------------------
   Close Device Modal
------------------------- */

closeDeviceModal.addEventListener(
    "click",
    function () {

        deviceModal.style.display =
            "none";

    }
);


/* -------------------------
   Close Modal Outside
------------------------- */

deviceModal.addEventListener(
    "click",
    function (event) {

        if (event.target === deviceModal) {

            deviceModal.style.display =
                "none";

        }

    }
);

/* -------------------------
   Load Devices from API
------------------------- */

function loadDevices() {

    fetch("../api/devices.php")
        .then(function (response) {
            return response.json();
        })
        .then(function (devices) {
            console.log(devices);
            deviceTableBody.innerHTML = "";

devices.forEach(function (device) {

    let statusClass = device.status.toLowerCase();

    const newRow = document.createElement("tr");

    newRow.dataset.deviceId = device.id;

    newRow.innerHTML = `
        <td>
            <strong>${device.name}</strong>
        </td>

        <td>
            ${device.type}
        </td>

        <td>
            ${device.location}
        </td>

        <td>
            <span class="status ${statusClass}">
                ${device.status}
            </span>
        </td>

        <td>
            ${device.last_update}
        </td>

        <td>

            <button
                class="view-device-btn"
                type="button"
            >
                View Details
            </button>

            <button
                class="edit-device-btn"
                type="button"
            >
                Edit
            </button>

            <button
                class="delete-device-btn"
                type="button"
            >
                Delete
            </button>

        </td>
    `;

    deviceTableBody.appendChild(newRow);

    setupRowButtons(newRow);

});

updateDevices();
updateSummary();

        })
        .catch(function (error) {

            console.error(
                "Failed to load devices:",
                error
            );

        });

}

loadDevices();