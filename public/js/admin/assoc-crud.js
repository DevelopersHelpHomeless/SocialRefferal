function initSearchPlaceFieldAutocomplete() {
    var searchPlaceField = document.getElementById("Assoc_searchOnMaps");
    var autocomplete = new google.maps.places.Autocomplete(searchPlaceField, {
        componentRestrictions: { country: ["fr"] },
        fields: [
            "place_id",
            "name",
            "formatted_address",
            "business_status",
            "formatted_phone_number",
            "geometry",
            "opening_hours",
            "address_components",
        ],
        types: ["establishment"],
    });
    autocomplete.addListener("place_changed", fillInAssoc);
}

function getLocalityFromAdressComponents(components) {
    var localityComponent = components.find(component => component.types.includes('locality'));
    return localityComponent ? localityComponent.long_name : null;
}

function fillInAssoc() {
    var place = this.getPlace();

    var locality = getLocalityFromAdressComponents(place.address_components);

    if (place.place_id) {
        document.getElementById("Assoc_placeId").value = place.place_id;
    }

    if (place.name) {
        document.getElementById("Assoc_nom").value = place.name;
    }

    if (place.formatted_address) {
        document.getElementById("Assoc_adresse").value = place.formatted_address;
    }

    if (place.formatted_phone_number) {
        document.getElementById("Assoc_telephone").value =
            place.formatted_phone_number;
    }

    if (place.geometry) {
        document.getElementById("Assoc_longitude").value =
            place.geometry.location.lng();
        document.getElementById("Assoc_latitude").value =
            place.geometry.location.lat();
    }

    if (locality) {
        var select = document.getElementById('Assoc_ville');
        var control = select.tomselect;
        var value = Object.keys(control.options).find((key) => {
            return control.options[key].text.toUpperCase() === locality.toUpperCase();
        });

        if (value) {
            control.addItem(value);
        }
    }

    if (place.opening_hours) {
        fillOpeningHoursFields(place.opening_hours);
    }
}

function fillOpeningHoursFields(openingHoursData) {
    var addButton = document.querySelector('.field-collection-add-button');
    var collection = addButton.closest('[data-ea-collection-field]');

    var collectionItems = collection.querySelector('.form-widget-compound');
    if (collectionItems) {
        collectionItems.textContent = '';
    }

    openingHoursData.periods.sort((a, b) => (a.open.day === 0) ? 1 : ((b.open.day === 0) ? -1 : a.open.day - b.open.day)).forEach((period) => {
        addButton.click();
        var nbItems = collection.dataset.numItems;
        var jourIndexSelect = document.getElementById('Assoc_ouverture_' + nbItems + '_jourIndex');
        var heureDebutHourSelect = document.getElementById('Assoc_ouverture_' + nbItems + '_heureDebut_hour');
        var heureDebutMinuteSelect = document.getElementById('Assoc_ouverture_' + nbItems + '_heureDebut_minute');
        var heureFinHourSelect = document.getElementById('Assoc_ouverture_' + nbItems + '_heureFin_hour');
        var heureFinMinuteSelect = document.getElementById('Assoc_ouverture_' + nbItems + '_heureFin_minute');

        var adjustedDay = period.open.day === 0 ? 7 : period.open.day;

        jourIndexSelect.value = adjustedDay.toString();
        heureDebutHourSelect.value = parseInt(period.open.time.substring(0, 2));
        heureDebutMinuteSelect.value = parseInt(period.open.time.substring(2));
        heureFinHourSelect.value = parseInt(period.close.time.substring(0, 2));
        heureFinMinuteSelect.value = parseInt(period.close.time.substring(2));
    });
}

window.addEventListener("load", initSearchPlaceFieldAutocomplete);
