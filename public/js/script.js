$(document).ready(function () {
    getData();
    getDataSelect();
    function showData(res) {
        let html = "";
        res.barang.map((element) => {
            html += `
                           <div class="col-3">
                                <p>Nama : ${element.nama}</p>
                                 <img src="/storage/gambar/${element.gambar}" class="mx-auto"
                                     style="width: 100px;height:110px" alt="" srcset="">
                                 <p class="mx-auto">Harga :<input type="number" class="form-control" name="harga_jual" value="${element.harga_jual}" readonly>  </p>
                                 <p class="mx-auto">Stok : <input type="number" class="form-control" name="stok" value="${element.stok}" readonly> </p>
                                 <a href="/dashboard/tambah-keranjang" data-id="${element.id}"
                                     class="btn btn-primary tambah-cart">Tambah Ke
                                     Keranjang</a>
                                 </br>
                             </div>
                    `;
        });
        document.getElementById("daftar_barang").innerHTML = html;
        getDataCart();
    }
    function getData(idBarang = "") {
        fetch(
            "/dashboard/daftar-barang?" +
                new URLSearchParams(`barang=${idBarang}`).toString()
        )
            .then((res) => res.json())
            .then((res) => {
                showData(res);
            })
            .catch((err) => console.log(err));
    }
    $(document).on("click", ".tambah-cart", function (e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        const data = {
            id: id,
        };
        fetch("/dashboard/tambah-cart", {
            method: "POST",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify(data),
        })
            .then((res) => res.json())
            .then((res) => {
                if (res.status === "sudah-ada") {
                    Swal.fire({
                        icon: "error",
                        title: "Barang Sudah Ada Di Cart",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else if (res.status === true) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Tambah Barang Dicart",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
                getDataCart();
            })
            .catch((err) => console.log(err));
        getData();
        getDataSelect();
    });
    function getDataCart() {
        fetch("/dashboard/lihat-cart")
            .then((res) => res.json())
            .then((res) => showCart(res))
            .catch((err) => console.log(err));
    }
    function showCart(res) {
        let html = "";
        document.getElementById(
            "total-cart"
        ).innerHTML = `Total : Rp. ${rupiahFormat(res.total)}`;
        document.getElementById(
            "bayar-btn"
        ).innerHTML = `  <button class="btn btn-primary mx-5 my-1" id="bayar">
                         Bayar
                     </button>`;
        res.cart.map((element, index) => {
            html += `
                    <div class="col-5">
                    <img src="/storage/gambar/${element.barang.gambar}" style="width: 50px;height: 60px" alt="sdfdsf" srcset="">
                    <p>${element.barang.nama}</p>
                    </div>
                    <div class="col-7">
                    <button class="btn btn-danger my-2" data-id="${element.id}" id="delete-cart">Hapus</button>
                        <input type="number" class="form-control" min="1" max="${element.barang["stok"]}" id="increment-cart" data-id="${element.id},${element.barang.id}" value="${element.jumlah}">
                    </div>
            `;
        });
        document.getElementById("daftar-cart").innerHTML = html;
    }
    $("#cari-barang").change(function () {
        let idBarang = $(this).val();
        getData(idBarang);
    });
    $(document).on("change", "#increment-cart", function () {
        let idConcat = $(this).attr("data-id").split(",");
        let jumlah = $(this).val();
        const data = {
            idCart: idConcat[0],
            idBarang: idConcat[1],
            jumlah: jumlah,
        };
        fetch("/dashboard/update-cart", {
            method: "PATCH",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify(data),
        })
            .then((res) => res.json())
            .then((res) => {
                console.log(res);
                getDataCart();
            })
            .catch((err) => console.log(err));
    });
    $(document).on("click", "#delete-cart", function () {
        let id = $(this).attr("data-id");
        console.log(id);
        const data = {
            id: id,
        };
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Apakah Anda Yakin ?",
                text: "Menghapus Cart",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Tidak",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    fetch("/dashboard/delete-cart", {
                        method: "DELETE",
                        cache: "no-cache",
                        credentials: "same-origin",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        body: JSON.stringify(data),
                    })
                        .then((res) => {
                            console.log(res);
                            swalWithBootstrapButtons.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            getDataCart();
                            getData();
                            getDataSelect();
                        })
                        .catch((err) => console.log(err));
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    );
                }
            });
    });
    function showDataSelect(res) {
        console.log(res);
        let html = ' <option value=""> --- Pilih Barang ---- </option>';
        res.barang.map((elem) => {
            html += `
                <option value="${elem.id}"> ${elem.nama} </option>
            `;
        });
        document.getElementById("cari-barang").innerHTML = html;
    }
    function getDataSelect() {
        fetch("/dashboard/select-barang")
            .then((res) => res.json())
            .then((res) => {
                showDataSelect(res);
            })
            .catch((err) => console.log(err));
    }
    $(document).on("click", "#bayar", function () {
        fetch("/dashboard/bayar", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        })
            .then((res) => res.json())
            .then((res) => {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil Tambah Barang Dicart",
                    showConfirmButton: false,
                    timer: 1500,
                });
                getDataCart();
            })
            .catch((err) => console.log(err));
    });
    function rupiahFormat(bilangan) {
        let reverse = bilangan.toString().split("").reverse().join(""),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join(".").split("").reverse().join("");
        return ribuan;
    }
});
