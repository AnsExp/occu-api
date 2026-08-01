/**
 * Sets the value of all input elements with the class 'input-timezone' to the user's current timezone.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input.input-timezone').forEach(input => {
        input.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    });
});