import { formatBytes } from "../../helpers.js";

document.addEventListener("alpine:init", () => {
    Alpine.data("fileTree", () => ({
        nodes: [],
        files: [],

        init() {
            const fileInput = document.getElementById("filesInput");
            const folderInput = document.getElementById("foldersInput");

            fileInput.addEventListener("change", () => this.load());
            folderInput.addEventListener("change", () => this.load());
        },

        load() {
            const fileInput = document.getElementById("filesInput");
            const folderInput = document.getElementById("foldersInput");
            const totalSize = document.getElementById("totalSize");

            const allFiles = [...fileInput.files, ...folderInput.files];

            this.files = allFiles;
            this.nodes = this.buildTree(allFiles);

            const total = allFiles.reduce((sum, f) => sum + f.size, 0);
            totalSize.innerText = formatBytes(total);

            this.render();
        },

        buildTree(files) {
            const map = {};

            files.forEach((file) => {
                const relPath = file.webkitRelativePath || file.name;
                const parts = relPath.split("/");

                let current = map;

                parts.forEach((part, i) => {
                    if (!current[part]) {
                        current[part] = {
                            name: part,
                            __file: i === parts.length - 1,
                            size: file.size,
                            children: {},
                        };
                    }

                    if (i < parts.length - 1) {
                        current = current[part].children;
                    }
                });
            });

            const normalize = (obj) =>
                Object.values(obj)
                    .sort((a, b) => {
                        if (a.__file !== b.__file) return a.__file ? 1 : -1;
                        return a.name.localeCompare(b.name);
                    })
                    .map((n) => ({
                        ...n,
                        children: normalize(n.children || {}),
                    }));

            return normalize(map);
        },

        render() {
            const root = this.$refs.treeRoot;
            root.innerHTML = "";

            const ul = document.createElement("ul");
            root.appendChild(ul);

            this.nodes.forEach((node) => {
                ul.appendChild(this.createNode(node));
            });
        },

        createNode(node) {
            const li = document.createElement("li");
            li.id = node.__file ? node.__file : node.name;

            li.addEventListener("click", (e) => {
                e.stopPropagation();

                const childList = li.querySelector(":scope > ul");
                if (childList) {
                    childList.style.display =
                        childList.style.display === "none" ? "block" : "none";
                }
            });

            const wrapper = document.createElement("div");
            wrapper.className = "tree-item";

            const name = document.createElement("span");
            name.className = node.__file ? "file" : "folder";
            name.innerText = node.name;

            wrapper.appendChild(name);

            if (node.__file) {
                const size = document.createElement("span");
                size.className = "muted";
                size.innerText = ` (${formatBytes(node.size)})`;
                wrapper.appendChild(size);
            }

            li.appendChild(wrapper);

            if (!node.__file && node.children.length) {
                const childList = document.createElement("ul");

                node.children.forEach((child) => {
                    childList.appendChild(this.createNode(child));
                });

                li.appendChild(childList);
            }

            return li;
        },
    }));
});
