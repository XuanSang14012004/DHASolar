<script>
let quotes = JSON.parse(localStorage.getItem("quotes")) || [
    {
        id: 1,
        name: "Nguyễn Văn A",
        phone: "0987654321",
        system: "Gia đình",
        power: "5 kWp",
        price: "120.000.000đ",
        status: "Chờ duyệt",
        date: "20/01/2026"
    }
];

function saveQuotes() {
    localStorage.setItem("quotes", JSON.stringify(quotes));
}

function renderQuotes() {
    const table = document.getElementById("quoteTable");
    table.innerHTML = "";

    quotes.forEach((q, index) => {
        table.innerHTML += `
        <tr>
            <td>${index + 1}</td>
            <td>${q.name}</td>
            <td>${q.phone}</td>
            <td>${q.system}</td>
            <td>${q.power}</td>
            <td>${q.price}</td>
            <td>
                <span class="status ${q.status === 'Đã gửi' ? 'approved' : 'pending'}">
                    ${q.status}
                </span>
            </td>
            <td>${q.date}</td>
            <td>
                <button class="btn view" onclick="viewQuote(${q.id})">Xem</button>
                <button class="btn delete" onclick="deleteQuote(${q.id})">Xóa</button>
            </td>
        </tr>
        `;
    });
}

function addQuote() {
    const name = prompt("Tên khách hàng:");
    if (!name) return;

    const phone = prompt("Số điện thoại:");
    const system = prompt("Loại hệ thống:");
    const power = prompt("Công suất:");
    const price = prompt("Giá dự kiến:");

    const newQuote = {
        id: Date.now(),
        name,
        phone,
        system,
        power,
        price,
        status: "Chờ duyệt",
        date: new Date().toLocaleDateString("vi-VN")
    };

    quotes.push(newQuote);
    saveQuotes();
    renderQuotes();
}

function viewQuote(id) {
    const q = quotes.find(item => item.id === id);
    alert(
        `KHÁCH HÀNG: ${q.name}
SĐT: ${q.phone}
HỆ THỐNG: ${q.system}
CÔNG SUẤT: ${q.power}
GIÁ: ${q.price}
TRẠNG THÁI: ${q.status}`
    );
}

function deleteQuote(id) {
    if (!confirm("Bạn có chắc muốn xóa báo giá này?")) return;
    quotes = quotes.filter(q => q.id !== id);
    saveQuotes();
    renderQuotes();
}

renderQuotes();
</script>
