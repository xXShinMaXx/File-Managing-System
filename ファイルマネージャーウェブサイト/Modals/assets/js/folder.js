const modal = document.getElementById("folderModal");

document.querySelector(".new-btn").onclick = () => {
    modal.style.display = "flex";
};

document.getElementById("cancelFolder").onclick = () => {
    modal.style.display = "none";
};

document.getElementById("createFolder").onclick = async () => {

    const name = document
        .getElementById("folderName")
        .value.trim();

    if(name===""){
        alert("フォルダ名を入力してください。");
        return;
    }

    const response = await fetch("api/create_folder.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"folder_name="+encodeURIComponent(name)

    });

    const result = await response.text();

    alert(result);

    modal.style.display="none";

    location.reload();

};

async function loadFolders(){

    const response = await fetch("api/get_folders.php");

    const folders = await response.json();

    const area = document.getElementById("fileArea");

    area.innerHTML="";

    folders.forEach(folder=>{

        area.innerHTML += `
        <div class="folder-card">

            <span class="material-icons">

                folder

            </span>

            <h3>${folder.folder_name}</h3>

        </div>
        `;

    });

}

loadFolders();