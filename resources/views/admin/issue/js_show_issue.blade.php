<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById("selectElementLuaran");
        let selectedValue = selectElement.value

        // INISIASI FORM INPUT
        const jenisBuku = document.getElementById("jenisBuku");
        const isbnBuku = document.getElementById("isbnBuku");
        const levelPublikasi = document.getElementById("levelPublikasi");
        const linkPublikasi = document.getElementById("linkPublikasi");
        const jenisPublikasi = document.getElementById("jenisPublikasi");
        const jenisHakCipta = document.getElementById("jenisHakCipta");
        const noHakCipta = document.getElementById("noHakCipta");
        jenisBuku.disabled = true;
        isbnBuku.disabled = true;
        levelPublikasi.disabled = true;
        linkPublikasi.disabled = true;
        jenisHakCipta.disabled = true;
        jenisPublikasi.disabled = true;
        noHakCipta.disabled = true;

        // HILANGKAN NOREK DAN BANK SAAT MEMILIH PENULIS DARI PIHAK LUAR/EKSTERNAL
        const elPenulisJabatan = document.getElementsByClassName('penulis_jabatan');
        const tjb_child = document.getElementsByClassName('input_penulis_bank');
        const tnr_child = document.getElementsByClassName('input_penulis_norek');
        for (let i = 0; i < elPenulisJabatan.length; i++) {
            if (elPenulisJabatan[i].value == 3) {
                tjb_child[i].type = "hidden"
                tnr_child[i].type = "hidden"
                tjb_child[i].value = ""
                tnr_child[i].value = ""
            } else {
                tjb_child[i].type = "text"
                tnr_child[i].type = "number"
            }
        }

        // const pBank = document.querySelector('.input_penulis_bank');
        // const pNorek = document.querySelector('.input_penulis_norek');

        // pBank.disabled = true
        // pNorek.disabled = true
        document.addEventListener('change', (event) => {
            if (event.target.classList.contains('penulis_jabatan')) {
                const tjb = event.target.parentElement;
                const tjb_child = tjb.querySelector('.input_penulis_bank');
                const tnr_child = tjb.querySelector('.input_penulis_norek');

                tjb_child.disabled = true
                tnr_child.disabled = true

                // TIDAK DIIZINKAN PENULIS PERTAMA DARI LUAR/EKSTERNAL
                if (event.target.value == 3) {
                    if (tjb.querySelector('.form_input_penulis_utama').value != 0) {
                        tjb_child.type = "hidden"
                        tnr_child.type = "hidden"
                        tjb_child.value = ""
                        tnr_child.value = ""
                    }
                } else {
                    tjb_child.type = "text"
                    tnr_child.type = "number"
                }
            }
        })
    })



</script>