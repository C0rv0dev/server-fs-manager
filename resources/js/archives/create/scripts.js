import { formatBytes } from "../../helpers.js";

document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.getElementById("filesInput");
    const folderInput = document.getElementById("foldersInput");

    if (!fileInput || !folderInput) return;

    fileInput.addEventListener("change", handleInput);
    folderInput.addEventListener("change", handleInput);

    function handleInput(e) {
        const allFiles = [...fileInput.files, ...folderInput.files];

        let totalSize = 0;
        let tree = {};

        for (let file of allFiles) {
            totalSize += file.size;

            let pathParts = file.webkitRelativePath
                ? file.webkitRelativePath.split("/")
                : [file.name];

            let current = tree;

            pathParts.forEach((part, index) => {
                if (index === pathParts.length - 1) {
                    current[part] = { __file: true, size: file.size };
                } else {
                    if (!current[part]) current[part] = {};
                    current = current[part];
                }
            });
        }

        document.getElementById("totalSize").innerText = formatBytes(totalSize);
        document.getElementById("treePreview").innerHTML = buildTreeHtml(tree);

        // Folder collapse
        document.querySelectorAll(".folder").forEach((folder) => {
            folder.addEventListener("click", () => {
                const content = folder.nextElementSibling;
                if (content.style.display === "none") {
                    content.style.display = "block";
                } else {
                    content.style.display = "none";
                }
            });
        });
    }

    function buildTreeHtml(tree) {
        let html = "<ul>";

        const keys = Object.keys(tree).sort((a, b) => {
            const aIsFile = tree[a].__file;
            const bIsFile = tree[b].__file;

            if (aIsFile !== bIsFile) return aIsFile ? 1 : -1;
            return a.localeCompare(b);
        });

        for (let key of keys) {
            if (tree[key].__file) {
                html += `<li class="file">${key}</li>`;
            } else {
                html += `
                    <li>
                        <span class="folder">${key}</span>
                        ${buildTreeHtml(tree[key])}
                    </li>
                `;
            }
        }

        html += "</ul>";
        return html;
    }
});
