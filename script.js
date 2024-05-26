function ShowHiddenDiv(divId, triggerId) {
    var div = document.getElementById(divId);
    var trigger = document.getElementById(triggerId);

    if (div.style.display === "block") {
        div.style.display = "none";
    } else {
        div.style.display = "block";
    }

    document.addEventListener("click", function (event) {
        var isClickInside = trigger.contains(event.target) || div.contains(event.target);
        if (!isClickInside) {
            div.style.display = "none";
        }
    });
}

function UpdateSpanValue(spanId, className){
    var span = document.getElementById(spanId);
    var checkboxes = document.querySelectorAll(className);
    var selectedValues = [];

    checkboxes.forEach(function (cb) {
        if (cb.checked) {
            selectedValues.push(cb.value);
        }
    });

    if (selectedValues.length > 0) {
        span.textContent = selectedValues.join(', ');
    } else {
        span.textContent = 'Wybierz';
    }
}
