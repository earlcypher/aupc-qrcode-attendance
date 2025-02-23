// Form Hide/Show Function

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

// QR Code Download Function

function downloadQRCode() {
    const qrImage = document.getElementById('qrImage');
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.src = qrImage.src;
    img.onload = function() {
        canvas.width = img.width;
        canvas.height = img.height;
        context.drawImage(img, 0, 0);
        const dataURL = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.href = dataURL;
        link.download = 'aupc-qrcode.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
}