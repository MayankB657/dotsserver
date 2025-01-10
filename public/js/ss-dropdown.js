function singleSelectPut(eventTarget) {
    console.log("asdas");
    const target = eventTarget.getAttribute('data-put');

    document.getElementById(target).innerHTML = eventTarget.value;
}