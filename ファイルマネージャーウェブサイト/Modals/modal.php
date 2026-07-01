<div id="uploadModal" class="modal">

    <div class="modal-content">

        <h2>ファイルをアップロード</h2>

        <div id="dropZone">

            <span class="material-icons">
                cloud_upload
            </span>

            <p>

                ファイルをここへドラッグ

            </p>

            <input
                type="file"
                id="fileInput"
                multiple
                hidden>

            <button id="browseBtn">

                ファイルを選択

            </button>

        </div>

        <div id="uploadList"></div>

        <button id="startUpload">

            アップロード

        </button>

    </div>

</div>