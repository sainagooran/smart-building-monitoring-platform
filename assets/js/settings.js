const buildingName = document.querySelector("#building-name");
const buildingLocation = document.querySelector("#building-location");
const timezone = document.querySelector("#timezone");

const saveButton = document.querySelector(".save-settings-btn");


function loadSettings() {

    fetch("../api/settings.php")
        .then(function (response) {
            return response.json();
        })
        .then(function (result) {

            if (result.success) {

                buildingName.value =
                    result.data.name;

                buildingLocation.value =
                    result.data.location.trim();

                timezone.value =
                    result.data.timezone;

            }

        })
        .catch(function (error) {

            console.error(
                "Failed to load settings:",
                error
            );

        });

}
loadSettings();

function saveSettings() {

    const name =
        buildingName.value.trim();

    const location =
        buildingLocation.value.trim();

    const selectedTimezone =
        timezone.value;


    if (name === "" || location === "") {

        alert("Please fill in all fields.");

        return;
    }


    const formData =
        new URLSearchParams();

    formData.append("name", name);
    formData.append("location", location);
    formData.append("timezone", selectedTimezone);


    fetch("../api/settings.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body: formData

    })
    .then(function (response) {
        return response.json();
    })
    .then(function (result) {

        if (result.success) {

            alert("Settings saved successfully.");

        } else {

            alert("Failed to save settings.");

        }

    })
    .catch(function (error) {

        console.error(
            "Failed to save settings:",
            error
        );

        alert("Connection error.");

    });

}

if (saveButton) {

    saveButton.addEventListener(
        "click",
        saveSettings
    );

}