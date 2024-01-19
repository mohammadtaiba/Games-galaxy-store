document.addEventListener('DOMContentLoaded', function () {
    let paymentMethodRadios = document.querySelectorAll('.payment-method-checkbox');
    let paymentMethodHiddenInput = document.getElementById('payment-method');

    let selectedRadio = document.querySelector('.payment-method-checkbox:checked');

    if (selectedRadio) {
        paymentMethodHiddenInput.value = selectedRadio.value;
    }

    paymentMethodRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            paymentMethodHiddenInput.value = this.value;
        });
    });
});