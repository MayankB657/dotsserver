function showTab(eventTarget) {
    const tabClass = eventTarget.getAttribute('data-tab');
    const tabToShow = eventTarget.getAttribute('data-control');

    // select all the buttons with same data-tab attribute
    const tabButtons = document.querySelectorAll(`button.tab-control[data-tab="${tabClass}"]`);

    // select all div with `tabClass` class
    const tabDivs = document.querySelectorAll(`div.${tabClass}.tab-content`);

    // hide all divs
    tabDivs.forEach(div => {
        div.classList.remove('active');
    });

    // show selected div
    document.getElementById(tabToShow).classList.add('active');

    // remove active class from all buttons
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });

    // add active class to selected button
    eventTarget.classList.add('active');

}

function toggleTab(eventTarget) {
    const tabTarget = eventTarget.getAttribute('data-target');

    if(eventTarget.checked){
        document.getElementById(tabTarget).classList.add('active');
    } else {
        document.getElementById(tabTarget).classList.remove('active');
    }
}