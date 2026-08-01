/**
 * Sets the value of all input elements with the class 'input-timezone' to the user's current timezone.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('button.copy-button').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.getAttribute('data-content');
            const contentCopied = button.getAttribute('data-content-copied');
            navigator.clipboard.writeText(content).then(() => {
                button.textContent = contentCopied;
                setTimeout(() => {
                    button.textContent = button.getAttribute('data-text');
                }, 2000);
            });
        });
    });
});