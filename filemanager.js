// ==========================
// GRID / LIST VIEW
// ==========================

const grid = document.getElementById("gridContainer");
const list = document.getElementById("listContainer");

const gridBtn = document.getElementById("gridView");
const listBtn = document.getElementById("listView");

if (gridBtn && listBtn) {

    gridBtn.addEventListener("click", function () {
        grid.classList.add("active");
        grid.classList.remove("hide");

        list.classList.remove("active");
    });

    listBtn.addEventListener("click", function () {
        grid.classList.remove("active");
        grid.classList.add("hide");

        list.classList.add("active");
    });

}

// ==========================
// SEARCH
// ==========================

const searchInput = document.getElementById("searchInput");

if (searchInput) {

    searchInput.addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase();

        // Grid Cards
        document.querySelectorAll(".file-card").forEach(card => {

            const name = card.dataset.name;

            if (name.includes(keyword)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }

        });

        // Table Rows
        document.querySelectorAll("#listContainer tbody tr").forEach(row => {

            const name = row.dataset.name;

            if (name.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

        });

    });

}

// ==========================
// DRAG & DROP
// ==========================

const dropZone = document.getElementById("dropZone");

if (dropZone) {

    dropZone.addEventListener("dragover", function (e) {

        e.preventDefault();

        dropZone.classList.add("drag");

    });

    dropZone.addEventListener("dragleave", function () {

        dropZone.classList.remove("drag");

    });

    dropZone.addEventListener("drop", function (e) {

        e.preventDefault();

        dropZone.classList.remove("drag");

        uploadFiles(e.dataTransfer.files);

    });

}

// ==========================
// FILE UPLOAD
// ==========================

function uploadFiles(files){

    if(files.length === 0){
        return;
    }

    const formData = new FormData();

    for(let i = 0; i < files.length; i++){
        formData.append("uploaded_file", files[i]);
    }

    fetch("upload.php",{
        method:"POST",
        body:formData
    })

    .then(response => response.text())

    .then(result => {

        console.log(result);

        if(result.trim() === "success"){

            alert("Upload Successful!");

            location.reload();

        }else{

            alert(result);

        }

    })

    .catch(error=>{

        console.error(error);

        alert("Upload Failed.");

    });

}