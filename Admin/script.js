// KHÁCHH HÀNG
let editingRow = null;

function openModal() {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("modalTitle").innerText = "Thêm khách hàng";
    clearForm();
    editingRow = null;
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function clearForm() {
    document.getElementById("name").value = "";
    document.getElementById("phone").value = "";
    document.getElementById("address").value = "";
    document.getElementById("status").value = "Chưa tư vấn";
}

/* LƯU (THÊM / SỬA) */
function saveCustomer() {
    const name = document.getElementById("name").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("address").value;
    const status = document.getElementById("status").value;

    if (!name || !phone || !address) {
        alert("Vui lòng nhập đầy đủ thông tin");
        return;
    }

    if (editingRow) {
        // SỬA
        editingRow.cells[0].innerText = name;
        editingRow.cells[1].innerText = phone;
        editingRow.cells[2].innerText = address;
        editingRow.cells[3].innerHTML =
            `<span class="status ${status === 'Đã tư vấn' ? 'success' : 'pending'}">${status}</span>`;
    } else {
        // THÊM
        const table = document.getElementById("customerList");
        const row = table.insertRow();

        row.innerHTML = `
            <td>${name}</td>
            <td>${phone}</td>
            <td>${address}</td>
            <td><span class="status ${status === 'Đã tư vấn' ? 'success' : 'pending'}">${status}</span></td>
            <td>
                <button class="edit" onclick="editCustomer(this)">Sửa</button>
                <button class="delete" onclick="deleteRow(this)">Xóa</button>
            </td>
        `;
    }

    closeModal();
}

/* MỞ FORM SỬA */
function editCustomer(btn) {
    editingRow = btn.closest("tr");

    document.getElementById("modalTitle").innerText = "Sửa khách hàng";
    document.getElementById("name").value = editingRow.cells[0].innerText;
    document.getElementById("phone").value = editingRow.cells[1].innerText;
    document.getElementById("address").value = editingRow.cells[2].innerText;
    document.getElementById("status").value =
        editingRow.cells[3].innerText.trim();

    openModal();
}

/* XÓA */
function deleteRow(btn) {
    if (confirm("Xóa khách hàng này?")) {
        btn.closest("tr").remove();
    }
}
