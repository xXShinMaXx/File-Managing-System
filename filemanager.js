// ==========================
// FILE UPLOAD
// ==========================

// Define the main function correctly
window.uploadFiles = function(files) {
    console.log("Upload function triggered!"); // This will show in Console if triggered

    if (files.length === 0) {
        return;
    }

    const formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        formData.append("uploaded_file[]", files[i]);
    }

    fetch("upload.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log("Server response:", result);
        if (result.trim() === "success") {
            alert("Upload Successful!");
            location.reload();
        } else {
            alert("Upload Error: " + result);
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert("Upload Failed.");
    });
};

// Add the event listener at the bottom
window.addEventListener('load', function() {
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            console.log("File selected, triggering upload..."); // Check console for this
            if (e.target.files.length > 0) {
                window.uploadFiles(e.target.files);
            }
        });
    } else {
        console.error("fileInput not found in the DOM!");
    }
});