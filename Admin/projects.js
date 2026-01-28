document.addEventListener("DOMContentLoaded", () => {

const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");

const projectName = document.getElementById("projectName");
const projectType = document.getElementById("projectType");
const locationInput = document.getElementById("location");
const capacity = document.getElementById("capacity");
const description = document.getElementById("description");
const images = document.getElementById("images");
const batery = document.getElementById("batery");
const innerver = document.getElementById("innerver");
const savingInput = document.getElementById("savingInput");
const status = document.getElementById("status");

let editingRow = null;

/* ===== LỌC ===== */
searchInput.addEventListener("input", filterProjects);
statusFilter.addEventListener("change", filterProjects);

function filterProjects() {
    const keyword = searchInput.value.toLowerCase();
    const stt = statusFilter.value;

    document.querySelectorAll("#projectList tr").forEach(row => {
        const text = row.innerText.toLowerCase();
        const rowStatus = row.cells[9].innerText.trim();

        row.style.display =
            text.includes(keyword) && (stt === "" || rowStatus === stt)
                ? ""
                : "none";
    });
}

/* ===== MODAL ===== */
window.openModal = function () {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("modalTitle").innerText = "Thêm dự án";
    clearForm();
    editingRow = null;
};

window.closeModal = function () {
    document.getElementById("modal").style.display = "none";
};

/* ===== CLEAR ===== */
function clearForm() {
    projectName.value = "";
    projectType.value = "";
    locationInput.value = "";
    capacity.value = "";
    description.value = "";
    images.value = "";
    batery.value = "";
    innerver.value = "";
    savingInput.value = "";
    status.value = "Đang thi công";
}

/* ===== LƯU ===== */
window.saveProject = function () {
    const name = projectName.value.trim();
    const type = projectType.value.trim();
    const loc = locationInput.value.trim();
    const cap = capacity.value.trim();

    if (!name || !type || !loc || !cap) {
        alert("Vui lòng nhập đầy đủ thông tin bắt buộc!");
        return;
    }

    const imgHTML = images.value
        ? `<img src="${images.value}" style="width:80px">`
        : "";

    if (editingRow) {
        editingRow.cells[0].innerText = name;
        editingRow.cells[1].innerText = type;
        editingRow.cells[2].innerText = loc;
        editingRow.cells[3].innerText = cap;
        editingRow.cells[4].innerText = description.value;
        editingRow.cells[5].innerHTML = imgHTML;
        editingRow.cells[6].innerText = batery.value;
        editingRow.cells[7].innerText = innerver.value;
        editingRow.cells[8].innerText = savingInput.value;
        editingRow.cells[9].innerHTML =
            `<span class="status ${status.value === "Hoàn thành" ? "success" : "pending"}">${status.value}</span>`;
    } else {
        const row = document.getElementById("projectList").insertRow();
        row.innerHTML = `
            <td>${name}</td>
            <td>${type}</td>
            <td>${loc}</td>
            <td>${cap}</td>
            <td>${description.value}</td>
            <td>${imgHTML}</td>
            <td>${batery.value}</td>
            <td>${innerver.value}</td>
            <td>${savingInput.value}</td>
            <td><span class="status ${status.value === "Hoàn thành" ? "success" : "pending"}">${status.value}</span></td>
            <td>
                <button onclick="editProject(this)">Sửa</button>
                <button onclick="deleteRow(this)">Xóa</button>
            </td>
        `;
    }

    closeModal();
};

/* ===== SỬA ===== */
window.editProject = function (btn) {
    editingRow = btn.closest("tr");
    document.getElementById("modalTitle").innerText = "Sửa dự án";

    projectName.value = editingRow.cells[0].innerText;
    projectType.value = editingRow.cells[1].innerText;
    locationInput.value = editingRow.cells[2].innerText;
    capacity.value = editingRow.cells[3].innerText;
    description.value = editingRow.cells[4].innerText;

    const img = editingRow.cells[5].querySelector("img");
    images.value = img ? img.src : "";

    batery.value = editingRow.cells[6].innerText;
    innerver.value = editingRow.cells[7].innerText;
    savingInput.value = editingRow.cells[8].innerText;
    status.value = editingRow.cells[9].innerText.trim();

    document.getElementById("modal").style.display = "flex";
};

/* ===== XÓA ===== */
window.deleteRow = function (btn) {
    if (confirm("Bạn có chắc muốn xóa dự án này?")) {
        btn.closest("tr").remove();
    }
};

});
