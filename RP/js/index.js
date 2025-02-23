document.addEventListener('DOMContentLoaded', () => {
    const form1 = document.getElementById('form1');
    const form2 = document.getElementById('form2');
    const header = document.getElementById('form-header');

    // Initialize with form1 visible
    form1.style.display = 'none';
    form2.style.display = 'block';

    window.showForm = (formId, headerText) => {
        form1.style.display = formId === 'form1' ? 'block' : 'none';
        form2.style.display = formId === 'form2' ? 'block' : 'none';
        header.textContent = headerText;
    };
});