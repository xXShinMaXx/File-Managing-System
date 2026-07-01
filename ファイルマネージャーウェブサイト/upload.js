const uploadModal = document.getElementById("uploadModal");
const fileInput = document.getElementById("fileInput");
const browseBtn = document.getElementById("browseBtn");
const dropZone = document.getElementById("dropZone");

let selectedFiles = [];

browseBtn.onclick = () => fileInput.click();

fileInput.onchange = () => {

    selectedFiles = [...fileInput.files];

    showFiles();

};

dropZone.ondragover = (e)=>{

    e.preventDefault();

    dropZone.classList.add("dragover");

};

dropZone.ondragleave = ()=>{

    dropZone.classList.remove("dragover");

};

dropZone.ondrop = (e)=>{

    e.preventDefault();

    dropZone.classList.remove("dragover");

    selectedFiles = [...e.dataTransfer.files];

    showFiles();

};

function showFiles(){

    const list = document.getElementById("uploadList");

    list.innerHTML="";

    selectedFiles.forEach(file=>{

        list.innerHTML += `

        <div class="upload-item">

            <span>${file.name}</span>

            <span>${Math.round(file.size/1024)} KB</span>

        </div>

        `;

    });

}