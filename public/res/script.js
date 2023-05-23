let target = document.querySelector(".drop_area");
let fileInput = document.querySelector("input");
const preview = document.querySelector(".preview");

target.addEventListener("dragover", (e) => {
    e.preventDefault();
    console.log(e);
    target.classList.add("dragging");
});

target.addEventListener("dragleave", () => {
    if (target.classList.contains("dragging")) {
        target.classList.remove("dragging");
    }
    if (target.classList.contains("dragging-error")) {
        target.classList.remove("dragging-error");
    }
});

const handleFileUpload = (e) => {
    const img = document.createElement("img");
    const pdfName = document.createElement("div");
    const removeBtn = document.createElement("a");

    pdfName.innerHTML = `${fileInput.value}`;
    removeBtn.innerHTML = "remove";
    removeBtn.href = "#";

    img.src = "./public/res/file-icon.png";
    preview.innerHTML = "";
    preview.appendChild(img);
    preview.appendChild(pdfName);
    preview.appendChild(removeBtn);

    removeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        fileInput.value = "";
        preview.remove();
    });
};

fileInput.addEventListener("change", (e) => handleFileUpload(e));

target.addEventListener("drop", (e) => {
    e.preventDefault();
    if (target.classList.contains("dragging")) {
        target.classList.remove("dragging");
    }
    if (target.classList.contains("dragging-error")) {
        target.classList.remove("dragging-error");
    }
    const files = e.dataTransfer.files || e.target.files;

    fileInput.files = files;

    handleFileUpload(e);
});