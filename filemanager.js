alert("filemanager.js loaded");

console.log("filemanager.js loaded");

/* ======================================================
   FileSphere File Manager
   filemanager.js
====================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
       ELEMENTS
    ========================================== */

    const gridContainer = document.getElementById("gridContainer");
    const listContainer = document.getElementById("listContainer");

    const gridBtn = document.getElementById("gridView");
    const listBtn = document.getElementById("listView");

    const searchInput = document.getElementById("searchInput");

    const dropZone = document.getElementById("dropZone");

    const fileInput = document.getElementById("fileInput");


    /* ==========================================
       GRID / LIST VIEW
    ========================================== */

    if (gridBtn && listBtn) {

        gridBtn.addEventListener("click", () => {

            gridContainer.classList.add("active");
            gridContainer.classList.remove("hide");

            listContainer.classList.remove("active");

        });

        listBtn.addEventListener("click", () => {

            gridContainer.classList.remove("active");
            gridContainer.classList.add("hide");

            listContainer.classList.add("active");

        });

    }


    /* ==========================================
       SEARCH
    ========================================== */

    if (searchInput) {

        searchInput.addEventListener("keyup", function () {

            const keyword = this.value.toLowerCase();

            // Grid
            document.querySelectorAll(".file-card").forEach(card => {

                const filename = card.dataset.name;

                card.style.display =
                    filename.includes(keyword) ? "" : "none";

            });

            // List
            document.querySelectorAll("#listContainer tbody tr").forEach(row => {

                const filename = row.dataset.name;

                row.style.display =
                    filename.includes(keyword) ? "" : "none";

            });

        });

    }


    /* ==========================================
       FILE INPUT
    ========================================== */

    if (fileInput) {

        fileInput.addEventListener("change", function () {

            if (this.files.length > 0) {

                uploadFiles(this.files);

            }

        });

    }


    /* ==========================================
       DRAG & DROP
    ========================================== */

    if (dropZone) {

        dropZone.addEventListener("dragenter", e => {

            e.preventDefault();

            dropZone.classList.add("drag");

        });

        dropZone.addEventListener("dragover", e => {

            e.preventDefault();

            dropZone.classList.add("drag");

        });

        dropZone.addEventListener("dragleave", e => {

            e.preventDefault();

            dropZone.classList.remove("drag");

        });

        dropZone.addEventListener("drop", e => {

            e.preventDefault();

            dropZone.classList.remove("drag");

            uploadFiles(e.dataTransfer.files);

        });

    }

});


/* ==========================================
   UPLOAD FILES
========================================== */

function uploadFiles(files) {

    if (!files || files.length === 0) return;

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

        console.log("Server:", result);

        if (result.trim() === "success") {

            alert("Upload Successful!");

            location.reload();

        } else {

            alert(result);

        }

    })
    .catch(error => {

        console.error(error);

        alert("Upload Failed.");

    });

}

window.openShareModal = function(id, filename){

    alert("Share button clicked!");

    document.getElementById("shareModal").style.display = "flex";
    document.getElementById("shareFileId").value = id;
    document.getElementById("shareFileName").textContent = filename;

}

window.closeShareModal = function(){

    document.getElementById("shareModal").style.display = "none";

}

window.testShare = function () {
    alert("JavaScript is working!");
}